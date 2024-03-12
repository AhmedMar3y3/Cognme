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
    public function redirectToGoogle()
{
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
            return response()->json(['message' => 'Existing user authenticated successfully', 'user' => $findUser]);
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'provider_id' => $user->id,
                'provider_type' => 'google',
                'password' => bcrypt('my-google')
            ]);

            Auth::login($newUser);
            return response()->json(['message' => 'New user registered and authenticated', 'user' => $newUser]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}