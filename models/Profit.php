<?php

namespace backend\modules\customer\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profit".
 *
 * @property integer $id
 * @property double $val
 *
 * @property Customer[] $customers
 */
class Profit extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'profit';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['val'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('customer', 'ID'),
            'val' => Yii::t('customer', 'ค่า'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers() {
        return $this->hasMany(Customer::className(), ['profit_id' => 'id']);
    }

    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'val');
    }

}
