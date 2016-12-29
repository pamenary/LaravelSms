<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class AfilnetGateway extends GatewayAbstract {

	/**
	 * AfilnetGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.afilnet.webService');
		$this->username    = config('sms.gateway.afilnet.username');
		$this->password    = config('sms.gateway.afilnet.password');
		$this->from        = config('sms.gateway.afilnet.from');
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
			$result = $client->SendSMSPlusArray($this->username, $this->password, $this->from, '34', $numbers, $text, 1, 0);

			return $result;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return false;
		try {
			$result = $client->Credits($this->username, $this->password);
			return $result;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}