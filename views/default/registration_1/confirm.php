<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\seller\models\RegisterSeller;

/* @var $this yii\web\View */
/* @var $model backend\modules\seller\models\RegisterSeller */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('person', 'ยืนยัน-ตัวแทนจำหน่าย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'Sellers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-body">
        <?php /*= $this->render('navbar', ['event' => $event]); */?>
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-sm-11 col-sm-offset-1">
               
                <?=Html::tag('h4',Yii::t('person', 'ข้อกำหนดแลเงื่อนไงการเป็นตัวแทนของบริษัท อิคลาส เซอร์วิสจำกัด'),['class'=>'text-center'])?>
                <div class="row">
                    <div class="col-sm-12">
                        <div style="padding: 10px 10px">
                    <?php
                    foreach ($model->getItemCondition() as $key => $val) {
                        echo $key . ". " . $val . '<br/>';
                    }
                    ?>
                        </div>
                    <?= $form->field($model, 'confirm')->checkbox() ?>
                    </div>
                </div>



                
                <?php /*= $form->field($model, 'created_at')->textInput() ?>

                <?= $form->field($model, 'status')->dropDownList([ 4 => '4', 3 => '3', 2 => '2', 1 => '1', 0 => '0',], ['prompt' => '']) ?>

                <?= $form->field($model, 'person_id')->textInput() ?>

                <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'doc')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'doc_fully')->dropDownList([ 2 => '2', 1 => '1', 0 => '0',], ['prompt' => '']) ?>

                <?= $form->field($model, 'doc_because')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'score')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'staff_id')->textInput() ?>

                <?= $form->field($model, 'staff_receive')->dropDownList([ 1 => '1', 0 => '0',], ['prompt' => '']) ?>

                <?= $form->field($model, 'staff_date')->textInput() ?>

                <?= $form->field($model, 'class')->dropDownList([ 'D' => 'D', 'C' => 'C', 'B' => 'B', 'A' => 'A',], ['prompt' => '']) */?>


                <?= $this->render('buttonNav', ['event' => $event]); ?>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
