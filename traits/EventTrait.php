<?php

namespace macklus\payments\traits;

use Yii;
use macklus\payments\events\ResponseEvent;

trait EventTrait {

    protected function getResponseEvent($payment) {
        return Yii::createObject(['class' => ResponseEvent::className(), 'payment' => $payment]);
    }

}
