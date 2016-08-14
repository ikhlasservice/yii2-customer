<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\widgets\MaskedInput;
use kartik\widgets\DepDrop;
use backend\modules\persons\models\Person;
use backend\modules\persons\models\LocalProvince;
use backend\modules\persons\models\Address;

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>
<hr />
<?= Html::tag('h4', '2. ' . Yii::t('person', 'ข้อมูลการติดต่อ')); ?>

<div class="row">
    <div class="col-sm-6">  
<?= $form->field($modelContactAddress, 'contactBy')->radioList(Address::getItemContactBy()) ?>
    </div>
</div>



<div id="addresOther">
    <div class="row">
        <div class="col-sm-2">  
<?= $form->field($modelContactAddress, 'no')->textInput(['id' => 'addresOther']) ?>
        </div>
        <div class="col-sm-3">  
<?= $form->field($modelContactAddress, 'alley')->textInput(['id' => 'addresOther']) ?>
        </div>
        <div class="col-sm-4">  
<?= $form->field($modelContactAddress, 'road')->textInput(['id' => 'addresOther']) ?>
        </div>
        <div class="col-sm-3">  
<?= $form->field($modelContactAddress, 'mu')->textInput(['id' => 'addresOther']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
<?=
$form->field($modelContactAddress, "province_id")->dropdownList(LocalProvince::getList(), [
    'id' => "ddl-province-other",
    'prompt' => 'เลือกจังหวัด'
]);
?>
        </div>

        <div class="col-sm-4">
<?=
$form->field($modelContactAddress, "amphur_id")->widget(DepDrop::classname(), [
    'options' => ['id' => "ddl-amphur-other"],
    'data' => Address::itemAmphurList($modelContactAddress->province_id),
    'pluginOptions' => [
        'depends' => ["ddl-province-other"],
        'placeholder' => 'เลือกอำเภอ...',
        'url' => Url::to(['/persons/default/get-amphur'])
    ]
]);
?>
        </div>

        <div class="col-sm-4">
<?=
$form->field($modelContactAddress, "tambol_id")->widget(DepDrop::classname(), [

    'data' => Address::itemTambolList($modelContactAddress->amphur_id),
    'pluginOptions' => [
        'depends' => ["ddl-province-other", "ddl-amphur-other"],
        'placeholder' => 'เลือกตำบล...',
        'url' => Url::to(['/persons/default/get-tambol'])
    ]
]);
?>
        </div>  
    </div>

    <div class="row">
        <div class="col-sm-3">
<?=
$form->field($modelContactAddress, "zip_code")->widget(MaskedInput::className(), [
    'mask' => '99999'
])
?>
        </div>  
    </div>
</div>


<div class="row">
    <div class="col-sm-6">
<?= $form->field($modelPerson, 'telephone')->textInput(['maxlength' => true]) ?>
    </div>  
    <div class="col-sm-6">
<?= $form->field($modelPerson, 'home_phone')->textInput(['maxlength' => true]) ?>
    </div>  
</div>

<div class="row">
    <div class="col-sm-6">
<?= $form->field($modelPerson, 'email')->textInput(['maxlength' => true]) ?>
    </div>  
    <div class="col-sm-6">
<?= $form->field($modelPerson, 'facebook')->textInput(['maxlength' => true]) ?>
    </div>  
</div>




<hr />
<?= Html::tag('h4', '3. ' . Yii::t('person', 'บุคคลที่สามารถติดต่อแทนท่านได้')); ?>


<div class="row">
    <div class="col-sm-2">  
<?= $form->field($modelPersonContact, 'prefix_id')->dropDownList(Person::getPrefixList(), ['prompt' => Yii::t('app', 'เลือก')]) ?>    
    </div>
    <div class="col-sm-5">  
<?= $form->field($modelPersonContact, 'name')->textInput(['maxlength' => true]) ?>  
    </div>
    <div class="col-sm-5">  
<?= $form->field($modelPersonContact, 'surname')->textInput(['maxlength' => true]) ?>
    </div>
</div>







<?= $form->field($modelPersonContact, 'relationship')->textInput(['maxlength' => true]) ?>


<div class="row">
    <div class="col-sm-2">  
<?= $form->field($modelPersonContact, 'address_no')->textInput(['maxlength' => true]) ?>  
    </div>
    <div class="col-sm-3">  
<?= $form->field($modelPersonContact, 'address_alley')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">  
<?= $form->field($modelPersonContact, 'address_village')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">  
<?= $form->field($modelPersonContact, 'address_road')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">  
<?= $form->field($modelPersonContact, 'address_mu')->textInput() ?>
    </div>
</div>           



<div class="row">
    <div class="col-sm-4">
<?=
$form->field($modelPersonContact, "province_id")->dropdownList(LocalProvince::getList(), [
    'id' => "ddl-province-con",
    'prompt' => 'เลือกจังหวัด'
]);
?>
    </div>

    <div class="col-sm-4">
<?=
$form->field($modelPersonContact, "amphur_id")->widget(DepDrop::classname(), [
    'options' => ['id' => "ddl-amphur-con"],
    'data' => Address::itemAmphurList($modelPersonContact->province_id),
    'pluginOptions' => [
        'depends' => ["ddl-province-con"],
        'placeholder' => 'เลือกอำเภอ...',
        'url' => Url::to(['/persons/default/get-amphur'])
    ]
]);
?>
    </div>

    <div class="col-sm-4">
<?=
$form->field($modelPersonContact, "tambol_id")->widget(DepDrop::classname(), [
    'data' => Address::itemTambolList($modelPersonContact->amphur_id),
    'pluginOptions' => [
        'depends' => ["ddl-province-con", "ddl-amphur-con"],
        'placeholder' => 'เลือกตำบล...',
        'url' => Url::to(['/persons/default/get-tambol'])
    ]
]);
?>
    </div>  
</div>

<div class="row">
    <div class="col-sm-4">
<?=
$form->field($modelPersonContact, 'zip_code')->widget(MaskedInput::className(), [
    'mask' => '99999'
])
?>
    </div>  
</div>

<div class="row">
    <div class="col-sm-4">
        <?= $form->field($modelPersonContact, 'tel_number')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($modelPersonContact, 'home_phone')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($modelPersonContact, 'email')->textInput(['maxlength' => true]) ?>
    </div>  
</div>










<?php
$this->registerJs("
    addresOtherHide();
    //console.log($('input[name=\"ContactAddress[contactBy]\"]:checked').val());
  if($('input[name=\"ContactAddress[contactBy]\"]:checked').val()==2){
     addresOtherShow();
  }
 $('input[name=\"ContactAddress[contactBy]\"]').click(function(){
 //console.log($(this).select());
    if($(this).val()==1){
       addresOtherHide();
    }else if($(this).val()==2){
       addresOtherShow();
       $('#addresOther input[name=\"ContactAddress[no]\"]').focus();
    }
 });
 



function addresOtherHide(){
    $('#addresOther input,#addresOther select').each(function(){
            //console.log($(this).select());      
            $(this).attr('disabled',true);
    });
}
function addresOtherShow(){
    $('#addresOther input,#addresOther select').each(function(){
            console.log($(this).select());       
            $(this).attr('disabled',false);
    });         
}




    
        
        
        
         ");

