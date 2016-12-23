<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 12/23/2016
 * Time: 6:09 PM
 */

namespace Pamenary\LaravelSms\Gateways;


abstract class GatewayAbstract implements GatewayInterface {
	public $webService;
	public $username;
	public $password;
	public $from;
}