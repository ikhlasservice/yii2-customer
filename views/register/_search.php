<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\RegisterCustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="register-customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'person_id') ?>

    <?= $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'doc') ?>

    <?php // echo $form->field($model, 'doc_fully') ?>

    <?php // echo $form->field($model, 'doc_because') ?>

    <?php // echo $form->field($model, 'score') ?>

    <?php // echo $form->field($model, 'seller_id') ?>

    <?php // echo $form->field($model, 'seller_receive') ?>

    <?php // echo $form->field($model, 'seller_receive_because') ?>

    <?php // echo $form->field($model, 'seller_date') ?>

    <?php // echo $form->field($model, 'staff_id') ?>

    <?php // echo $form->field($model, 'staff_receive') ?>

    <?php // echo $form->field($model, 'staff_date') ?>

    <?php // echo $form->field($model, 'financial_amount') ?>

    <?php // echo $form->field($model, 'staff_receive_because') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('system', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('system', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
