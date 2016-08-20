<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\widgets\MaskedInput;
use kartik\widgets\DepDrop;
use ikhlas\persons\models\Person;
use ikhlas\persons\models\LocalProvince;
use ikhlas\persons\models\Address;
use ikhlas\persons\models\Career;
?>

<hr />
<?= Html::tag('h4', '4. ' . Yii::t('person', 'ข้อมูลการทำงาน/อาชีพ')); ?>


<div class="row">
    <div class="col-sm-11 col-sm-offset-1">
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('career_id')) ?>
        <?= $modelPersonCareer->career->title ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('position_title')) ?>
        <?= $modelPersonCareer->position_title ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('working_age')) ?>
        <?= $modelPersonCareer->working_age ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-11 col-sm-offset-1">       
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_title')) ?>
        <?= $modelPersonCareer->workplace_title ?>
    </div>
    <div class="col-sm-11 col-sm-offset-1">       
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_no')) ?>
        <?= $modelPersonCareer->workplace_no ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_village')) ?>
        <?= $modelPersonCareer->workplace_village ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_noRoom')) ?>
        <?= $modelPersonCareer->workplace_noRoom ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_class')) ?>
        <?= $modelPersonCareer->workplace_class ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_mu')) ?>
        <?= $modelPersonCareer->workplace_mu ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_alley')) ?>
        <?= $modelPersonCareer->workplace_alley ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_road')) ?>
        <?= $modelPersonCareer->workplace_road ?>
        
     </div>
    <div class="col-sm-11 col-sm-offset-1">    
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('tambol_id')) ?>
        <?= $modelPersonCareer->tambol->name ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('amphur_id')) ?>
        <?= $modelPersonCareer->amphur->name ?>
        &nbsp;
        <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('province_id')) ?>
        <?= $modelPersonCareer->province->name ?>
         &nbsp;
          <?= $modelPersonCareer->zip_code ?>
         
         
    </div>
</div>




<div class="row">
    <div class="col-sm-11 col-sm-offset-1">    
       <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_phone')) ?>
        <?= $modelPersonCareer->workplace_phone ?>
         &nbsp;
         <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('workplace_fax')) ?>
        <?= $modelPersonCareer->workplace_fax ?>
    </div>  
</div>

<div class="row">
    <div class="col-sm-11 col-sm-offset-1">    
       <?= Html::tag('label', $modelPersonCareer->getAttributeLabel('salary')) ?>
        <?= $modelPersonCareer->salary ?>
    </div>  
</div>


<?php /* = $form->field($modelPersonCareer, 'income_other')->textarea(['rows' => 6]) */ ?>

<?php /* = $form->field($modelPersonCareer, 'expenses')->textarea(['rows' => 6]) */ ?>    










<?php
$this->registerJs("
 $('input[name=\"PersonCareer[career_id]\"').click(function(){
 //console.log($(this).select());
    if($(this).val()==0){
       $('input[name=\"Career[title]\"').attr('disabled',false);
       $('input[name=\"Career[title]\"').focus();
    }else{
       $('input[name=\"Career[title]\"').attr('disabled',true);
    }
 });

       $('input[name=\"Career[title]\"').attr('disabled',true);

    
        
        
        
         ");

