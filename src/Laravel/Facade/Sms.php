<?php
namespace Pamenary\LaravelSms\Laravel\Facade;
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 1:52 PM
 */

use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'Sms';
	}
}
