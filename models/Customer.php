<?php

namespace ikhlas\customer\models;

use Yii;
use backend\modules\persons\models\Person;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $register_customer_id
 * @property integer $person_id
 * @property string $data
 * @property integer $seller_id
 * @property integer $staff_id
 *
 * @property RegisterCustomer $registerCustomer
 * @property User $seller
 * @property User $staff
 * @property Person $person
 */
class Customer extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'customer';
    }

    public function behaviors() {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'financial_amount',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'financial_amount',
                ],
                'value' => function ($event) {
            return str_replace(',', '', $this->financial_amount);
        },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'profit_id'], 'required'],
            [['id', 'created_at', 'register_customer_id', 'person_id', 'seller_id', 'status', 'staff_id', 'profit_id'], 'integer'],
            [['financial_amount'], 'safe'],
            [['data'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('customer', 'รหัสสมาชิก'),
            'created_at' => Yii::t('customer', 'วันที่ออกรหัส'),
            'register_customer_id' => Yii::t('customer', 'รหัสใบสมัคร'),
            'status' => Yii::t('customer', 'สถานะ'),
            'person_id' => Yii::t('customer', 'บุคคล'),
            'data' => Yii::t('customer', 'ข้อมูล'),
            'financial_amount' => Yii::t('customer', 'วงเงิน'),
            'seller_id' => Yii::t('customer', 'ตัวแทน'),
            'staff_id' => Yii::t('customer', 'เจ้าหน้าที่'),
            'fullname' => Yii::t('customer', 'ชื่อลูกค้า'),
            //'profit' => Yii::t('customer', 'กำไร'),
            'profit_id' => Yii::t('customer', 'กำไร'),
        ];
    }

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ระงับ'),
                1 => Yii::t('app', 'ปกติ'),
                2 => Yii::t('app', 'พิจารณา'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case '0' :
            case NULL :
                $str = '<span class="label label-danger">' . $status . '</span>';
                break;
            case '1' :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case '2' :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case '3' :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisterCustomer() {
        return $this->hasOne(RegisterCustomer::className(), ['id' => 'register_customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller() {
        return $this->hasOne(User::className(), ['id' => 'seller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff() {
        return $this->hasOne(User::className(), ['id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson() {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    public static function genId() {
        $id = self::find()->select('max(id)') // we need only one column
                ->scalar(); // cool, huh?;
        $id = ($id === NULL) ? 10000 : $id;
        return ++$id;
    }

    public function getFullname() {
        return $this->person->fullname;
    }

    public function getProfitPercent() {
        return $this->profit_id ? \Yii::$app->formatter->asDecimal($this->profit->val, 1) . ' %' : '';
    }

    public function getProfit() {
        return $this->hasOne(Profit::className(), ['id' => 'profit_id']);
    }

}
