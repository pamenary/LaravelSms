<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class PostgahGateway extends GatewayAbstract {


    private $getCreditWebService;

	/**
	 * AzinwebGateway constructor.
	 */
	public function __construct() {

		$this->webService   = config('sms.gateway.postgah.webService');
		$this->username     = config('sms.gateway.postgah.username');
		$this->password     = config('sms.gateway.postgah.password');
		$this->from         = config('sms.gateway.postgah.from');
		$this->getCreditWebService  = config('sms.gateway.postgah.getCredit');
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

        $webService = $this->webService;

        $params = [
					'username' => $this->username,
					'password' => $this->password,
					'from'     => $this->from,
					'to'       => implode(',', $numbers),
					'text'     => $text,
					'flash'    => $isflash,
					'udh'      => '',
				];

        $response = $this->curlURL($webService, $params);

        return $response;
    }


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';
		try {

            $webService = $this->getCreditWebService;

			$params = [
                "username" => $this->username,
                "password" => $this->password,
            ];

			return $this->curlURL($webService, $params);

		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

	private function curlURL($webService, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webService);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($ch);

        return $response;
    }

}