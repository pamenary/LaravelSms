<?php

namespace Pamenary\LaravelSms\Laravel;

use Pamenary\LaravelSms\Gateways\AzinwebGateway;
use Pamenary\LaravelSms\Gateways\GatewayAbstract;
use Illuminate\Support\ServiceProvider;
use Pamenary\LaravelSms\Sms;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	    $this->publishes([
		                     __DIR__.'/config/sms.php' => config_path('sms.php'),
	                     ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->mergeConfigFrom(
		    __DIR__.'/config/sms.php', 'sms'
	    );

		$this->app->singleton('Sms', function(){
			return new Sms();
		});
    }
}
