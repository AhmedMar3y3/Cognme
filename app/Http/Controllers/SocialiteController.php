<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
class SocialiteController extends Controller
{
    public function redirectToGoogle(){
    $redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

    return response()->json(['redirect_url' => $redirectUrl]);
    }
    public function handleCallback()
{
    try {
        $user = Socialite::driver('google')
            ->scopes(['openid', 'email', 'profile'])
            ->stateless()
            ->user();

        $findUser = User::where('provider_id', $user->id)->first();

        if ($findUser) {
            Auth::login($findUser);
            return $this->respondWithToken($findUser);
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'provider_id' => $user->id,
                'provider_name' => 'google', 
                'password' => bcrypt('my-google')
            ]);

            Auth::login($newUser);
            return $this->respondWithToken($newUser);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

protected function respondWithToken($user)
{
    $token = $user->createToken('sanctum-access-token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}



    public function redirectToFacebook()
    {
        return response()->json([
            'redirect_url' => Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl()
        ]);
    }
    public function Callback(Request $request)
    {
    try {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $user = User::where('provider_id', $facebookUser->id)->first();

        if (!$user) {
            $user = new User();
        }
        $user->name = $facebookUser->name;
        $user->email = $facebookUser->email;
        $user->provider_id = $facebookUser->id;
        $user->provider_name = 'facebook';
        $user->save();
        $token = $user->createToken('socialite-access-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
    }


    
}  
}