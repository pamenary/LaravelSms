<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class FortytwoGateway extends GatewayAbstract {

	/**
	 * FortytwoGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.fortytwo.webService');
		$this->username    = config('sms.gateway.fortytwo.username');
		$this->password    = config('sms.gateway.fortytwo.password');
		$this->from        = config('sms.gateway.fortytwo.from');
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
		$result = null;
		$msg    = urlencode($text);
		$route  = "G1";

		foreach($numbers as $number) {
			$result[] = file_get_contents($this->webService . "/send/message.php?username=".$this->username."&password=".$this->password."&to=".$number."&from=".$this->from."&message=".$msg."&route=".$route);
		}

		if($result) {
			return $result;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';

		return true;
	}

}