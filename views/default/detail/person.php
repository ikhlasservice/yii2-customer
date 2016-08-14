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

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<h4>1.ข้อมูลประวัติส่วนตัว</h4>


<div class="row">
    <div class="col-sm-10 col-sm-offset-1">   
        <?= Html::tag('label', $modelPerson->getAttributeLabel('fullname')) ?>
        <?= $modelPerson->fullname ?>
    </div>
</div>
<div class="row">  
    <div class="col-sm-10 col-sm-offset-1">
        <?= Html::tag('label', $modelPerson->getAttributeLabel('fullname_en')) ?>
        <?= $modelPerson->fullname_en ?>
    </div>

</div>



<div class="row">
    <div class="col-sm-3 col-sm-offset-1">
        <?= Html::tag('label', $modelPerson->getAttributeLabel('birthday')) ?>
        <?= Yii::$app->formatter->asDate($modelPerson->birthday) ?>
    </div>
    <div class="col-sm-3">  
        <label class="control-label" for="person-birthday">&nbsp;</label>
        <div id='res_old'  style="padding-top: 5px;"></div>
    </div>
</div>



<div class="row">
    <div class="col-sm-2 col-sm-offset-1">            
        <?= Html::tag('label', $modelPerson->getAttributeLabel('sex')) ?>
        <?= $modelPerson->sexLabel ?>

    </div>
    <div class="col-sm-2">   
        <?= Html::tag('label', $modelPersonDetail->getAttributeLabel('nationality_id')) ?>
        <?= $modelPersonDetail->nationality->title ?>

    </div>
    <div class="col-sm-2">   
        <?= Html::tag('label', $modelPersonDetail->getAttributeLabel('religion_id')) ?>
        <?= $modelPersonDetail->religion->title ?>
    </div>
    <div class="col-sm-3">            
        <?= Html::tag('label', $modelPersonDetail->getAttributeLabel('person_status')) ?>
        <?= $modelPersonDetail->personStatusLabel ?>
    </div>
</div>


<div class="row">
    <div class="col-sm-11 col-sm-offset-1">            
        <?= Html::tag('label', $modelPersonDetail->getAttributeLabel('degree_id')) ?>
        <?= $modelPersonDetail->degree->title ?>
    </div>
</div>



<div class="row">
    <div class="col-sm-5 col-sm-offset-1">    
        <?= Html::tag('label', $modelPerson->getAttributeLabel('id_card')) ?>
        <?= $modelPerson->id_card ?>
    </div>
    <div class="col-sm-3">
        <?= Html::tag('label', $modelPersonDetail->getAttributeLabel('date_of_issue')) ?>
        <?= Yii::$app->formatter->asDate($modelPersonDetail->date_of_issue) ?>

    </div>
    <div class="col-sm-3">
        <?= Html::tag('label', $modelPersonDetail->getAttributeLabel('date_of_expiry')) ?>
        <?= Yii::$app->formatter->asDate($modelPersonDetail->date_of_expiry) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h4>ที่อยู่ตามบัตร</h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-11 col-sm-offset-1">
        <?= Html::tag('label', $modelAddress->getAttributeLabel('no')) ?>
        <?= $modelAddress->no ?>
        &nbsp;
        <?= Html::tag('label', $modelAddress->getAttributeLabel('alley')) ?>
        <?= $modelAddress->alley ?>
        &nbsp;
        <?= Html::tag('label', $modelAddress->getAttributeLabel('road')) ?>
        <?= $modelAddress->road ?>
        &nbsp;
        <?= Html::tag('label', $modelAddress->getAttributeLabel('mu')) ?>
        <?= $modelAddress->mu ?>
        &nbsp;
        <?= Html::tag('label', $modelAddress->getAttributeLabel('tambol_id')) ?>
        <?= $modelAddress->tambol->name ?>
        &nbsp;
        <?= Html::tag('label', $modelAddress->getAttributeLabel('amphur_id')) ?>
        <?= $modelAddress->amphur->name ?>
        &nbsp;
        <?= Html::tag('label', $modelAddress->getAttributeLabel('province_id')) ?>
        <?= $modelAddress->province->name ?>
         &nbsp;
          <?= $modelAddress->zip_code ?>
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

