<?php

namespace macklus\payments\controllers;

use Yii;
use yii\web\Controller;
use macklus\payments\exceptions\InvalidLogDirectoryException;
use c006\paypal_ipn\PayPal_Ipn;

class PaypalController extends Controller {

    private $_module;
    private $_log;

    public function __construct($id, $module, $config = []) {
        $this->_module = $module;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action) {
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionResponse() {
        $this->_fixErrorOnAlias();
        $this->_ensureLogDir();

        $this->_log = Yii::getAlias($this->_module->logDir . '/paypal.log');

        file_put_contents($this->_log, "===================\n" . Yii::t('payments', 'New request') . "\n", FILE_APPEND);

        //if (Yii::$app->request->isPost) {
        $paypal = $this->_module->getMod('paypal');
        $ipn = new PayPal_Ipn($paypal['live'], $paypal['debug']);
        if ($ipn->init()) {
            // Log
            file_put_contents($this->_log, print_R($ipn, true), FILE_APPEND);

            //payment_status":"Completed
            $status = $ipn->getKeyValue('payment_status');
            if ($status == 'Completed') {
                file_put_contents($this->_log, 'PAGO COMPLETADO', FILE_APPEND);
            } else {
                file_put_contents($this->_log, 'PAGO INCOMPLETO', FILE_APPEND);
            }
        } else {
            file_put_contents($this->_log, "ERROR: ipn->init()", FILE_APPEND);
        }
//        }

        /* Enable again if you use it */
        Yii::$app->request->enableCsrfValidation = true;
        file_put_contents($this->_log, "===================\n", FILE_APPEND);
    }

    private function _fixErrorOnAlias() {
        $exists = Yii::getAlias('@frontend', false);
        if (!$exists) {
            Yii::setAlias('@frontend', Yii::getAlias('@app'));
        }
    }

    private function _ensureLogDir() {
        $logDir = Yii::getAlias($this->_module->logDir);
        if (!file_exists($logDir)) {
            if (!mkdir($logDir, $this->_module->logDirPerms, true)) {
                throw new InvalidLogDirectoryException();
            }
        }
    }

}
