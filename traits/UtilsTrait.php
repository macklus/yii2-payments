<?php

namespace macklus\payments\traits;

use Yii;

trait UtilsTrait {

    protected function _fixErrorOnAlias() {
        $exists = Yii::getAlias('@frontend', false);
        if (!$exists) {
            Yii::setAlias('@frontend', Yii::getAlias('@app'));
        }
    }

}
