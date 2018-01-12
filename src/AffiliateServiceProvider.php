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
	    $this->publishes([
		    __DIR__.'/config/settings.php' => config_path('affiliate.php'),
	    ]);

	    $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
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
