<?php
namespace macklus\payments\controllers;

use Yii;
use c006\paypal_ipn\PayPal_Ipn;
use macklus\payments\base\BaseController;
use macklus\payments\methods\Paypal;
use macklus\payments\models\PaymentResponse;

class PaypalController extends BaseController
{

    protected $_module;
    private $_paypal_vars = ['payment_type', 'payment_date', 'payment_status', 'address_status',
        'payer_status', 'first_name', 'last_name', 'payer_email', 'payer_id', 'address_name',
        'address_country', 'address_country_code', 'address_zip', 'address_state', 'address_city',
        'address_street', 'business', 'receiver_email', 'receiver_id', 'residence_country', 'item_name',
        'item_number', 'quantity', 'shipping', 'tax', 'mc_currency', 'mc_fee', 'mc_gross', 'mc_gross_1',
        'txn_type', 'txn_id', 'notify_version', 'custom', 'invoice', 'test_ipn', 'verify_sign'
    ];

    public function actionIndex()
    {
        Yii::debug('PaypalController on macklus\payments', 'macklus\payments\PaypalController');

        $this->_fixErrorOnAlias();

        $response = new PaymentResponse();
        $response->provider = PaymentResponse::PROVIDER_PAYPAL;
        $response->recordRequest();

        $payment = new Paypal();
        $payment->configure('paypal');

        $event = $this->getResponseEvent($payment);

        Yii::info(Yii::t('payments', 'New request'), 'macklus\payments\PaypalController');

        if (Yii::$app->request->isPost) {
            $paypal = $this->_module->getMod('paypal');
            $ipn = new PayPal_Ipn($paypal['live'], $paypal['debug']);
            if ($ipn->init()) {
                // Log
                Yii::debug(Yii::t('payments', 'Received IPN') . ': ' . print_R($ipn, true), 'macklus\payments\PaypalController');

                //payment_status":"Completed
                $status = $ipn->getKeyValue('payment_status');

                foreach ($this->_paypal_vars as $var) {
                    $event->setVar($var, $ipn->getKeyValue($var));
                }

                $event->item = $ipn->getKeyValue('item_number');
                $event->amount = $ipn->getKeyValue('mc_gross');

                $response->item = $ipn->getKeyValue('item_number');
                $response->amount = $ipn->getKeyValue('mc_gross');

                if ($status == 'Completed') {
                    Yii::info(Yii::t('payments', 'Payment is correct'), 'macklus\payments\PaypalController');
                    $response->status = PaymentResponse::STATUS_OK;
                    $event->status = 'ok';
                } else {
                    Yii::info(Yii::t('payments', 'Payment is WRONG'), 'macklus\payments\PaypalController');
                    $response->status = PaymentResponse::STATUS_ERROR;
                    $event->status = 'error';
                }
            } else {
                Yii::debug(Yii::t('payments', 'ERROR: ipn->init()'), 'macklus\payments\PaypalController');
            }
        } else {
            Yii::error(Yii::t('payments', 'POST request expected'), 'macklus\payments\PaypalController');
        }

        $response->save();

        $this->trigger(self::EVENT_RESPONSE, $event);
    }
}
