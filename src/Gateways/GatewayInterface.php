<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 5:54 PM
 */

namespace Pamenary\LaravelSms\Gateways;


interface GatewayInterface {
	/**
	 * @param $to
	 * @param $text
	 * @param $isflash
	 *
	 * @return object
	 */
	public function sendSMS($to, $text, $isflash = false);

	/**
	 * @return int
	 */
	public function getCredit();
}