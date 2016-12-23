<?php

namespace Pamenary\LaravelSms;

use Pamenary\LaravelSms\Gateways\GatewayInterface;
use Pamenary\LaravelSms\Gateways\AzinwebGateway;

class Sms
{
	private $gateway;
	private $username;
	private $password;
	private $from;


	/**
	 * Sms constructor.
	 *
	 * @param GatewayInterface|null $gateway
	 */
	public function __construct(GatewayInterface $gateway = null) {
		ini_set("soap.wsdl_cache_enabled", "0");
		$defaultGateway = config('sms.default');

		$Gateways = config('sms.gateway');

		if (is_null($gateway)) {
			$gateway = new AzinwebGateway();

		}
		$this->gateway  = $gateway;
		$this->gateway->webService  = $Gateways[$defaultGateway]['webService'];
		$this->gateway->username    = $Gateways[$defaultGateway]['username'];
		$this->gateway->password    = $Gateways[$defaultGateway]['password'];
		$this->gateway->from        = $Gateways[$defaultGateway]['from'];
	}

	/**
	 * @param      $to
	 * @param      $text
	 * @param bool $isflash
	 *
	 * @return mixed|object
	 */
	public function sendSMS( $to, $text, $isflash = false ) {
		return $this->gateway->sendSMS($to, $text, $isflash);
	}

	/**
	 * @return int|mixed
	 */
	public function getCredit() {

		return $this->gateway->getCredit();
	}

}