<?php

namespace NovaButton\Providers;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-button', '../../dist/js/field.js');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoutes();
    }

    /**
     * Registers field routes
     *
     * @return void
     */
    private function registerRoutes()
    {
        // Route::domain(config('nova.domain', null))
        //     ->middleware(config('nova.middleware', []))
        //     ->prefix('/nova-vendor/nova-button')
        //     ->group('NovaButton\Http\Routes\api.php');
    }
}
