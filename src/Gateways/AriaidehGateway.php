<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 5:51 PM
 */

namespace Pamenary\LaravelSms\Gateways;


class AriaidehGateway extends GatewayAbstract{
	/**
	 * AriaidehGateway constructor.
	 */
	public function __construct() {
		$this->webService  = config('sms.gateway.ariaideh.webService');
		$this->username    = config('sms.gateway.ariaideh.username');
		$this->password    = config('sms.gateway.ariaideh.password');
		$this->from        = config('sms.gateway.ariaideh.from');
	}


	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 *
	 * @return bool
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
					'flash'    => $isflash,
					'udh'      => '',
				]
			);

			return $result;
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

			return $client->Credit( [
				                        "username" => $this->username,
				                        "password" => $this->password,
			                        ] )->CreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}