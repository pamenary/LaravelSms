<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 5:51 PM
 */

namespace Pamenary\LaravelSms\Gateways;


class AradsmsGateway implements GatewayInterface{
	/**
	 * @param      $to
	 * @param      $text
	 * @param bool $isflash
	 *
	 * @return mixed
	 */
	public function sendSMS( $to, $text, $isflash = false ) {
		// TODO: Implement sendSMS() method.
	}

	/**
	 * @return mixed
	 */
	public function getCredit() {
		// TODO: Implement getCredit() method.
	}

}