<?php

namespace ATStudio\Breadcrumbs;

use Illuminate\Routing\Route;
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
            __DIR__.'/../config/breadcrumbs.php' => config_path('breadcrumbs.php'),
        ], 'breadcrumbs');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/breadcrumbs.php', 'breadcrumbs');

        $this->registerSingleton();
        $this->registerMacros();
    }

    private function registerSingleton(): void
    {
        $this->app->singleton('crumbs', function () {
            return new BreadcrumbCollection();
        });
    }

    private function registerMacros(): void
    {
        Route::macro('crumbs', function (callable $closure) {
            crumbs($closure);

            return $this;
        });
    }
}
