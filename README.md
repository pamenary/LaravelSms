# LaravelSms
package for send sms with laravel  (All gatways in Iran)

installation
------------
For install this package Edit your project's ```composer.json``` file to require pamenary/LaravelSms

```php
"require": {
  "pamenary/LaravelSms": "dev-master"
},
```

Now, update Composer:
```
composer update
```

Once composer is finished, you need to add the service provider. Open ```app/config/app.php```, and add a new item to the providers array.

```
Pamenary\LaravelSms\Laravel\SmsServiceProvider::class,
```

Next, add a Facade for more convenient usage. In ```app/config/app.php``` add the following line to the aliases array:

```
'Sms' => Pamenary\LaravelSms\Laravel\Facade\Sms::class,
```
Publish config files:
```
php artisan vendor:publish
```
for change username, password and other configuration change ```app/config/sms.php```

Usage
-----
### Send Message
```php
Sms::sendSMS(['09136000415', '09361265987', '09336505170'], 'text mesage'); // send message for persons
```
### Change Gateway

```php
$sms = new Sms(new \Pamenary\LaravelSms\Gateways\AzinwebGateway());

$sms->sendSMS(['09136000415', '09336505170'], 'text message');
```

### Get Credit
```php
Sms::getCredit();
```

### Gateway
https://azinweb.com/
http://arad-sms.ir
http://ariaideh.com
http://www.0098sms.com
http://500sms.ir
http://adpdigital.com/services
http://afe.ir
http://www.afilnet.com
http://sms.amansoft.ir
http://www.arkapayamak.ir
http://asanak.ir
http://asanak.ir
http://barzingostar.ir
http://www.bearsms.com
http://panelsms.bestit.co
http://bulutfon.com
http://caffeweb.com
http://chapargah.ir
http://chaparpanel.ir
http://csmsplus.mobilinkworld.com
http://sms.dot4all.it
http://esms24.ir
http://smspanel.faraed.com
http://www.farapayamak.com
http://farazpayam.com
http://fayasms.ir
http://firstpayamak.ir
http://fortytwo.com
http://freepayamak.ir
http://sms.hostiran.net
http://melipayamak.ir
http://postgah.net
