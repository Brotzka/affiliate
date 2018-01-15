<?php

namespace Brotzka\Affiliate;

use Illuminate\Support\ServiceProvider;

class AffiliateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        define('PACKAGEPATH', __DIR__);
        
	    $this->publishes([
		    __DIR__.'/config/settings.php' => config_path('affiliate.php'),
	    ]);

	    $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'affiliate');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
