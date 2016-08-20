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

/* @var $this yii\web\View */
/* @var $model ikhlas\persons\models\Person */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('person', 'ข้อมูลการติดต่อ-สมัครสมาชิก');
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'Sellers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$modelAddress->contactBy = 1;
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?= $this->render('navbar', ['event' => $event]); ?>


        <?= Html::tag('h4', '2. ' . Yii::t('person', 'ข้อมูลการติดต่อ')); ?>


        <?php
        $form = ActiveForm::begin();
        ?>

        <div class="row">
            <div class="col-sm-11 col-sm-offset-1">
                <div class="row">
                    <div class="col-sm-6">  
                        <?= $form->field($modelAddress, 'contactBy')->radioList(Address::getItemContactBy()) ?>
                    </div>
                </div>



                <div id="addresOther">
                    <div class="row">
                        <div class="col-sm-2">  
                            <?= $form->field($modelAddress, 'no')->textInput(['id' => 'addresOther']) ?>
                        </div>
                        <div class="col-sm-3">  
                            <?= $form->field($modelAddress, 'alley')->textInput(['id' => 'addresOther']) ?>
                        </div>
                        <div class="col-sm-4">  
                            <?= $form->field($modelAddress, 'road')->textInput(['id' => 'addresOther']) ?>
                        </div>
                        <div class="col-sm-3">  
                            <?= $form->field($modelAddress, 'mu')->textInput(['id' => 'addresOther']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <?=
                            $form->field($modelAddress, "province_id")->dropdownList(LocalProvince::getList(), [
                                'id' => "ddl-province",
                                'prompt' => 'เลือกจังหวัด'
                            ]);
                            ?>
                        </div>

                        <div class="col-sm-4">
                            <?=
                            $form->field($modelAddress, "amphur_id")->widget(DepDrop::classname(), [
                                'options' => ['id' => "ddl-amphur"],
                                'data' => Address::itemAmphurList($modelAddress->province_id),
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
                            $form->field($modelAddress, "tambol_id")->widget(DepDrop::classname(), [
                                'data' => Address::itemAmphurList($modelAddress->amphur_id),
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
                        <div class="col-sm-3">
                            <?=
                            $form->field($modelAddress, "zip_code")->widget(MaskedInput::className(), [
                                'mask' => '99999'
                            ])
                            ?>
                        </div>  
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                    </div>  
                    <div class="col-sm-6">
                        <?= $form->field($model, 'home_phone')->textInput(['maxlength' => true]) ?>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>  
                    <div class="col-sm-6">
                        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                    </div>  
                </div>
            </div>        

        </div>       



        <hr />
        <?= Html::tag('h4', '3. ' . Yii::t('person', 'บุคคลที่สามารถติดต่อแทนท่านได้')); ?>
        <div class="row">
            <div class="col-sm-11 col-sm-offset-1">

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
                            'data' => Address::itemAmphurList($modelAddress->province_id),
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
                            'data' => Address::itemAmphurList($modelAddress->amphur_id),
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
                        <?= $form->field($modelPersonContact, 'zip_code')->widget(MaskedInput::className(), [
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



            </div>
        </div>



        <?= $this->render('buttonNav', ['event' => $event]); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>


<?php
$this->registerJs("
 $('input[name=\"Address[contactBy]\"').click(function(){
 //console.log($(this).select());
    if($(this).val()==1){
        $('#addresOther input,#addresOther select').each(function(){
            //console.log($(this).select());      
            $(this).attr('disabled',true);
        });
    }else if($(this).val()==2){
        $('#addresOther input,#addresOther select').each(function(){
            //console.log($(this).select());       
            $(this).attr('disabled',false);
        });
         $('#addresOther input[name=\"Address[no]\"]').focus();
    }
 });

$('#addresOther input,#addresOther select').each(function(){
            //console.log($(this).select());      
            $(this).attr('disabled',true);
        });

    
        
        
        
         ");

