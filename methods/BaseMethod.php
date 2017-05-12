<?php

namespace macklus\payments\methods;

use Yii;
use macklus\payments\interfaces\PaymentMethodInterface;
use macklus\payments\interfaces\EventsInterface;

Class BaseMethod implements PaymentMethodInterface, EventsInterface {

    public $amount;
    public $viewPath;
    public $currency = 'EUR';
    protected $item = false;
    protected $_config;
    protected $_accepted_vars = [];
    protected $_required_vars = [];

    public function __construct() {
        $this->viewPath = Yii::getAlias('@macklus/payments/views');
    }

    public function configure($mod) {
        $conf = Yii::$app->getModule('payments')->getMod($mod);
        foreach ($conf as $key => $value) {
            $this->setParameter($key, $value);
        }
    }

    public function setParameter($key, $value) {
        if ($this->_var_is_accepted($key)) {
            $this->_config[$key] = $value;
        }
    }

    public function getParameter($key) {
        return (isset($this->_config[$key]) ? $this->_config[$key] : false);
    }

    private function _var_is_accepted($var) {
        return in_array($var, $this->_accepted_vars);
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function getItem() {
        return $this->item;
    }

    public function setCurrency($currency = 'EUR') {
        $this->currency = $currency;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function proccess() {
        
    }

    public function isValid() {
        foreach ($this->_required_vars as $required) {
            if (!isset($this->_config[$required])) {
                return false;
            }
        }
        return ($this->item ? true : false );
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getErrors() {
        $errors = [];
        foreach ($this->_required_vars as $required) {
            if (!isset($this->_config[$required])) {
                array_push($errors, 'Field ' . $required . ' is required');
            }
        }
        if (!$this->item) {
            array_push($errors, 'Item is required');
        }
        return $errors;
    }

    public function renderForm($file, $extra_params = []) {
        $params = [
            'payment' => $this,
        ];
        $params = array_merge($params, $extra_params);

        return Yii::$app->view->renderFile($this->viewPath . '/' . $file . '.php', $params);
    }

}
