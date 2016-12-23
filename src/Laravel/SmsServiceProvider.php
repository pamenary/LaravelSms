<?php

namespace Pamenary\LaravelSms\Laravel;

use Pamenary\LaravelSms\Gateways\AzinwebGateway;
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
	    $this->loadRoutesFrom( __DIR__ . '/routes.php' );
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
			$gateway = config('sms.default', 'default');
			switch ($gateway)
			{
				case 'azinweb':
					$gateway = new AzinwebGateway();
					break;
				default:
					$gateway = new AzinwebGateway();
					break;
			}

			return new Sms($gateway);
		});
    }
}
