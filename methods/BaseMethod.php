<?php

namespace macklus\payments\methods;

use macklus\payments\interfaces\PaymentMethodInterface;

Class BaseMethod implements PaymentMethodInterface {

    public $amount;
    public $currency = 'EUR';
    protected $item = false;
    protected $_config;
    protected $_accepted_vars = [];
    protected $_required_vars = [];

    public function __construct() {
        
    }

    public function configure($data = []) {
        foreach ($data as $key => $value) {
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

}
