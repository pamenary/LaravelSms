<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class AdpdigitalGateway extends GatewayAbstract {

	/**
	 * AdpdigitalGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.adpdigital.webService');
		$this->username    = config('sms.gateway.adpdigital.username');
		$this->password    = config('sms.gateway.adpdigital.password');
		$this->from        = config('sms.gateway.adpdigital.from');
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

		$to = str_replace("09", "989", implode($numbers, ","));
		$msg = urlencode($text);

		$result = file_get_contents("{$this->webService}send?username={$this->username}&password={$this->password}&dstaddress={$to}&body={$msg}&clientid={$this->from}&type=text&unicode=1");

		return $result->Code;
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		$result = file_get_contents("{$this->webService}balance?username={$this->username}&password={$this->password}&facility=send");

		if( strstr($result, 'ERR') ) {
			return 0;
		} else {
			return preg_replace('/[^0-9]/', '', $result);
		}
	}

}