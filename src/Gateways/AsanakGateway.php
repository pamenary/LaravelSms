<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class AsanakGateway extends GatewayAbstract {

	/**
	 * AsanakGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.asanak.webService');
		$this->username    = config('sms.gateway.asanak.username');
		$this->password    = config('sms.gateway.asanak.password');
		$this->from        = config('sms.gateway.asanak.from');
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

		if(!$this->GetCredit()) return;

		$to = implode('-', $numbers);
		$msg = urlencode(trim($text));
		$url = $this->webService.'?username='.$this->username.'&password='.$this->password.'&source='.$this->from.'&destination='.$to.'&message='. $msg;

		$headers[] = 'Accept: text/html';
		$headers[] = 'Connection: Keep-Alive';
		$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';

		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);

		if(curl_exec($process)) {
			$result = $process;
			return $result;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username && !$this->password)
			return false;

		return true;
	}

}