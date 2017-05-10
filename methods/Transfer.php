<?php

namespace macklus\payments\methods;

Class Transfer extends BaseMethod {

    protected $_accepted_vars = [
        'algo', 'hola'
    ];
    protected $_required_vars = [
        'algo'
    ];

}
