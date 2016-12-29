<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class BulutfonGateway extends GatewayAbstract {

	/**
	 * BulutfonGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.bulutfon.webService');
		$this->username    = config('sms.gateway.bulutfon.username');
		$this->password    = config('sms.gateway.bulutfon.password');
		$this->from        = config('sms.gateway.bulutfon.from');
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

		$msg = urlencode($text);

		$data = array(
			'title'	=> $this->from,
			'email' => $this->username,
			'password' => $this->password,
			'receivers' => implode(',',$numbers),
			'content' => $text,
		);

		$data = http_build_query($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->webService);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$result = curl_exec($ch);
		$json = json_decode($result, true);

		if($result) {
			return $json;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		$result = file_get_contents('https://api.bulutfon.com/me'.'?email='.$this->username.'&password='.$this->password);
		$result_arr = json_decode($result);


		return $result_arr->credit->sms_credit;
	}

}