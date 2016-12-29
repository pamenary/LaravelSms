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
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 *
	 * @return mixed
	 */
	public function sendSMS(array $numbers, $text, $isflash = false);

	/**
	 * @return int
	 */
	public function getCredit();
}