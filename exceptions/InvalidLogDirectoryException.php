<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace macklus\payments\exceptions;

use yii\base\Exception;

class InvalidLogDirectoryException extends Exception {

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Log directory is invalid';
    }

}
