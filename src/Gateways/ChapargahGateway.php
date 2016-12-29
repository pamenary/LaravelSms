<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class ChapargahGateway extends GatewayAbstract {

	/**
	 * ChapargahGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.chapargah.webService');
		$this->username    = config('sms.gateway.chapargah.username');
		$this->password    = config('sms.gateway.chapargah.password');
		$this->from        = config('sms.gateway.chapargah.from');
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
			if(!$this->GetCredit()) return;

			$client = new \SoapClient( $this->webService );

			$result = $client->SendSms(
				array(
					'username'	=> $this->username,
					'password'	=> $this->password,
					'from'		=> $this->from,
					'to'		=> $numbers,
					'text'		=> $text,
					'flash'		=> $isflash,
					'udh'		=> ''
				)
			);

			if($result) {
				return $result;
			}
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

			$result = $client->Credit(array('username' => $this->username, 'password' => $this->password));
			return $result->CreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}