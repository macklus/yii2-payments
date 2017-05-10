<?php

namespace macklus\payments\methods;

Class Paypal extends BaseMethod {

    protected $_accepted_vars = [
        'live', 'debug', 'bussines', 'url_ok', 'url_ko',
        'item_name', 'submit', 'form_target'
    ];
    protected $_required_vars = [
        'item_name', 'bussines', 'url_ok', 'url_ko', 'action', 'notify_url',
    ];

    public function __construct() {
        // Same action for all environments
        $this->_config['action'] = 'https://www.paypal.com/cgi-bin/webscr';
        $this->_config['notify_url'] = '/payments/paypal';

        return parent::__construct();
    }

}
