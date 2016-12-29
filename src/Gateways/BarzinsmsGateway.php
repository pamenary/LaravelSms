<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class BarzinsmsGateway extends GatewayAbstract {

	/**
	 * BarzinsmsGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.barzinsms.webService');
		$this->username    = config('sms.gateway.barzinsms.username');
		$this->password    = config('sms.gateway.barzinsms.password');
		$this->from        = config('sms.gateway.barzinsms.from');
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
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';
		try {
			// Check credit for the gateway
			if ( ! $this->GetCredit() ) {
				return false;
			}
			$client = new \SoapClient( $this->webService );
			$parameters['username'] = $this->username;
			$parameters['password'] = $this->password;
			$parameters['from'] = $this->from;
			$parameters['to'] = $numbers;
			$parameters['text'] = $text;
			$parameters['isflash'] = $isflash;
			$parameters['udh'] = "";
			$parameters['recId'] = array(0);
			$parameters['status'] = 0x0;

			$result = $client->SendSms($parameters)->SendSmsResult;

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
			return 'Blank Username && Password';
		try {
			$client = new \SoapClient( $this->webService );

			return $client->GetCredit(array("username" => $this->username, "password" => $this->password))->GetCreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}