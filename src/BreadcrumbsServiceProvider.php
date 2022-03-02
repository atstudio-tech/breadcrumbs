<?php

namespace Atorscho\Breadcrumbs;

use Illuminate\Support\ServiceProvider;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'../config/breadcrumbs.php' => config_path('breadcrumbs.php'),
        ], 'breadcrumbs');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'../config/breadcrumbs.php', 'breadcrumbs');
    }
}
