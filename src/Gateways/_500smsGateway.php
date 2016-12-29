<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class _500smsGateway extends GatewayAbstract {

	/**
	 * _500smsGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway._500sms.webService');
		$this->username    = config('sms.gateway._500sms.username');
		$this->password    = config('sms.gateway._500sms.password');
		$this->from        = config('sms.gateway._500sms.from');
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

		$client = new SoapClient($this->webService);
		$result = $client->send_sms($this->username, $this->password, $this->from, implode($numbers, ","), $text);

		return $result;
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		$client = new SoapClient($this->webService);
		return $client->sms_credit($this->username, $this->password);
	}

}