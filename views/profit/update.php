<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Profit */

$this->title = Yii::t('customer', 'Update {modelClass}: ', [
    'modelClass' => 'Profit',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'Profits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('customer', 'Update');
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="profit-update">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->
            
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
