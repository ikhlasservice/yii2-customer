<?php

namespace ikhlas\customer\models;

use Yii;
use common\models\User;
use wowkaster\serializeAttributes\SerializeAttributesBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "register_customer_consider".
 *
 * @property integer $id
 * @property integer $register_cutomer_id
 * @property string $register_cutomer_status
 * @property integer $status
 * @property string $comment
 * @property integer $created_by
 * @property integer $created_at
 *
 * @property RegisterCustomer $registerCutomer
 * @property User $createdBy
 */
class RegisterCustomerConsider extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'register_customer_consider';
    }

    public function behaviors() {
        return [
            [
                'class' => SerializeAttributesBehavior::className(),
                'convertAttr' => ['data' => 'serialize']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['register_cutomer_id', 'status', 'created_by', 'created_at', 'register_cutomer_status'], 'integer'],
            //[['comment'], 'required'],
            [['comment'], 'string'],
                //[['register_cutomer_status'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('customer', 'ID'),
            'register_cutomer_id' => Yii::t('customer', 'Register Cutomer ID'),
            'register_cutomer_status' => Yii::t('customer', 'Register Cutomer Status'),
            'status' => Yii::t('customer', 'สถานะ'),
            'comment' => Yii::t('customer', 'ความคิดเห็น'),
            'created_by' => Yii::t('customer', 'โดย'),
            'created_at' => Yii::t('customer', 'บันทึกเมื่อ'),
            'consider_basic' => Yii::t('customer', 'การพิจารณาเบื้ยงต้น'),
            'doc_fully' => Yii::t('customer', 'การพิจารณาเอกสาร'),
            'doc_comment' => Yii::t('customer', 'เหตุผล ดังนี้'),            
            'should_receive' => Yii::t('customer', 'ควรรับเป็นสมาชิกหรือไม่'),
            'should_receive_because' => Yii::t('customer', 'เหตุผลประกอบ'),
        ];
    }

    public $consider_basic;
    public $doc_fully;
    public $doc_because;
    public $doc_comment;
    public $should_receive;
    public $should_receive_because;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisterCutomer() {
        return $this->hasOne(RegisterCustomer::className(), ['id' => 'register_cutomer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ร่าง'),
                1 => Yii::t('app', 'เสนอ'),
                2 => Yii::t('app', 'พิจารณา'),
                3 => Yii::t('app', 'อนุมัติ'),
                4 => Yii::t('app', 'ไม่อนุมัติ'),
                5 => Yii::t('app', 'ยกเลิก'),
            ],
            'doc_fully' => [
                1 => 'เอกสารถูกต้อง ครบถ้วน',
                0 => 'เอกสารไม่ถูกต้อง',
            ],
            'should_receive' => [
                1 => 'ควรรับเป็นสมาชิก (Ikhlas Member)',
                0 => 'ไม่ควรรับเป็นสมาชิก (Ikhlas Member)',
            ],
            'consider_basic' => [
                1 => ['title' => 'เป็นคนดี ไม่มีประวัติที่ไม่ดีทางการเงิน',
                    'choice' => [
                        0 => 'มีประวัติที่ไม่ดี',
                        1 => 'มีประวัติที่ไม่ดีบ้าง',
                        2 => 'ไม่มีประวัติ',
                        3 => 'ไม่มีประวัติและเป็นคนดี',
                    ]],
                2 => ['title' => 'มีรายได้ที่แน่นอนและเพียงพอในการชำระหนี้คืน',
                    'choice' => [
                        0 => 'ไม่มีรายได้เลย',
                        1 => 'มีรายได้แต่ไม่สม่ำเสมอ',
                        2 => 'มีรายได้ประจำแต่ไม่มั่นคง',
                        3 => 'มีรายได้ประจำชัดเจนมั่นคง',
                    ]],
                3 => ['title' => 'ไม่ติด Back List ของธนาคาร ไม่มีประวัติหนี้ NPL (สิ้นเชื่อที่ไม่ก่อให้เกิดรายได้)',
                    'choice' => [
                        0 => 'มีประวัติที่ไม่ดี',
                        1 => 'มีประวัติที่ไม่ดีบ้าง',
                        2 => 'ไม่มีประวัติ',
                        3 => 'ไม่มีประวัติและเป็นคนดี',
                    ]],
                4 => ['title' => 'มีที่อยู่อาศัยที่ชัดเจนเป็นหลักเป็นแหล่ง',
                    'choice' => [
                        0 => 'ไม่มีที่ชัดเจน',
                        1 => 'เช่นอยู่เป็นคนนอกพื้นที่',
                        2 => 'เช่นอยู่เป็นคนในพื้นที่',
                        3 => 'บ้านตนเอง',
                    ]],
                5 => ['title' => 'เป็นคนที่ Seller รู้จักเป็นอย่างดี สามารถติดต่อได้',
                    'choice' => [
                        0 => 'ไม่รู้จัก',
                        1 => 'เพื่อนของเพื่อน',
                        2 => 'รู้จักแต่ไม่สนิท',
                        3 => 'รู้จักเป็นอย่างดี',
                    ]],
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public static function getItemConsiderBasic() {
        return self::itemsAlias('consider_basic');
    }

    public static function getItemDocFully() {
        return self::itemsAlias('doc_fully');
    }
    public static function getItemShouldReceive() {
        return self::itemsAlias('should_receive');
    }

}
