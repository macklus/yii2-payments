<?php
namespace macklus\payments\exceptions;

use yii\base\Exception;

class ConfigurationErrorException extends Exception
{

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Module "payments" don\'t exists. Please check your config file';
    }
}
