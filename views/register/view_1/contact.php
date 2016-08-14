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
    <div class="col-sm-6  col-sm-offset-1">  
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('contactBy')) ?>
        <?= $modelContactAddress->contactByLabel ?>
    </div>
</div>



<div id="addresOther">
    <div class="row">
        <div class="col-sm-11  col-sm-offset-1"> 
         
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('no')) ?>
        <?= $modelContactAddress->no ?>
        &nbsp;
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('alley')) ?>
        <?= $modelContactAddress->alley ?>
        &nbsp;
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('road')) ?>
        <?= $modelContactAddress->road ?>
        &nbsp;
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('mu')) ?>
        <?= $modelContactAddress->mu ?>
        &nbsp;
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('tambol_id')) ?>
        <?= $modelContactAddress->tambol->name ?>
        &nbsp;
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('amphur_id')) ?>
        <?= $modelContactAddress->amphur->name ?>
        &nbsp;
        <?= Html::tag('label', $modelContactAddress->getAttributeLabel('province_id')) ?>
        <?= $modelContactAddress->province->name ?>
         &nbsp;
          <?= $modelContactAddress->zip_code ?>
            
            
            
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-11 col-sm-offset-1">
        <?= Html::tag('label', $modelPerson->getAttributeLabel('telephone')) ?>
        <?= $modelPerson->telephone ?>
         &nbsp;
        <?= Html::tag('label', $modelPerson->getAttributeLabel('home_phone')) ?>
        <?= $modelPerson->home_phone ?>
         &nbsp;
        <?= Html::tag('label', $modelPerson->getAttributeLabel('email')) ?>
        <?= $modelPerson->email ?>
         &nbsp;
        <?= Html::tag('label', $modelPerson->getAttributeLabel('facebook')) ?>
        <?= $modelPerson->facebook ?>
    </div>  
</div>


<hr />
<?= Html::tag('h4', '3. ' . Yii::t('person', 'บุคคลที่สามารถติดต่อแทนท่านได้')); ?>


<div class="row">
    <div class="col-sm-11 col-sm-offset-1">  
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('fullname')) ?>
        <?= $modelPersonContact->fullname ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-11 col-sm-offset-1">  
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('relationship')) ?>
        <?= $modelPersonContact->relationship ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-11 col-sm-offset-1">  
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('address_no')) ?>
        <?= $modelPersonContact->address_no ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('address_alley')) ?>
        <?= $modelPersonContact->address_alley ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('address_road')) ?>
        <?= $modelPersonContact->address_road ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('address_mu')) ?>
        <?= $modelPersonContact->address_mu ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('tambol_id')) ?>
        <?= $modelPersonContact->tambol->name ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('amphur_id')) ?>
        <?= $modelPersonContact->amphur->name ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('province_id')) ?>
        <?= $modelPersonContact->province->name ?>
         &nbsp;
          <?= $modelPersonContact->zip_code ?>

    </div>
</div>           


<div class="row">
    <div class="col-sm-11 col-sm-offset-1">
        <?= Html::tag('label', $modelPersonContact->getAttributeLabel('tel_number')) ?>
        <?= $modelPersonContact->tel_number ?>
        &nbsp;
         <?= Html::tag('label', $modelPersonContact->getAttributeLabel('home_phone')) ?>
        <?= $modelPersonContact->home_phone ?>
        &nbsp;
         <?= Html::tag('label', $modelPersonContact->getAttributeLabel('email')) ?>
        <?= $modelPersonContact->email ?>
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

