<?php

namespace macklus\payments\events;

use yii\base\Event;

Class ResponseEvent extends Event {

    public $status;
    public $amount;
    public $item;
    public $payment;
    private $_vars = [];

    public function setVar($key, $value) {
        $this->_vars[$key] = $value;
    }

    public function getVar($key) {
        return (isset($this->_vars[$key]) ? $this->_vars[$key] : false);
    }

    public function setVars($vars = []) {
        foreach ($vars as $key => $value) {
            $this->setVar($key, $value);
        }
    }

    public function getVars() {
        return $this->_vars;
    }

}
