<?php
namespace macklus\payments\base;

use yii\web\Controller;
use macklus\payments\interfaces\EventsInterface;
use macklus\payments\traits\EventTrait;
use macklus\payments\traits\UtilsTrait;
use yii\filters\AccessControl;

class BaseController extends Controller implements EventsInterface
{

    use EventTrait;
    use UtilsTrait;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = [])
    {
        $this->_module = $module;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
