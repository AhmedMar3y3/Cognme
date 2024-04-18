<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\PasswordReset;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\RegistrationNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    use HttpResponses;

    // Register a new user
       public function register (StoreUserRequest $request){
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
    public function login (LoginUserRequest $request){
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
    

    //forget pass
    public function ForgetPass(Request $request){
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->firstOrFail();
        $user->notify(new OtpNotification());

        return response()->json(['message' => 'OTP sent to your email.']);
    }
   
    
    protected $otpService;
    public function __construct(Otp $otp){
        $this->otpService = $otp;
    }
    //otp verification
    public function verifyOtp(Request $request){
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
            $token = Hash::make(Str::random(40)); 
            PasswordReset::updateOrCreate(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );
            return response()->json(['message' => $validationResult->message . ' Token: ' . $token], 200);
        } else {
            return response()->json(['message' => $validationResult->message], 422);
        }
    }
    

    //reset password
    public function resetPassword(Request $request){
        $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);
        //extract token from authorization header
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        if (empty($token)) {
            return response()->json(['message' => 'Token is required'], 422);
        }
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid or expired token'], 422);
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        //update user's password
        $user->password = Hash::make($request->password);
        $user->save();
        //delete the token after using it
        $passwordReset->delete();
        return response()->json(['message' => 'Password has been reset successfully'], 200);
    }

 // Logout a user 
 public function logout (){
    Auth::user()->currentAccessToken()->delete();
    return $this->success([
        'message'=> Auth::user()->name .' ,you have successfully logged out and your token has been deleted'
    ]);
}


}
