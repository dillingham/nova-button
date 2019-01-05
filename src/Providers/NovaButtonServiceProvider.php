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
        $this->publishes([ __DIR__.'\..\..\config\nova-button.php' => config_path('nova-button.php')], 'nova-button');

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-button', __DIR__.'/../../dist/js/field.js');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'\..\..\config\nova-button.php', 'nova-button');

        $this->registerRoutes();
    }

    /**
     * Registers field routes
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::domain(config('nova.domain', null))
            ->middleware(config('nova.middleware', []))
            ->prefix('/nova-vendor/nova-button')
            ->group(__DIR__.'\..\Http\Routes\api.php');
    }
}
