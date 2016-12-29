<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class Dot4allGateway extends GatewayAbstract {

	/**
	 * Dot4allGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.dot4all.webService');
		$this->username    = config('sms.gateway.dot4all.username');
		$this->password    = config('sms.gateway.dot4all.password');
		$this->from        = config('sms.gateway.dot4all.from');
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

		$to = implode(',', $numbers);
		$msg = urlencode($text);

		$result = file_get_contents("{$this->webService}batch.php?user={$this->username}&pass={$this->password}&rcpt={$to}&data={$msg}&sender={$this->from}&qty=n");

		if ($result == 1) {
			return $result;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';

		$result = file_get_contents("{$this->webService}credit.php?user={$this->username}&pass={$this->password}");

		if(strchr($result, 'OK')) {
			return preg_replace('/[^0-9]+/', '', $result);
		} else {
			return false;
		}
	}

}