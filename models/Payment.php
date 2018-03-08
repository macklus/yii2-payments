<?php
namespace macklus\payments\models;

use Yii;
use Ramsey\Uuid\Uuid;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use macklus\payments\interfaces\ConstantsProviderInterface;
use macklus\payments\interfaces\ConstantsStatusInterface;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $code
 * @property string $item
 * @property double $amount
 * @property string $provider
 * @property string $date_received
 * @property string $date_procesed
 * @property string $date_add
 * @property string $date_edit
 *
 * @property PaymentResponse[] $paymentResponses
 */
class Payment extends \yii\db\ActiveRecord implements ConstantsProviderInterface, ConstantsStatusInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->getModule('payments')->tables['payment'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'provider', 'item'], 'required'],
            [['amount'], 'number'],
            [['provider'], 'string'],
            [['code', 'date_received', 'date_procesed', 'date_add', 'date_edit'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['item'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payments', 'ID'),
            'code' => Yii::t('payments', 'Code'),
            'code' => Yii::t('payments', 'Item'),
            'amount' => Yii::t('payments', 'Amount'),
            'provider' => Yii::t('payments', 'Provider'),
            'date_received' => Yii::t('payments', 'Date Received'),
            'date_procesed' => Yii::t('payments', 'Date Procesed'),
            'date_add' => Yii::t('payments', 'Date Add'),
            'date_edit' => Yii::t('payments', 'Date Edit'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_add',
                'updatedAtAttribute' => 'date_edit',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(PaymentResponse::className(), ['payment_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            // Define code
            do {
                $this->code = strtoupper(Uuid::uuid4()->toString());
                $exists = Payment::find()->code($this->code)->one();
            } while ($exists);
        }
        return parent::beforeSave($insert);
    }
}
