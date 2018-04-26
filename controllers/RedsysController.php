<?php
namespace macklus\payments\controllers;

use Yii;
use macklus\payments\base\BaseController;
use macklus\payments\lib\Redsys as RedSysObj;
use macklus\payments\methods\creditcard\Redsys;
use macklus\payments\models\PaymentResponse;

class RedsysController extends BaseController
{

    protected $_module;
    private $_obj;

    public function actionIndex()
    {
        Yii::debug('RedsysController on macklus\payments', 'macklus\payments\RedsysController');

        $this->_fixErrorOnAlias();

        $this->_obj = new RedSysObj();
        $payment = new Redsys();
        $payment->configure('redsys');

        $response = new PaymentResponse();
        $response->provider = PaymentResponse::PROVIDER_REDSYS;
        $response->recordRequest();

        $event = $this->getResponseEvent($payment);

        Yii::info(Yii::t('payments', 'New request'), 'macklus\payments\RedsysController');

        if (Yii::$app->request->isPost) {
            $version = Yii::$app->request->post("Ds_SignatureVersion");
            $parameters = Yii::$app->request->post("Ds_MerchantParameters");
            $signature = Yii::$app->request->post("Ds_Signature");

            $key = $payment->getParameter('key');
            $firma = $this->_obj->createMerchantSignatureNotif($key, $parameters);
            $decodec = $this->_obj->decodeMerchantParameters($parameters);

            $event->setVars([
                'version' => $version,
                'parameters' => $parameters,
                'signature' => $signature,
                'key' => $key,
                'firma' => $firma,
                'decodec' => $decodec,
                'response' => $this->_obj->getParameter("Ds_Response")
            ]);

            if ($firma === $signature) {
                Yii::info(Yii::t('payments', 'Signature correct'), 'macklus\payments\RedsysController');
                Yii::info(Yii::t('payments', 'Data') . ': ' . print_R($decodec, true), 'macklus\payments\RedsysController');

                // Payment is valid
                $codigoRespuesta = $this->_obj->getParameter("Ds_Response");
                $event->setVar('codigoRespuesta', $codigoRespuesta);

                $event->item = $this->_obj->getParameter('Ds_Order');
                $response->item = $this->_obj->getParameter('Ds_Order');

                if (preg_match('/\d+i(.*)/', $event->item, $matches)) {
                    if (isset($matches[1])) {
                        $event->item = $matches[1];
                    }
                }

                $event->amount = intval($this->_obj->getParameter("Ds_Amount")) / 100;
                $response->amount = intval($this->_obj->getParameter("Ds_Amount")) / 100;

                if (isset($codigoRespuesta) && (intval($codigoRespuesta) == 0)) {
                    $event->status = 'ok';
                    $response->status = PaymentResponse::STATUS_OK;
                    // Payment OK !!!
                    Yii::info(Yii::t('payments', 'Payment is correct'), 'macklus\payments\RedsysController');
                } else {
                    $event->status = 'error';
                    $response->status = PaymentResponse::STATUS_ERROR;
                    $ds_response = isset($decodec['Ds_Response']) ? intval($decodec['Ds_Response']) : 'undefined';

                    Yii::warning(Yii::t('payments', 'Payment is WRONG') . ': ' . $ds_response, 'macklus\payments\RedsysController');
                }
            } else {
                Yii::warning(Yii::t('payments', 'WRONG signature:') . $firma . '<>' . $signature, 'macklus\payments\RedsysController');
                // Poner aqui la vista del error
                $response->status = PaymentResponse::STATUS_ERROR;
            }
        } else {
            Yii::error(Yii::t('payments', 'POST request expected'), 'macklus\payments\RedsysController');
        }

        $response->save();
        $this->trigger(self::EVENT_RESPONSE, $event);
    }
}
