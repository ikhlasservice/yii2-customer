<?php

namespace backend\modules\customer\models;

use Yii;
use backend\modules\persons\models\Person;
use backend\modules\persons\models\PersonDetail;
use backend\modules\persons\models\PersonCareer;
use backend\modules\persons\models\PersonContact;
use backend\modules\persons\models\Address;
use backend\modules\persons\models\Address as ContactAddress;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use wowkaster\serializeAttributes\SerializeAttributesBehavior;

/**
 * This is the model class for table "register_customer".
 *
 * @property integer $id
 * @property integer $created_at
 * @property string $status
 * @property integer $person_id
 * @property string $data
 * @property string $doc
 * @property string $doc_fully
 * @property string $doc_because
 * @property string $score
 * @property integer $seller_id
 * @property string $seller_receive
 * @property string $seller_receive_because
 * @property string $seller_date
 * @property integer $staff_id
 * @property string $staff_receive
 * @property string $staff_date
 * @property string $financial_amount
 * @property string $staff_receive_because
 *
 * @property Customer[] $customers
 * @property User $seller
 * @property User $staff
 * @property Person $person
 */
class RegisterCustomer extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'register_customer';
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
            [
                'class' => SerializeAttributesBehavior::className(),
                'convertAttr' => ['doc_list' => 'serialize']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['created_at', 'person_id'], 'required', 'on' => 'confirm'],
            [['created_at', 'person_id', 'seller_id', 'staff_id', 'status'], 'integer'],
            [['data', 'doc_fully', 'doc_because', 'score', 'seller_receive', 'seller_receive_because', 'staff_receive', 'staff_receive_because'], 'string'],
            [['doc_list', 'seller_date', 'staff_date'], 'safe'],
            [['doc'], 'string', 'on' => 'uploadajax']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('person', 'เลขที่ใบสมัคร'),
            'created_at' => Yii::t('person', 'บันทึกเมื่อ'),
            'status' => Yii::t('person', 'สถานะ'),
            'person_id' => Yii::t('person', 'รหัสบัตรประชาชน'),
            'data' => Yii::t('person', 'ข้อมูลทั้งหมด'),
            'doc' => Yii::t('person', 'เอกสารแนบ'),
            'doc_list' => Yii::t('seller', 'เอกสาร'),
            'doc_fully' => Yii::t('person', 'ความครบถ้วนของเอกสาร'),
            'doc_because' => Yii::t('person', 'ดังนี้'),
            'score' => Yii::t('person', 'คะแนนการพิจารณา'),
            'seller_id' => Yii::t('person', 'ตัวแทน'),
            'seller_receive' => Yii::t('person', 'ควรรับเป็นสมาชิกหรือไม่'),
            'seller_receive_because' => Yii::t('person', 'เหตุผลประกอบ'),
            'seller_date' => Yii::t('person', 'วันที่ยืนสมัคร'),
            'staff_id' => Yii::t('person', 'เจ้าหน้าที่'),
            'staff_receive' => Yii::t('person', 'ควรรับเป็นสมาชิกหรือไม่'),
            'staff_date' => Yii::t('person', 'วันที่อนุญาต'),
            'financial_amount' => Yii::t('person', 'ระบุจำนวนเงินที่อนุมัติ'),
            'staff_receive_because' => Yii::t('person', 'เหตุผลประกอบ'),
            'confirm' => Yii::t('person', 'ข้าพเจ้าได้อ่านและเข้าใจกำหนดและเงื่อนไงการเป็นตัวแทนจำหน่ายกับบริษัทฯและยินยอมปฎิบัติตามเงื่อนไงข้อกำหนดดังกล่าวอย่างเคร่งครัดทุกประการ'),
            'fullname' => Yii::t('person', 'ชื่อ-สกุล'),
            'doc_idcard' => Yii::t('person', '1. สำเนาบัตรประชาชน หรือ บัตรข้าราชการ หรือพนักงานรัฐวิสาหกิจ จำนวน 2 ชุด'),
            'doc_home' => Yii::t('person', '2. สำเนาทะเบียนบ้าน (หน้าแรกและหน้าที่มีชื่อผู้สมัคร) จำนวน 2 ชุด'),
            'doc_samaly' => Yii::t('person', '3. เอกสารยืนยันรายได้ อาทิ สลิปเงินเดือน'),
        ];
    }

    public function attributeHints() {

        return [
            'doc' => 'อับโหลดไฟล์ JPG,PNG,PDF เท่านั้น',
        ];
    }

    public $confirm;
    public $doc_idcard;

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios['document'] = ['doc'];
        $scenarios['confirm'] = ['confirm'];

        return $scenarios;
    }

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ร่าง'),
                1 => Yii::t('app', 'เสนอ'),
                2 => Yii::t('app', 'พิจารณา'),
                3 => Yii::t('app', 'อนุมัติ'),
                4 => Yii::t('app', 'ปรับแก้'),
                5 => Yii::t('app', 'ไม่อนุมัติ'),
                6 => Yii::t('app', 'ยกเลิก'),
            ],
            'condition' => [
                1 => 'ข้าพเจ้า ขอรับรองว่า ข้อความที่ระบุในใบสมัครนี้ถูกต้อง ...',
                2 => 'ข้าพเจ้าตกลงยินยอมให้บริษัท และสมาชิกอื่นๆ ...',
                3 => 'ข้าพเจ้าจะแจ้งให้บริษัททราบทันที่หากมีข้อมูลจะเปลี่ยนแปลงใดๆ',
            ],
            'staffReceive' => [
                1 => 'รับเป็นสมาชิก (IKHLAS Member)',
                0 => 'ไม่รับเป็นสมาชิก (IKHLAS Member)',
                2 => 'ควรปรับแก้',
            ],
            'doc_list' => [
                1 => 'สำเนาบัตรประชาชน หรือ บัตรข้าราชการ หรือ บัตรพนักงานรัฐวิสาหกิจ',
                2 => 'สำเนาทะเบียนบ้าน',
                3 => 'สำเนาบัญชีธนาคาร',
                4 => 'รูปถ่าย 1 นิ้ว..',
                5 => 'แผ่นที่บ้าน',
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case 0 :
            case 5 :
            case 6 :
                $str = '<span class="label label-danger">' . $status . '</span>';
                break;

            case 1 :
            case 2 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;

            case 3 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;

            case 4 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;

            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public function getStatusLabelString() {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public static function getItemCondition() {
        return self::itemsAlias('condition');
    }

    public static function getItemStaffReceive() {
        return self::itemsAlias('staffReceive');
    }

    public static function getItemDocList() {
        return self::itemsAlias('doc_list');
    }

    public function getDocList() {
        return ArrayHelper::getValue($this->getItemDocList(), $this->doc_list);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisterCustomerConsiders() {
        return $this->hasMany(RegisterCustomerConsider::className(), ['register_cutomer_id' => 'id'])->orderBy(['register_customer_consider.created_at' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers() {
        return $this->hasMany(Customer::className(), ['register_customer_id' => 'id']);
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['register_customer_id' => 'id']);
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

    public function getFullname() {
        return $this->person->fullname;
    }

    public function getFullnameEn() {
        return $this->person->fullname_en;
    }

    public static function getDetailRegister($id) {
        $model = self::findOne($id);
        $modelPerson = $model->person_id ? $model->person : new Person();
        $modelPersonDetail = $modelPerson->personDetail ? $modelPerson->personDetail : new PersonDetail();
        $modelAddress = $modelPerson->address_id ? $modelPerson->address : new Address();
        $modelContactAddress = $modelPerson->contact_address_id ? $modelPerson->contactAddress : new ContactAddress();
        $modelContactAddress->contactBy = ($modelPerson->address_id == $modelPerson->contact_address_id) ? 1 : 2;
        $modelPersonContact = $modelPerson->personContact ? $modelPerson->personContact : new PersonContact();
        $modelPersonCareer = $modelPerson->personCareer ? $modelPerson->personCareer : new PersonCareer();

        return compact(
                'model', 'modelPerson', 'modelPersonDetail', 'modelAddress', 'modelContactAddress', 'modelPersonContact', 'modelPersonCareer'
        );
    }

    ####################################

    const UPLOAD_FOLDER = "registercustomer";

    public function initialPreview($data, $field, $type = 'file') {
        $initial = [];
        $files = '';
        if (!empty($data)) {
//            print_r($data);
//            exit();
            $files = \yii\helpers\Json::decode($data);
            ksort($files);
        }
        //$files = '';
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                if ($type == 'file') {
                    $img = Yii::$app->img;
                    if ($img->chkImg(self::UPLOAD_FOLDER . '/' . $this->id, $key)) {
                        $initial[] = \yii\helpers\Html::a(\yii\helpers\Html::img(Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key, ['class' => 'file-preview-image', 'title' => $value]), Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key, ['target' => '_blank']);
                    } else {
                        $initial[] = \yii\helpers\Html::a('<object data="' . Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key . '" type="application/pdf" width="100%" height="200"></object>', Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key, ['target' => '_blank']);
                    }
                } elseif ($type == 'config') {
                    $initial[] = [
                        'caption' => $value,
                        //'width' => '100px',
                        'url' => \yii\helpers\Url::to(['deletefile-ajax', 'id' => $this->id, 'fileName' => $value, 'field' => $field, 'folder' => self::UPLOAD_FOLDER]),
                        'key' => $value
                    ];
                } else {
                    $initial[] = Html::img(self::getUploadUrl() . $this->ref . '/' . $value, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
                }
            }
        }
        return $initial;
    }

    public static function findFiles($pathFile) {
        $files = [];
        $findFiles = \yii\helpers\FileHelper::findFiles($pathFile);
        ksort($findFiles);
        // set pdfs as target folder
        //print_r($findFiles);
        foreach ($findFiles as $index => $file) {
            if (strpos($file, 'thumbnail') === false) {
                $nameFicheiro = substr($file, strrpos($file, '/') + 1);
                $files[$nameFicheiro] = $nameFicheiro;
            }
        }
        return $files ? \yii\helpers\Json::encode($files) : null;
    }

    public function viewPreview($data) {
        $initial = [];
        $img = Yii::$app->img;
        $files = '';
        $str = '<ul class="mailbox-attachments clearfix">';
//        <ul class="mailbox-attachments clearfix">
//                <li>
//                  <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
//
//                  <div class="mailbox-attachment-info">
//                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
//                        <span class="mailbox-attachment-size">
//                          1,245 KB
//                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
//                        </span>
//                  </div>
//                </li>
//                <li>
//                  <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>
//
//                  <div class="mailbox-attachment-info">
//                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
//                        <span class="mailbox-attachment-size">
//                          1,245 KB
//                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
//                        </span>
//                  </div>
//                </li>
//                <li>
//                  <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>
//
//                  <div class="mailbox-attachment-info">
//                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
//                        <span class="mailbox-attachment-size">
//                          2.67 MB
//                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
//                        </span>
//                  </div>
//                </li>
//                <li>
//                  <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>
//
//                  <div class="mailbox-attachment-info">
//                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
//                        <span class="mailbox-attachment-size">
//                          1.9 MB
//                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
//                        </span>
//                  </div>
//                </li>
//              </ul>



        if ($data != NULL) {
            $files = \yii\helpers\Json::decode($data);
            if(!empty($files))
            @ksort($files);
        }
        if (is_array($files)) {
            foreach ($files as $key => $value) {
               $size = filesize(Yii::$app->img->getUploadPath(self::UPLOAD_FOLDER . '/' . $this->id) . $key);
               $size = $size?$size/1024:0;
               $size = $size?Yii::$app->formatter->asDecimal($size,2):0;
                if ($img->chkImg(self::UPLOAD_FOLDER . '/' . $this->id, $value)) {
                    $str .=' <li><span class="mailbox-attachment-icon has-img" style="overflow: hidden;height: 133px;">';
                     $str .= \yii\helpers\Html::img(Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key);
                    $str.='</span>
                  <div class="mailbox-attachment-info">';
                    $str .= \yii\helpers\Html::a($value, Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key, ['target' => '_blank','style'=>'word-wrap: break-word;']);
                   $str .='<span class="mailbox-attachment-size">'.$size.' KB </span></div></li>';
                } else {
                    $str .=' <li>
                  <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                  <div class="mailbox-attachment-info">';
                    $str .= \yii\helpers\Html::a($value, Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $key, ['target' => '_blank','style'=>'word-wrap: break-word;']);
                   $str .='<span class="mailbox-attachment-size">'.$size.' KB </span></div></li>';
                }
            }
        }
        $str .="</ul>";
        return $str;
    }

}
