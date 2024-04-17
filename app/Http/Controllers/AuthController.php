<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RegistrationNotification;
use Ichtrojan\Otp\Models\Otp as ModelsOtp;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use HttpResponses;

    // Register a new user
       public function register (StoreUserRequest $request)
    {
        $request ->validated($request->all());
        $user = User::create([
          'name' =>$request->name,
          'email' =>$request->email,
          'password'=>Hash::make($request->password),
        ]);
        $user->notify(new RegistrationNotification());
        return $this->success([
            'user' =>$user,
            'token' =>$user->createToken('Api token of' . $user->name)->plainTextToken
        ]);
    }

    // Login an existeng user
    public function login (LoginUserRequest $request)
    {
        $request -> validated($request->all());
        if (!Auth::attempt($request->only(['email','password']))) {
            return $this->error('','The credintials dont match', 405);
        }
        $user = User::where('email', $request->email)->first();
        return $this->success([
            'user' =>$user,
            'token' =>$user->createToken('Api token of' . $user->name)->plainTextToken
        ]);
    }
   
    // Logout a user 
    public function logout (){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message'=> Auth::user()->name .' ,you have successfully logged out and your token has been deleted'
        ]);
    }

    //otp handling
    public function ForgetPass(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->firstOrFail();
        $user->notify(new OtpNotification());

        return response()->json(['message' => 'OTP sent to your email.']);
    }
    protected $otpService;

    public function __construct(Otp $otp)
    {
        $this->otpService = $otp;
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $validationResult = $this->otpService->validate($user->email, $request->otp);
        if ($validationResult->status) {
            return response()->json(['message' => $validationResult->message], 200);
        } else {
            return response()->json(['message' => $validationResult->message], 422);
        }
    }

}
