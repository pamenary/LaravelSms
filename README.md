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
'Pamenary\LaravelSms\Laravel\SmsServiceProvider::class',
```

Next, add a Facade for more convenient usage. In ```app/config/app.php``` add the following line to the aliases array:

```
'Sms' => 'Pamenary\LaravelSms\Laravel\Facade\Sms::class',
```
Publish config files:
```
php artisan config:publish livana/sms
```
for change username, password and other configuration change ```app/config/sms.php```

Usage
-----
### Send Message
```php
Sms::sendSMS('09136000415', 'text message'); // send message for a person

Sms::sendSMS(['09136000415', '09361265987'], 'text mesage'); // send message for persons
```
### Change Gateway

```php
$sms = new Sms(new \Pamenary\LaravelSms\Gateways\AzinwebGateway());

$sms->sendSMS(['09136000415'], 'text message');
```

### Get Credit
```php
Sms::getCredit();
```

