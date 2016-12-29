<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class HostiranGateway extends GatewayAbstract {

	/**
	 * HostiranGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.hostiran.webService');
		$this->username    = config('sms.gateway.hostiran.username');
		$this->password    = config('sms.gateway.hostiran.password');
		$this->from        = config('sms.gateway.hostiran.from');
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
		// Check credit for the gateway
		if(!$this->GetCredit()) return;
		try {
			$options = array('login' => $this->username, 'password' => $this->password);
			$client = new \SoapClient($this->webService, $options);
			$result = $client->sendToMany($numbers, $text, $this->from);

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

		$options = array('login' => $this->username, 'password' => $this->password);
		$client = new SoapClient($this->webService, $options);

		try
		{
			$credit = $client->accountInfo();
			return $credit->remaining;
		}
		catch (SoapFault $sf)
		{
			return $sf->faultcode."\n" . $sf->faultstring."\n";
		}
	}

}