<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\loginotifaication;

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
        $user->notify(new loginotifaication());
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
}
