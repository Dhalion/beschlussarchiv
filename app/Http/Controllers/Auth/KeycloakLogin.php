<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;



use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Council;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KeycloakLogin extends Controller
{

    public function redirectToKeycloak()
    {
        return Socialite::driver('keycloak')->redirect();
    }

    public function handleKeycloakCallback()
    {
        $user = Socialite::driver('keycloak')->user();
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->save();
            $newUser->councils()->attach(Council::where(('default'), true)->first());
            Auth::login($newUser, true);
        }

        // Redirect to the intended URL or a default URL
        return redirect()->route('admin.dashboard');
    }
}
