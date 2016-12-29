<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class BestitGateway extends GatewayAbstract {

	/**
	 * BestitGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.bestit.webService');
		$this->username    = config('sms.gateway.bestit.username');
		$this->password    = config('sms.gateway.bestit.password');
		$this->from        = config('sms.gateway.bestit.from');
		$this->key         = config('sms.gateway.bestit.key');
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

			$result= $client->sendsms(
				array(
					'username'	=> $this->username,
					'password'	=> $this->password,
					'to'		=> implode(',', $numbers),
					'text'		=> $text,
					'from'		=> $this->from,
					'api'		=> $this->key,
				)
			);

			if(
				$result->sendsmsResult->long == 1000 or
				$result->sendsmsResult->long == 1001 or
				$result->sendsmsResult->long == 1002 or
				$result->sendsmsResult->long == 1003 or
				$result->sendsmsResult->long == 1004 or
				$result->sendsmsResult->long == 1005 or
				$result->sendsmsResult->long == 1006 or
				$result->sendsmsResult->long == 1007 or
				$result->sendsmsResult->long == 1008 or
				$result->sendsmsResult->long == 1009 or
				$result->sendsmsResult->long == 1010
			)
				return false;

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

			$result = $client->Credites(array('username' => $this->username, 'password' => $this->password));
			return $result->CreditesResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}