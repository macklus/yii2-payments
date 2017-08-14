<?php

namespace macklus\payments\methods;

Class Paypal extends BaseMethod {

    protected $_accepted_vars = [
        'live', 'debug', 'bussines', 'urlOK', 'urlKO',
        'item_name', 'submit', 'form_target'
    ];
    protected $_required_vars = [
        'item_name', 'bussines', 'action', 'notify_url',
    ];

    public function __construct() {
// Same action for all environments
        $this->_config['action'] = 'https://www.paypal.com/cgi-bin/webscr';
        $this->_config['notify_url'] = '/payments/paypal';

        return parent::__construct();
    }

    public function setName($name) {
        $this->setParameter('item_name', $name);
    }

    public function setUrlOK($url) {
        $this->setParameter('urlOK', $url);
    }

    public function setUrlError($url) {
        $this->setParameter('urlKO', $url);
    }

}
