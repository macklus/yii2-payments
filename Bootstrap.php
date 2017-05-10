<?php

/*
 * This file is part of the Macklus Yii2-Payments project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace macklus\payments;

use Yii;

/**
 * Bootstrap class registers module. 
 * It also creates required url rules
 *
 */
class Bootstrap implements BootstrapInterface {

    /** @inheritdoc */
    public function bootstrap($app) {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('payments') && ($module = $app->getModule('payments')) instanceof Module) {
            if (!$app instanceof ConsoleApplication) {
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
        }
    }

}
