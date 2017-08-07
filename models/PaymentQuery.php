<?php

namespace macklus\payments\models;

use yii\base\Exception;

/**
 * This is the ActiveQuery class for [[Payment]].
 *
 * @see Payment
 */
class PaymentQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Payment[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Payment|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function provider($provider) {
        switch ($provider) {
            case Payment::PROVIDER_PAYPAL:
                return $this->paypal();
            case Payment::PROVIDER_REDSYS:
                return $this->redsys();
            case Payment::PROVIDER_TRANSFER:
                return $this->transfer();
            default:
                throw new Exception('unknow provider ' . $provider);
        }
    }

    public function paypal() {
        return $this->andWhere(['provider' => Payment::PROVIDER_PAYPAL]);
    }

    public function redsys() {
        return $this->andWhere(['provider' => Payment::PROVIDER_REDSYS]);
    }

    public function transfer() {
        return $this->andWhere(['provider' => Payment::PROVIDER_TRANSFER]);
    }

    public function code($code) {
        return $this->andWhere(['code' => $code]);
    }

}
