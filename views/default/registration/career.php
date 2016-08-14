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
use backend\modules\persons\models\Career;


?>

<hr />
        <?= Html::tag('h4', '4. ' . Yii::t('person', 'ข้อมูลการทำงาน/อาชีพ')); ?>


        

        



<div class="row">
     <div class="col-sm-12">
         
                <?=
                $form->field($modelPersonCareer, 'career_id')->inline()->radioList(Career::getList(), [
                    'template'=>'<div class="row"><div class="col-sm-12">{label}</div></div><div class="row">{input}</div>{error}{hint}',
                    'itemOptions' => [
                        'labelOptions' => ['class' => 'col-sm-4'],
                    ]
                ])
                ?>
</div>
</div>
                <?= $form->field(new Career(), 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelPersonCareer, 'position_title')->textInput(['maxlength' => true]) ?>

                <?=
                $form->field($modelPersonCareer, 'working_age')->widget(MaskedInput::className(), [
                    'mask' => '99 ปี 99 เดือน'
                ])
                ?>

                <?= $form->field($modelPersonCareer, 'workplace_title')->textInput(['maxlength' => true]) ?>



                <div class="row">
                    <div class="col-sm-1">
                        <?= $form->field($modelPersonCareer, 'workplace_no')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($modelPersonCareer, 'workplace_village')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-1">
                        <?= $form->field($modelPersonCareer, 'workplace_noRoom')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-1">
                        <?= $form->field($modelPersonCareer, 'workplace_class')->textInput(['maxlength' => true]) ?>

                    </div>  
                    <div class="col-sm-2">
                        <?= $form->field($modelPersonCareer, 'workplace_mu')->textInput() ?>

                    </div>  
                    <div class="col-sm-4">
                        <?= $form->field($modelPersonCareer, 'workplace_alley')->textInput(['maxlength' => true]) ?>

                    </div>  
                </div>





                <?= $form->field($modelPersonCareer, 'workplace_road')->textInput(['maxlength' => true]) ?>




                <div class="row">
                    <div class="col-sm-4">
                        <?=
                        $form->field($modelPersonCareer, "province_id")->dropdownList(LocalProvince::getList(), [
                            'id' => "ddl-province-career",
                            'prompt' => 'เลือกจังหวัด'
                        ]);
                        ?>
                    </div>

                    <div class="col-sm-4">
                        <?=
                        $form->field($modelPersonCareer, "amphur_id")->widget(DepDrop::classname(), [
                            'options' => ['id' => "ddl-amphur-career"],
                            'data' => Address::itemAmphurList($modelPersonCareer->province_id),
                            'pluginOptions' => [
                                'depends' => ["ddl-province-career"],
                                'placeholder' => 'เลือกอำเภอ...',
                                'url' => Url::to(['/persons/default/get-amphur'])
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="col-sm-4">
                        <?=
                        $form->field($modelPersonCareer, "tambol_id")->widget(DepDrop::classname(), [
                            'data' => Address::itemTambolList($modelPersonCareer->amphur_id),
                            'pluginOptions' => [
                                'depends' => ["ddl-province-career", "ddl-amphur-career"],
                                'placeholder' => 'เลือกตำบล...',
                                'url' => Url::to(['/persons/default/get-tambol'])
                            ]
                        ]);
                        ?>
                    </div>  
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($modelPersonCareer, 'zip_code')->widget(MaskedInput::className(), [
                            'mask' => '99999'
                        ])
                        ?> 
                    </div> 
                    <div class="col-sm-4">
                        <?= $form->field($modelPersonCareer, 'workplace_phone')->textInput(['maxlength' => true]) ?>
                    </div> 
                    <div class="col-sm-4">
                        <?= $form->field($modelPersonCareer, 'workplace_fax')->textInput(['maxlength' => true]) ?>
                    </div>  
                </div>


                <?= $form->field($modelPersonCareer, 'salary')->textInput(['maxlength' => true]) ?>

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

