<?php

namespace Elite\StrowalletLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class StrowalletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Merge config if needed
        $this->mergeConfigFrom(__DIR__.'/../config/strowallet.php', 'strowallet');

        // Bind Strowallet class into the container
        $this->app->singleton(Strowallet::class, function ($app) {
            return new Strowallet();
        });
    }

    /**
     * Bootstrap services.
     */

     public function boot()
     {
         $this->publishes([
             __DIR__.'/../config/strowallet.php' => config_path('strowallet.php'),
         ], 'strowallet-config'); // use a unique tag
         
         if ($this->app->runningInConsole()) {
             $loader = \Illuminate\Foundation\AliasLoader::getInstance();
             $loader->alias('Strowallet', \Elite\StrowalletLaravel\StrowalletFacade::class);
         }
     }
     
    
}
