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
	public $key;

	/**
	 * @param $defaultGateway
	 *
	 * @return AzinwebGateway
	 */
	public function initGateway( $defaultGateway ) {

		switch ( $defaultGateway ) {
			case 'azinweb':
				$gateway = new AzinwebGateway();
				break;
			case 'aradsms':
				$gateway = new AradsmsGateway();
				break;
			case 'ariaideh':
				$gateway = new AriaidehGateway();
				break;
			case '_0098sms':
				$gateway = new _0098smsGateway();
				break;
			case 'adpdigital':
				$gateway = new AdpdigitalGateway();
				break;
			case 'afe':
				$gateway = new AfeGateway();
				break;
			case 'afilnet':
				$gateway = new AfilnetGateway();
				break;
			case 'amansoft':
				$gateway = new AmansoftGateway();
				break;
			case 'arkapayamak':
				$gateway = new ArkapayamakGateway();
				break;
			case 'asanak':
				$gateway = new AsanakGateway();
				break;
			case 'asiapayamak':
				$gateway = new AsiapayamakGateway();
				break;
			case 'barmanpayamak':
				$gateway = new BarmanpayamakGateway();
				break;
			case 'barzinsms':
				$gateway = new BarzinsmsGateway();
				break;
			case 'bearsms':
				$gateway = new BearsmsGateway();
				break;
			case 'bestit':
				$gateway = new BestitGateway();
				break;
			case 'bulutfon':
				$gateway = new BulutfonGateway();
				break;
			case 'caffeweb':
				$gateway = new CaffewebGateway();
				break;
			case 'chapargah':
				$gateway = new ChapargahGateway();
				break;
			case 'chaparpanel':
				$gateway = new ChaparpanelGateway();
				break;
			case 'difaan':
				$gateway = new DifaanGateway();
				break;
			case 'dot4all':
				$gateway = new Dot4allGateway();
				break;
			case 'esms24':
				$gateway = new Esms24Gateway();
				break;
			case 'faraed':
				$gateway = new FaraedGateway();
				break;
			case 'farapayamak':
				$gateway = new FarapayamakGateway();
				break;
			case 'farazpayam':
				$gateway = new FarazpayamGateway();
				break;
			case 'fayasms':
				$gateway = new FayasmsGateway();
				break;
			case 'firstpayamak':
				$gateway = new FirstpayamakGateway();
				break;
			case 'fortytwo':
				$gateway = new FortytwoGateway();
				break;
			case 'freepayamak':
				$gateway = new FreepayamakGateway();
				break;
			default:
				$gateway = new AzinwebGateway();
				break;
		}

		return $gateway;
	}


}