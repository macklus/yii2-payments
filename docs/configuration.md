# Configuration

**IMPORTANT:**

You should configure your web and console files.

Once the extension is installed, you should define their config, by define a payments component on your config files, like:

```php
return [
    'class' => 'macklus\payments\PaymentsModule',
    'urlPrefix' => '/payments',
    'logDir' => '@runtime/payments',
    'logDirPerms' => 0755,
    'tables' => [
        'payment' => 'payment',
        'response' => 'payment_response',
    ],
    'mods' => [
        'paypal' => [
            'dev' => [
                'live' => false,
                'debug' => true,
                'action' => 'https://www.paypal.com/cgi-bin/webscr',
                'bussines' => '',
                'notify_url' => 'https://my.domain/payments/paypal',
            ],
            'prod' => [
                'live' => true,
                'debug' => false,
                'action' => 'https://www.paypal.com/cgi-bin/webscr',
                'bussines' => '',
                'notify_url' => 'https://my.domain/payments/paypal',
            ],
        ],
        'redsys' => [
            'dev' => [
                'urlPago' => "https://sis-t.redsys.es:25443/sis/realizarPago",
                'key' => '',
                'merchant' => '',
                'terminal' => '',
                'currency' => '',
                'transactionType' => '',
                'merchantURL' => 'https://my.domain/payments/redsys',
            ],
            'prod' => [
                'urlPago' => "https://sis.redsys.es/sis/realizarPago",
                'key' => "",
                'merchant' => "",
                'terminal' => '',
                'currency' => '',
                'transactionType' => '',
                'merchantURL' => 'https://my.domain/payments/redsys',
            ],
        ],
    ],
];

```

So far config array are too big, and you should config web and console files, it's 
recommended put config array on external file (maybe in app\config\payments.php),
and required it when necesary, as:

```php
'modules' => [
        'payments' => require __DIR__ . '/payments.php',
],

```

---

#### urlPrefix (Type: `string`, Default value: `/payments`)

Define the base return url for all providers. Usually, providers send you a web
notification after check the payment process. Yii2-payments accept this requests
and update internal info according to.
Change only if you already has a /payments controller

---

#### tables (Type: `array`)

Define the name of database tables we use. 
This config option accepts and array on format key - table name
Acceptes keys are payment and response


# Deprecated functions

## Deprecated from 2.0.0

#### logDir (Type: `string`, Default value: `@runtime/payments`)

Define our log directory

---

#### logDirPerms (Type: `string`, Default value: `0755`)

Define our log directory permissions, if they need to be create.

---


