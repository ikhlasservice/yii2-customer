<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($modelPerson, 'name')->textInput() ?>

    <?php
                echo $this->render('/register/registration/person', [
                    'form' => $form,
                    //'model' => $model,
                    'modelPerson' => $modelPerson,
                    'modelPersonDetail' => $modelPersonDetail,
                    'modelAddress' => $modelAddress,
                ]);
                ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('system', 'Create') : Yii::t('system', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
