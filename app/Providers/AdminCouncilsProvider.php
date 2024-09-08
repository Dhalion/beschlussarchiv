<?php

namespace App\Providers;

use App\Models\Council;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AdminCouncilsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer("layouts.admin", function ($view) {
            if (Auth::check()) {
                $user = Auth::getUser();
                $councils = $user->admin ? Council::all() : $user->councils;
                $view->with('councils', $councils ?? []);
            }
        });
    }
}
