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
                    <div class="col-sm-2"> 
                        <?= $form->field($modelPerson, 'prefix_id')->dropDownList(Person::getPrefixList(), ['prompt' => Yii::t('app', 'เลือก')]) ?>
                    </div>
                    <div class="col-sm-5">
                        <?= $form->field($modelPerson, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-5">
                        <?= $form->field($modelPerson, 'surname')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-5 col-sm-offset-2">
                        <?= $form->field($modelPerson, 'name_en')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-5">
                        <?= $form->field($modelPerson, 'surname_en')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-3 col-sm-offset-2">
                        <?=
                        $form->field($modelPerson, 'birthday')->widget(DatePicker::classname(), [
                            'language' => \Yii::$app->language,
                            'value' => date('Y-m-d H:i:s'),
                            'removeButton' => false,
                            'pickerButton' => ['icon' => 'calendar'],
                            'pluginOptions' => [
                                'changeYear' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                            'pluginEvents' => [
                                //"show" => "function(e) {  # `e` here contains the extra attributes }",
                                "hide" => "function(e) { 
                                        var val_age=$('#person-birthday').val(); 
                                            //getAge                                            
                                        $('#res_old').html(getAge(val_age));
                                 }",
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-3">  
                        <label class="control-label" for="person-birthday">&nbsp;</label>
                        <div id='res_old'  style="padding-top: 5px;"></div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-3">                
                        <?= $form->field($modelPerson, 'sex')->inline()->radioList(Person::getItemSex()) ?>
                    </div>
                    <div class="col-sm-3">    
                        <?=
                        $form->field($modelPersonDetail, 'nationality_id')->inline()->radioList(Nationality::getList());
                        ?>
                    </div>
                    <div class="col-sm-3">    
                        <?=
                        $form->field($modelPersonDetail, 'religion_id')->inline()->radioList(Religion::getList());
                        ?>
                    </div>
                    <div class="col-sm-3">    
                        <?=
                        $form->field($modelPersonDetail, 'person_status')->inline()->radioList(Person::getItemStatus());
                        ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">    
                        <?=
                        $form->field($modelPersonDetail, 'degree_id')->inline()->radioList(Degree::getList());
                        ?>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-6">    
                        <?=
                        $form->field($modelPerson, 'id_card')->widget(MaskedInput::className(), [
                            'mask' => '9-9999-99999-99-9'
                        ])
                        ?>
                    </div>
                    <div class="col-sm-3">
                        <?=
                        $form->field($modelPersonDetail, 'date_of_issue')->widget(DatePicker::classname(), [
                            'language' => \Yii::$app->language,
                            'value' => date('Y-m-d H:i:s'),
                            'removeButton' => false,
                            'pickerButton' => ['icon' => 'calendar'],
                            'pluginOptions' => [
                                'changeYear' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-3">
                        <?=
                        $form->field($modelPersonDetail, 'date_of_expiry')->widget(DatePicker::classname(), [
                            'language' => \Yii::$app->language,
                            'value' => date('Y-m-d H:i:s'),
                            'removeButton' => false,
                            'pickerButton' => ['icon' => 'calendar'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                        ?>
                    </div>
                </div>


                <h4>ที่อยู่ตามบัตร</h4>
                <div class="row">
                    <div class="col-sm-2">  
                        <?= $form->field($modelAddress, 'no')->textInput() ?>
                    </div>
                    <div class="col-sm-3">  
                        <?= $form->field($modelAddress, 'alley')->textInput() ?>
                    </div>
                    <div class="col-sm-4">  
                        <?= $form->field($modelAddress, 'road')->textInput() ?>
                    </div>
                    <div class="col-sm-3">  
                        <?= $form->field($modelAddress, 'mu')->textInput() ?>
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
                            'data' => Address::itemTambolList($modelAddress->amphur_id),
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

