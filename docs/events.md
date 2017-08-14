# Events


```php
'controllerMap' => [
    'redsys' => [
        'class' => \macklus\payments\controllers\RedsysController::classname(),
        'on ' . \macklus\payments\controllers\RedsysController::EVENT_RESPONSE => function ($event) {
            \app\models\Order::checkPaymentFromEvent($event);
        },
    ],
    'paypal' => [
        'class' => \macklus\payments\controllers\PaypalController::classname(),
        'on ' . \macklus\payments\controllers\PaypalController::EVENT_RESPONSE => function ($event) {
            \app\models\Order::checkPaymentFromEvent($event);
        },
    ],
],
```