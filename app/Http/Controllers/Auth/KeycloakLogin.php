<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;



use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Council;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


class KeycloakLogin extends Controller
{

    public function redirectToKeycloak()
    {
        return Socialite::driver('keycloak')
            ->scopes(['openid', 'email', 'profile', 'roles'])
            ->redirect();
    }

    public function handleKeycloakCallback()
    {
        $user = Socialite::driver('keycloak')->user();
        $decodedToken = base64_decode(explode('.', $user->token)[1]);
        $decodedToken = json_decode($decodedToken);

        $roles = $decodedToken->realm_access->roles;

        $relevantRoles = $this->filterRelevantRoles($roles);
        $councils = $this->extractCouncilsFromRoles($relevantRoles);

        $isAdmin = in_array('beschlussarchiv:admin', $roles);

        // SSO User has no council assigned
        if (!count($councils)) {
            return redirect()->route('login')->with('error', 'Du hast keine Berechtigung für diese Anwendung');
        }

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $this->updateUser($existingUser, $councils, $isAdmin);
            Auth::login($existingUser, true);
        } else {
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->admin = $isAdmin ? true : false;
            $newUser->save();
            $newUser->councils()->attach($councils);
            Auth::login($newUser, true);
        }

        // Redirect to the intended URL or a default URL
        return redirect()->route('admin.dashboard');
    }

    private function validateRole(string $role): bool
    {
        // should be of syntac council:<name>
        $roleParts = explode(':', $role);
        if (count($roleParts) !== 2) {
            return false;
        }
        if ($roleParts[0] !== 'council') {
            return false;
        }
        return true;
    }

    private function filterRelevantRoles(array $roles): array
    {
        return array_filter($roles, function ($role) {
            return $this->validateRole($role);
        });
    }

    private function extractCouncilsFromRoles(array $roles)
    {
        $councils = collect();
        foreach ($roles as $role) {
            $roleParts = explode(':', $role);
            $councilName = str_replace("-", "", Str::slug($roleParts[1]));
            $council = Council::where('slug', $councilName)->first();
            if ($council) {
                $councils->push($council);
            }
        }
        return $councils;
    }

    private function updateUser(User $user, Collection $councils, bool $isAdmin): void
    {
        $user->admin = $isAdmin;
        $user->save();
        $user->councils()->sync($councils->pluck('id')->toArray());
    }
}
