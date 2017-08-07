Yii2 Payments Environment
=========================
Simple payment environment for Yii2. It includes Transfer, Paypal and Credit Card systems

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist macklus/yii2-payments "*"
```

or add

```
"macklus/yii2-payments": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, you should define their config, by define a payments component on your web.php, like:

```php
'modules' => [
    'payments' => [
        'dev' => [
            'paypal' => [
                'live' => false,
                'debug' => true,
                'action' => 'https://www.paypal.com/cgi-bin/webscr',
                'bussines' => 'HERE YOUR PAYPAL ACCOUNTS',
                'notify_url' => '/payments/paypal',
                'url_ok' => '',
                'url_ko' => ''
            ],
            'transfer' => [
                'account' => '',
                'name' => '',
                'email' => '',
            ],
           'redsys' => [
                'urlPago' => "https://sis-t.redsys.es:25443/sis/realizarPago",
                'key' => 'HERE YOUR KEY',
                'merchant' => "HERE YOUR MERCHANT",
            ],
        ],
        'prod' => [
            'paypal' => [
                'live' => true,
                'debug' => false,
                'action' => 'https://www.paypal.com/cgi-bin/webscr',
                'bussines' => 'HERE YOUR PAYPAL ACCOUNT',
                'notify_url' => '/payments/paypal',
                'url_ok' => '',
                'url_ko' => ''
            ],
            'transfer' => [
                'account' => '',
                'name' => '',
                'email' => '',
             ],
             'redsys' => [
                'urlPago' => "https://sis.redsys.es/sis/realizarPago",
                'key' => "HERE YOUR KEY",
                'merchant' => "HERE YOUR MERCHANT",
             ],
        ],
    ],
],
```