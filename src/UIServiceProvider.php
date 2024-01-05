<?php

namespace AppKit\UI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class UIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'ui');
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ui');
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/ui.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('ui.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/ui'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/ui'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/ui'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'appkit-ui');

        // Register the main class to use with the facade
        $this->app->singleton('ui', function () {
            return new UI();
        });

        // define the source of the views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'appkit-ui');

        // setup the component namespace
        Blade::componentNamespace('AppKit\\UI\\Components', 'appkit');
    }
}
