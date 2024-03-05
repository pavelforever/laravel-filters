<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }
    function callback($provider) {
        try{
            $socialUser = Socialite::driver($provider)->user();
            $user = User::where('email',$socialUser->email)->first();
            
            if(!$user){
                $user = User::create([
                    'name' => $socialUser->name ?? $socialUser->nickname,
                    'email' => $socialUser->email,
                ]);
            }
    
            $user->socials()->updateOrCreate([
                'provider_id' => $socialUser->id,
                'provider' => $provider,
                'provider_token' => $socialUser->token,
            ]);
    
            Auth::login($user);
            return redirect()->route('main');

        }catch(\Exception $ex){
            return redirect()->route('login')->withErrors("Sign in by $provider failed.Please Try again");
        }
    }
}
