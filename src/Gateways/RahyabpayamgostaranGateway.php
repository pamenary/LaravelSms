<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class RahyabpayamgostaranGateway extends GatewayAbstract {

	/**
	 * AsiapayamakGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.rahyabpayamgostaran.webService');
		$this->username    = config('sms.gateway.rahyabpayamgostaran.username');
		$this->password    = config('sms.gateway.rahyabpayamgostaran.password');
		$this->from        = config('sms.gateway.rahyabpayamgostaran.from');
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
		try {
			// Check credit for the gateway
			if(!$this->GetCredit()) return;
            $soapClientObj = new \SoapClient($this->webService);
//            $soapClientObj = new SoapClient($this->webService);
            $parameters['username'] = $this->username;
            $parameters['password'] = $this->password;
            $parameters['from'] = $this->from;
            $parameters['to'] = $numbers;
            $parameters['text'] =$text;
            $parameters['isflash'] = false;
            $parameters['udh'] = "";
            $parameters['recId'] = array(0);
            $parameters['status'] = array(0);
            print_r($soapClientObj->SendSms($parameters));
            // retval :
            // InvalidUserPass = 0
            // Successfull = 1
            // NoCredit = 2
            // DailyLimit = 3
            // SendLimit = 4
            // InvalidNumber = 5

            // Status :
            // Sent = 0
            // Failed = 1
        } catch (SoapFault $fault) {
            echo  "$fault";
        }
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';
		try {
			$client = new \SoapClient( $this->webService );

			return $client->GetCredit(array("username" => $this->username, "password" => $this->password))->GetCreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}
