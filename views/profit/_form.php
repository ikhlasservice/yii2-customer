<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Profit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'val')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('customer', 'Create') : Yii::t('customer', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
