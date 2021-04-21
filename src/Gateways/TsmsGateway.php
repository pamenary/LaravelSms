<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Mahdi pishguy pishguy@gmail.com
 * Date: 12/23/2016
 * Time: 12:51 PM
 */
class TsmsGateway extends GatewayAbstract
{

    /**
     * AfeGateway constructor.
     */
    public function __construct()
    {

        $this->webService = config('sms.gateway.tsms.webService');
        $this->username = config('sms.gateway.tsms.username');
        $this->password = config('sms.gateway.tsms.password');
        $this->from = config('sms.gateway.tsms.from');
    }


    /**
     * @param array $numbers
     * @param       $text
     * @param bool $isflash
     *
     * @return mixed
     * @internal param $to | array
     */
    public function sendSMS(array $numbers, $text, $isflash = false)
    {
        if (!$this->GetCredit()) return;
        try {
            $api = new \SoapClient($this->webService);
            $api->sendSms(
                $this->username,
                $this->password,
                [$this->from],
                $numbers,
                [$text],
                [],
                rand()
            );
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }


    /**
     * @return mixed
     */
    public function getCredit()
    {
        try {
            $client = new \SoapClient($this->webService);

            $result = $client->UserInfo($this->username,$this->password);
            return $result[0]->credit;
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }

}
