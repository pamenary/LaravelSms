<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class AfeGateway extends GatewayAbstract {

	/**
	 * AfeGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.afe.webService');
		$this->username    = config('sms.gateway.afe.username');
		$this->password    = config('sms.gateway.afe.password');
		$this->from        = config('sms.gateway.afe.from');
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
		try {
			// Check credit for the gateway
			if ( ! $this->GetCredit() ) {
				return false;
			}
			$client = new \SoapClient('http://www.afe.ir/WebService/V4/BoxService.asmx?WSDL');
			if($isflash) {
				$type = 0;
			} else {
				$type = 1;
			}

			$param = array(
				'Username'	=> $this->username,
				'Password'	=> $this->password,
				'Number'	=> $this->from,
				'Mobile'	=> $numbers,
				'Message'	=> $text,
				'Type'		=> $type
			);

			$result = $client->SendMessage($param);
			$result = $result->SendMessageResult->string;

			return $result;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		try {
			$client = new \SoapClient( $this->webService );

			$result = $client->GetRemainingCredit( array('Username' => $this->username, 'Password' => $this->password) );
			return $result->GetRemainingCreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}