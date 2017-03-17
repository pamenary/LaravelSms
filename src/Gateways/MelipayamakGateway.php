<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class MelipayamakGateway extends GatewayAbstract {

	/**
	 * AdpdigitalGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.melipayamak.webService');
		$this->username    = config('sms.gateway.melipayamak.username');
		$this->password    = config('sms.gateway.melipayamak.password');
		$this->from        = config('sms.gateway.melipayamak.from');
	}


	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 *
	 * @return mixed
	 * @internal param $to | array
	 */
	public function sendSMS( array $numbers, $text, $isflash = false ) {
		try {
			// Check credit for the gateway
			if ( ! $this->GetCredit() ) {
				return false;
			}
			$client = new \SoapClient( $this->webService );
			$result = $client->SendSms(
				[
					'username' => $this->username,
					'password' => $this->password,
					'from'     => $this->from,
					'to'       => $numbers,
					'text'     => $text,
					'isflash'  => $isflash,
					'udh'      => '',
					'recId'    => [ 0 ],
					'status'   => 0x0,
				]
			);

			return $result->SendSmsResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		try {
			$client = new \SoapClient( $this->webService );

			return $client->GetCredit( [
				                           "username" => $this->username,
				                           "password" => $this->password,
			                           ] )->GetCreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}