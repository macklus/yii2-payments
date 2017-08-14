<?php

namespace macklus\payments\models;

/**
 * This is the ActiveQuery class for [[PaymentResponse]].
 *
 * @see PaymentResponse
 */
class PaymentResponseQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return PaymentResponse[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PaymentResponse|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function status($status) {
        switch ($status) {
            case PaymentResponse::STATUS_OK:
                return $this->ok();
            case PaymentResponse::STATUS_ERROR:
                return $this->error();
            case PaymentResponse::STATUS_UNKNOW:
                return $this->unknow();
            default:
                throw new Exception('unknow status ' . $status);
        }
    }

    public function ok() {
        return $this->andWhere(['status' => PaymentResponse::STATUS_OK]);
    }

    public function error() {
        return $this->andWhere(['status' => PaymentResponse::STATUS_ERROR]);
    }

    public function unknow() {
        return $this->andWhere(['status' => PaymentResponse::STATUS_UNKNOW]);
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

}
