<?php
namespace macklus\payments\controllers;

use Yii;
use yii\web\Controller;
use macklus\payments\lib\Redsys as RedSysObj;
use macklus\payments\methods\creditcard\Redsys;
use macklus\payments\traits\EventTrait;
use macklus\payments\traits\UtilsTrait;
use macklus\payments\interfaces\EventsInterface;
use macklus\payments\models\PaymentResponse;

class RedsysController extends Controller implements EventsInterface
{

    use EventTrait;
    use UtilsTrait;

    private $_module;
    private $_log;
    private $_obj;

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

    public function actionIndex()
    {
        $this->_fixErrorOnAlias();
        $this->_ensureLogDir();

        $this->_log = Yii::getAlias($this->_module->logDir . '/redsys.log');
        $this->_obj = new RedSysObj();
        $payment = new Redsys();
        $payment->configure('redsys');

        $response = new PaymentResponse();
        $response->provider = PaymentResponse::PROVIDER_REDSYS;
        $response->recordRequest();

        $event = $this->getResponseEvent($payment);

        file_put_contents($this->_log, "===================\n" . Yii::t('payments', 'New request') . "\n", FILE_APPEND);

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
                file_put_contents($this->_log, " - Firma correcta\n", FILE_APPEND);
                file_put_contents($this->_log, " - Datos: " . print_R($decodec, true), FILE_APPEND);

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
                    file_put_contents($this->_log, " - Pago correcto\n", FILE_APPEND);
                } else {
                    $event->status = 'error';
                    $response->status = PaymentResponse::STATUS_ERROR;
                    $ds_response = isset($decodec['Ds_Response']) ? intval($decodec['Ds_Response']) : 'undefined';

                    file_put_contents($this->_log, " - Pago incorrecto\n" . $ds_response, FILE_APPEND);
                }
            } else {
                file_put_contents($this->_log, "ERROR DE FIRMAS\n $firma <> $signature", FILE_APPEND);
                // Poner aqui la vista del error
                $response->status = PaymentResponse::STATUS_ERROR;
            }
        }

        //Yii::$app->request->enableCsrfValidation = true;
        file_put_contents($this->_log, "===================\n", FILE_APPEND);

        $response->save();
        $this->trigger(self::EVENT_RESPONSE, $event);
    }
}
