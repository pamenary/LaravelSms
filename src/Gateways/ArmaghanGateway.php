<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class ArmaghanGateway extends GatewayAbstract {

	/**
	 * FortytwoGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.armaghan.webService');
		$this->username    = config('sms.gateway.armaghan.username');
		$this->password    = config('sms.gateway.armaghan.password');
		$this->from        = config('sms.gateway.armaghan.from');
	}


	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 * @return mixed
	 * @internal param $to | array
	 */


    public function sendSMS( array $numbers, $text, $isflash = false ) {

        if(!$this->GetCredit()) return;

        $number = implode(',', $numbers);
        $msg    = urlencode(trim($text));
        $smss  = $this->webService.'originator='.$this->from.'&destination='.$number.'&content='.$msg.'&password='.$this->password.'&username='.$this->username;
        $ch = curl_init($smss);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $google = curl_exec($ch);
        curl_close($ch);
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
