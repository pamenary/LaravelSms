<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class AzinwebGateway extends GatewayAbstract {

	/**
	 * AzinwebGateway constructor.
	 */
	public function __construct() {

	}


	/**
	 * @param      $to | array
	 * @param      $text
	 * @param bool $isflash
	 *
	 * @return mixed
	 */
	public function sendSMS( $to, $text, $isflash = false ) {
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
					'to'       => $to,
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