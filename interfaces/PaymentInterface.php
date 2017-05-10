<?php

namespace macklus\payments\interfaces;

interface PaymentInterface {

    public function start($method = false);

    public function setPaymentMethod($method = false);

    public function setAmount($amount = false);

    public function setCurrency($currency = 'EUR');

    public function setItem($item);

    public function setParameter($parameter, $value);
}
