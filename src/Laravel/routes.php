<?php
use Pamenary\LaravelSms\Sms;
//use Pamenary\LaravelSms\Laravel\Facade\Sms;
Route::get('tessssss', function(){
	$sms = new Sms(new \Pamenary\LaravelSms\Gateways\AdpdigitalGateway());
//	dd(Sms::getCredit());
	dd($sms->sendSMS(['09213766198', '09136000498', '09213766187'], 'سلام'));
	dd($sms->getCredit());
});