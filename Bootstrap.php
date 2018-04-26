<?php
/*
 * This file is part of the Macklus Yii2-Payments project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace macklus\payments;

use Yii;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use macklus\payments\exceptions\OldConfigurationValueException;

/**
 * Bootstrap class registers module. 
 * It also creates required url rules
 *
 */
class Bootstrap implements BootstrapInterface
{

    /** @inheritdoc */
    public function bootstrap($app)
    {
        $module = $app->getModule('payments');
        
        if ((isset($module->logDir) && $module->logDir != 'deprecated') || (isset($module->logDirPerms) && $module->logDirPerms != 'deprecated')) {
            throw new OldConfigurationValueException();
        }

        if ($app->hasModule('payments') && $module instanceof \yii\base\Module) {
            if ($app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'macklus\payments\commands';
            } else {
                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules' => $module->urlRules,
                ];

                if ($module->urlPrefix != 'payments') {
                    $configUrlRule['routePrefix'] = 'payments';
                }

                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = Yii::createObject($configUrlRule);

                $app->urlManager->addRules([$rule], false);
            }

            if (!isset($app->get('i18n')->translations['payments*'])) {
                $app->get('i18n')->translations['payments*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
        }
    }
}
