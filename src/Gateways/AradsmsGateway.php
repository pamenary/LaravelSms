<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/24/2016
 * Time: 7:14 PM
 */

namespace Pamenary\LaravelSms\Gateways;


class AradsmsGateway extends GatewayAbstract {
	/**
	 * AradsmsGateway constructor.
	 */
	public function __construct() {
		$this->webService = config( 'sms.gateway.azinweb.webService' );
		$this->username   = config( 'sms.gateway.azinweb.username' );
		$this->password   = config( 'sms.gateway.azinweb.password' );
		$this->from       = config( 'sms.gateway.azinweb.from' );
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