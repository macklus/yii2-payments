<?php

namespace macklus\payments\controllers;

use Yii;
use yii\web\Controller;
use c006\paypal_ipn\PayPal_Ipn;
use macklus\payments\methods\Paypal;
use macklus\payments\traits\EventTrait;
use macklus\payments\traits\UtilsTrait;
use macklus\payments\interfaces\EventsInterface;

class PaypalController extends Controller implements EventsInterface {

    use EventTrait;
    use UtilsTrait;

    private $_module;
    private $_log;
    private $_paypal_vars = ['payment_type', 'payment_date', 'payment_status', 'address_status',
        'payer_status', 'first_name', 'last_name', 'payer_email', 'payer_id', 'address_name',
        'address_country', 'address_country_code', 'address_zip', 'address_state', 'address_city',
        'address_street', 'business', 'receiver_email', 'receiver_id', 'residence_country', 'item_name',
        'item_number', 'quantity', 'shipping', 'tax', 'mc_currency', 'mc_fee', 'mc_gross', 'mc_gross_1',
        'txn_type', 'txn_id', 'notify_version', 'custom', 'invoice', 'test_ipn', 'verify_sign'
    ];

    public function __construct($id, $module, $config = []) {
        $this->_module = $module;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionResponse() {
        $this->_fixErrorOnAlias();
        $this->_ensureLogDir();

        $payment = new Paypal();
        $payment->configure('paypal');

        $event = $this->getResponseEvent($payment);

        $this->_log = Yii::getAlias($this->_module->logDir . '/paypal.log');

        file_put_contents($this->_log, "===================\n" . Yii::t('payments', 'New request') . "\n", FILE_APPEND);

        if (Yii::$app->request->isPost) {
            $paypal = $this->_module->getMod('paypal');
            $ipn = new PayPal_Ipn($paypal['live'], $paypal['debug']);
            if ($ipn->init()) {
                // Log
                file_put_contents($this->_log, print_R($ipn, true), FILE_APPEND);

                //payment_status":"Completed
                $status = $ipn->getKeyValue('payment_status');

                foreach ($this->_paypal_vars as $var) {
                    $event->setVar($var, $ipn->getKeyValue($var));
                }
                $event->status = $status;
                $event->item = $ipn->getKeyValue('item_number');
                $event->amount = $ipn->getKeyValue('quantity');

                if ($status == 'Completed') {
                    file_put_contents($this->_log, 'PAGO COMPLETADO', FILE_APPEND);
                } else {
                    file_put_contents($this->_log, 'PAGO INCOMPLETO', FILE_APPEND);
                }
            } else {
                file_put_contents($this->_log, "ERROR: ipn->init()", FILE_APPEND);
            }
        }

        /* Enable again if you use it */
        //Yii::$app->request->enableCsrfValidation = true;
        file_put_contents($this->_log, "===================\n", FILE_APPEND);

        $this->trigger(self::EVENT_RESPONSE, $event);
    }

}
