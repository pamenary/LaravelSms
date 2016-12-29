<?php

namespace Pamenary\LaravelSms;

use Pamenary\LaravelSms\Gateways\GatewayAbstract;
use Pamenary\LaravelSms\Gateways\GatewayInterface;
use Pamenary\LaravelSms\Gateways\AzinwebGateway;

class Sms extends GatewayAbstract
{
	private $gateway;

	/**
	 * Sms constructor.
	 *
	 * @param GatewayInterface|null $gateway
	 */
	public function __construct(GatewayInterface $gateway = null) {
		ini_set("soap.wsdl_cache_enabled", "0");
		$defaultGateway = config('sms.default');
		$this->gateway = $gateway;

		if (is_null($gateway)) {
			$this->gateway = $this->initGateway( $defaultGateway );
		}
	}


	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 *
	 * @return mixed
	 */
	public function sendSMS( array $numbers, $text, $isflash = false ) {
		return $this->gateway->sendSMS($numbers, $text, $isflash);
	}

	/**
	 * @return int|mixed
	 */
	public function getCredit() {

		return $this->gateway->getCredit();
	}


}