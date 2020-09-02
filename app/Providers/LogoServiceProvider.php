<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\GroupScout;
use App\Models\GroupScoutUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LogoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'vendor.adminlte.page',
            'App\Http\ViewComposers\Logotipo'
        ); 
    }
}
