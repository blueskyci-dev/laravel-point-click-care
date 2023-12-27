<?php

namespace AtumSystems\PointClickCare;

use Illuminate\Support\ServiceProvider;

class PointClickCareServiceProvider extends ServiceProvider {

    /**
     * Register any application services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PointClickCare::class, function ($app) {
            return new PointClickCare;
        });
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/point-click-care.php' => config_path('point-click-care.php'),
        ]);
    }

}