<?php
use Pamenary\LaravelSms\Sms;
Route::get('tessssss', function(){
	$sms = new Sms();
	dd($sms->getCredit());
	dd($sms->sendSMS(['09213766187'], 'سلام'));
});