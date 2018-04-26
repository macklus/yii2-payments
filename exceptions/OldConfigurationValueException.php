<?php
namespace macklus\payments\exceptions;

use yii\base\Exception;

class OldConfigurationValueException extends Exception
{

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'You still use deprecated logDir or logDirPerms. Please, review https://github.com/macklus/yii2-payments/blob/master/docs/logging.md';
    }
}
