<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class BearsmsGateway extends GatewayAbstract {

	/**
	 * BearsmsGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.bearsms.webService');
		$this->username    = config('sms.gateway.bearsms.username');
		$this->password    = config('sms.gateway.bearsms.password');
		$this->from        = config('sms.gateway.bearsms.from');
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

		$to = implode(',', $numbers);
		$msg = urlencode($text);

		$result = file_get_contents($this->webService.'&u='.$this->username.'&h='.$this->password.'&op=pv&to='.$to.'&msg='.$msg);
		$result_arr = json_decode($result);

		if($result_arr->data[0]->status == 'ERR')
			return;

		return $result;
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		$result = file_get_contents($this->webService.'&u='.$this->username.'&h='.$this->password.'&op=cr');
		$result_arr = json_decode($result);

		if($result_arr->status == 'ERR')
			return;

		return $result_arr->credit;
	}

}