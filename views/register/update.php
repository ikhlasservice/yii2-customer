<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\RegisterCustomer */

$this->title = Yii::t('system', 'Update {modelClass}: ', [
    'modelClass' => 'Register Customer',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Register Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update');
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->
    
    <div class='box-body pad'>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
