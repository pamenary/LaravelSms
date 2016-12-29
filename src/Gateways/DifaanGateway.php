<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class DifaanGateway extends GatewayAbstract {

	/**
	 * DifaanGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.difaan.webService');
		$this->username    = config('sms.gateway.difaan.username');
		$this->password    = config('sms.gateway.difaan.password');
		$this->from        = config('sms.gateway.difaan.from');
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

		// Check credit for the gateway
		if(!$this->GetCredit()) return;

		$msg    = urlencode($text);
		$result = null;
		foreach($numbers as $number) {
			$result = file_get_contents("{$this->webService}sendsms_url.html?login={$this->username}&pass={$this->password}&from={$this->from}&to={$number}&msg={$msg}");
		}

		if ($result) {
			return $result;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';
		return 1;
	}

}