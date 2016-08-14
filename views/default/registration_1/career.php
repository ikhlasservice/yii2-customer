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

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\Person */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('person', 'ข้อมูลการทำงาน/อาชีพ-ตัวแทนจำหน่าย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'Sellers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?= $this->render('navbar', ['event' => $event]); ?>


        <?= Html::tag('h4', '4. ' . Yii::t('person', 'ข้อมูลการทำงาน/อาชีพ')); ?>


        <?php
        $form = ActiveForm::begin();
        ?>

        <div class="row">
            <div class="col-sm-11 col-sm-offset-1">



<div class="row">
     <div class="col-sm-12">
         
                <?=
                $form->field($model, 'career_id')->inline()->radioList(Career::getList(), [
                    'template'=>'<div class="row"><div class="col-sm-12">{label}</div></div><div class="row">{input}</div>{error}{hint}',
                    'itemOptions' => [
                        'labelOptions' => ['class' => 'col-sm-4'],
                    ]
                ])
                ?>
</div>
</div>
                <?= $form->field(new Career(), 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'position_title')->textInput(['maxlength' => true]) ?>

                <?=
                $form->field($model, 'working_age')->widget(MaskedInput::className(), [
                    'mask' => '99 ปี 99 เดือน'
                ])
                ?>

                <?= $form->field($model, 'workplace_title')->textInput(['maxlength' => true]) ?>



                <div class="row">
                    <div class="col-sm-1">
                        <?= $form->field($model, 'workplace_no')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'workplace_village')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-1">
                        <?= $form->field($model, 'workplace_noRoom')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-1">
                        <?= $form->field($model, 'workplace_class')->textInput(['maxlength' => true]) ?>

                    </div>  
                    <div class="col-sm-2">
                        <?= $form->field($model, 'workplace_mu')->textInput() ?>

                    </div>  
                    <div class="col-sm-4">
                        <?= $form->field($model, 'workplace_alley')->textInput(['maxlength' => true]) ?>

                    </div>  
                </div>





                <?= $form->field($model, 'workplace_road')->textInput(['maxlength' => true]) ?>




                <div class="row">
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, "province_id")->dropdownList(LocalProvince::getList(), [
                            'id' => "ddl-province",
                            'prompt' => 'เลือกจังหวัด'
                        ]);
                        ?>
                    </div>

                    <div class="col-sm-4">
                        <?=
                        $form->field($model, "amphur_id")->widget(DepDrop::classname(), [
                            'options' => ['id' => "ddl-amphur"],
                            'data' => Address::itemAmphurList($model->province_id),
                            'pluginOptions' => [
                                'depends' => ["ddl-province"],
                                'placeholder' => 'เลือกอำเภอ...',
                                'url' => Url::to(['/persons/default/get-amphur'])
                            ]
                        ]);
                        ?>
                    </div>

                    <div class="col-sm-4">
                        <?=
                        $form->field($model, "tambol_id")->widget(DepDrop::classname(), [
                            'data' => Address::itemAmphurList($model->amphur_id),
                            'pluginOptions' => [
                                'depends' => ["ddl-province", "ddl-amphur"],
                                'placeholder' => 'เลือกตำบล...',
                                'url' => Url::to(['/persons/default/get-tambol'])
                            ]
                        ]);
                        ?>
                    </div>  
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'zip_code')->widget(MaskedInput::className(), [
                            'mask' => '99999'
                        ])
                        ?> 
                    </div> 
                    <div class="col-sm-4">
                        <?= $form->field($model, 'workplace_phone')->textInput(['maxlength' => true]) ?>
                    </div> 
                    <div class="col-sm-4">
                        <?= $form->field($model, 'workplace_fax')->textInput(['maxlength' => true]) ?>
                    </div>  
                </div>


                <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

                <?php /* = $form->field($model, 'income_other')->textarea(['rows' => 6]) */ ?>

                <?php /* = $form->field($model, 'expenses')->textarea(['rows' => 6]) */ ?>    




            </div>
        </div>



        <?= $this->render('buttonNav', ['event' => $event]); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>


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

