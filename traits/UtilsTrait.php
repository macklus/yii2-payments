<?php

namespace macklus\payments\traits;

use Yii;
use macklus\payments\exceptions\InvalidLogDirectoryException;

trait UtilsTrait {

    protected function _fixErrorOnAlias() {
        $exists = Yii::getAlias('@frontend', false);
        if (!$exists) {
            Yii::setAlias('@frontend', Yii::getAlias('@app'));
        }
    }

    protected function _ensureLogDir() {
        $logDir = Yii::getAlias($this->_module->logDir);
        if (!file_exists($logDir)) {
            if (!mkdir($logDir, $this->_module->logDirPerms, true)) {
                throw new InvalidLogDirectoryException();
            }
        }
    }

}
