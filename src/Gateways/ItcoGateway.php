<?php

namespace Pamenary\LaravelSms\Gateways;

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/08/2017
 * Time: 12:51 PM
 */
class ItcoGateway extends GatewayAbstract
{

    /**
     * AzinwebGateway constructor.
     */
    public function __construct()
    {

        $this->webService = config('sms.gateway.itco.webService');
        $this->username   = config('sms.gateway.itco.username');
        $this->password   = config('sms.gateway.itco.password');
        $this->from       = config('sms.gateway.itco.from');
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
        if (is_array($numbers)) {
            $i = sizeOf($numbers);

            while ($i--) {
                $numbers[ $i ] = self::correctNumber($numbers[ $i ]);
            }
        } else {
            $numbers = self::correctNumber($to);
        }
        //        dd($numbers);

        // Check credit for the gateway
        if (!$this->GetCredit())
            return;
        try {
            $client = new \SoapClient($this->webService);

            $result = $client->SendSMS($this->from, $numbers, $text, $this->username, $this->password);

            return $result;
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }


    /**
     * @return mixed
     */
    public function getCredit()
    {
        if (!$this->username and !$this->password)
            return 'Blank Username && Password';
        try {
            $client = new \SoapClient($this->webService, ['login' => $this->username, 'password' => $this->password]);
            $params = [
                "user" => $this->username,
                "pass" => $this->password,
            ];

            return $client->__call('GetCredit', $params);
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }

    public static function correctNumber(&$uNumber)
    {
        $uNumber = trim($uNumber);
        $ret     = &$uNumber;

        if (substr($uNumber, 0, 3) == '%2B') {
            $ret     = substr($uNumber, 3);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 3) == '%2b') {
            $ret     = substr($uNumber, 3);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 4) == '0098') {
            $ret     = substr($uNumber, 4);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 3) == '098') {
            $ret     = substr($uNumber, 3);
            $uNumber = $ret;
        }


        if (substr($uNumber, 0, 3) == '+98') {
            $ret     = substr($uNumber, 3);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 2) == '98') {
            $ret     = substr($uNumber, 2);
            $uNumber = $ret;
        }

        if (substr($uNumber, 0, 1) == '0') {
            $ret     = substr($uNumber, 1);
            $uNumber = $ret;
        }

        return '+98' . $ret;
    }

}