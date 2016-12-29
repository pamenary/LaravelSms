<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class _0098smsGateway extends GatewayAbstract {

	/**
	 * _0098smsGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway._0098sms.webService');
		$this->username    = config('sms.gateway._0098sms.username');
		$this->password    = config('sms.gateway._0098sms.password');
		$this->from        = config('sms.gateway._0098sms.from');
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

		foreach($numbers as $to) {
			$result = file_get_contents($this->webService."sendsmslink.aspx?FROM=".$this->from."&TO=".$to."&TEXT=".$text."&USERNAME=".$this->username."&PASSWORD=".$this->password."&DOMAIN=0098");
		}

		return $result->Code;
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username && !$this->password) return;

		return true;
	}

}