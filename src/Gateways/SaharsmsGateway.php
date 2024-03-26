<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class SaharsmsGateway extends GatewayAbstract {

	/**
	 * FortytwoGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.saharsms.webService');
		$this->username    = config('sms.gateway.saharsms.username');
		$this->password    = config('sms.gateway.saharsms.password');
		$this->from        = config('sms.gateway.saharsms.from');
	}


	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 * @return mixed
	 * @internal param $to | array
	 */


    public function sendSMS( array $numbers, $text, $isflash = false ) {


       // if(!$this->GetCredit()) return;


        $headers       = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );
        $text = str_replace(" ", "‌", $text); // کلید ALT رو نگه دارید و عدد 0157 رو تایپ کنید تا یک نیم فاصله براتون ایجاد بشه.

        $msg = explode('-', urlencode($text));

        $number = implode(',', $numbers);
        $smss  = $this->webService.'receptor='.$number.'&template=westclinic-17017&token='.$msg[0].'&token2='.$msg[1].'&token3='.$msg[2];

        $headers[] = 'Accept: text/html';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';

        $process = curl_init($smss);
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
