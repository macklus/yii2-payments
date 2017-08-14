# Usage

Use of Yii2-payments are so easy and simple.
You can see this on next example

```php
<?php

namespace app\controllers;

use Yii;
use macklus\payments\Payment;
use yii\helpers\Html;

class SampleController extends \yii\base\Controller {

    public function actionPaypal() {
        $payment = new Payment();
        $payment->start(Payment::PROVIDER_PAYPAL);
        $payment->setAmount(12.34);
        $payment->setName(Yii::t('erp', 'Pedido 123456789'));
        $payment->setItem('ADJCADFAD');
        $payment->setUrlOK('https://my.domain/url_ok_paypal');
        $payment->setUrlError('https://my.domain/url_error_paypal');

        $submitButton = Html::submitButton('Enviar', ['class' => 'btn btn-default']);
        $payment->setParameter('submit', $submitButton);
        $payment->setParameter('form_target', '_blank');
        
        $payment->process();
        
        echo $payment->renderForm('paypal', ['payment' => $payment]);
        
        $payment->end();
    }

    public function actionRedsys() {
        $payment = new Payment();
        $payment->start(Payment::PROVIDER_REDSYS);
        $payment->setAmount(12);
        $payment->setItem('ADKCJDA');
        $payment->setUrlOK('https://my.domain/url_ok_redsys');
        $payment->setUrlError('https://my.domain/url_error_redsys');

        $submitButton = Html::submitButton('Enviar', ['class' => 'btn btn-default']);
        $payment->setParameter('submit', $submitButton);
        $payment->setParameter('form_target', '_blank');

        $payment->process();

        echo $payment->renderForm('redsys', []);

        $payment->end();
    }

}

```
