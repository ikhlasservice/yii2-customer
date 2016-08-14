<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
//use yii\bootstrap\ActiveForm;
use backend\modules\persons\models\Person;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\widgets\MaskedInput;
use backend\modules\persons\models\Degree;
use backend\modules\persons\models\Nationality;
use backend\modules\persons\models\Religion;
use kartik\widgets\DepDrop;
use backend\modules\persons\models\LocalProvince;
use backend\modules\persons\models\Address;
use yii\widgets\DetailView;

?>

<h4 class="col-sm-offset-1">1.ข้อมูลประวัติส่วนตัว</h4>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php 
        echo DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table '],
            'template' => $template,
            'attributes' => [
                'person.fullname',
                'person.fullname_en',
                'person.birthday:date',
                [
                    'attribute' => 'person.sex',
                    'value' => $model->person->sexLabel
                ],
                [
                    'attribute' => 'person.personDetail.nationality_id',
                    'value' => $model->person->personDetail->nationality->title
                ],
                [
                    'attribute' => 'person.personDetail.religion_id',
                    'value' => $model->person->personDetail->religion->title
                ],
                [
                    'attribute' => 'person.personDetail.person_status',
                    'value' => $model->person->personDetail->personStatusLabel
                ],
                [
                    'attribute' => 'person.personDetail.degree_id',
                    'value' => $model->person->personDetail->degree->title
                ],
                [
                    'attribute' => 'person.id_card',
                    'value' => $model->person->id_card
                ],
                [
                    'attribute' => 'person.personDetail.date_of_issue',
                    'format'=>'date',
                    'value' => $model->person->personDetail->date_of_issue
                ],
                [
                    'attribute' => 'person.personDetail.date_of_expiry',
                    'format'=>'date',
                    'value' => $model->person->personDetail->date_of_expiry
                ],
                [
                    'attribute' => 'person.address',
                    'value' => $model->person->ownAddress
                ],
            ]
        ]);
        ?>
    </div>
</div>

<?php
$this->registerJs("
 

function getAge(dateString) {
    dob = new Date(dateString);
    var today = new Date();
    var ageY = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    var ageM = Math.floor((today-dob) / ((365.25 * 24 * 60 * 60 * 1000)/12));
    ageM = (ageM>12)?ageM%12:ageM;
    ageM = (ageM==12)?0:ageM;
    

    var strAge = '';
    if(ageY>0||ageM>0){
        strAge = '" . Yii::t('app', 'อายุ') . " ';
    }else{
        strAge = '<p style=\"color:#f00;\">" . Yii::t('app', 'ควรเลือกวันที่ให้น้อยกว่าวันที่ปัจจุบัน') . "</p>';
    }
    if(ageY>0){
    strAge+=ageY+' " . Yii::t('app', 'ปี') . " ';
    }
    if(ageM>0){
    strAge+=ageM+' " . Yii::t('app', 'เดือน') . " ';
    }
                                     
   console.log(strAge);                                     
   return strAge;
}

        
        
        
         ");

