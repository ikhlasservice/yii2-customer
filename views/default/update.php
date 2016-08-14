<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Customer */

$this->title = Yii::t('system', 'Update {modelClass}: ', [
            'modelClass' => 'Customer',
        ]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'ลูกค้าทั้งหมด'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'แก้ไข');
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>

        <?=
        $this->render('_form', [
            'model' => $model,
            'modelPerson' => $modelPerson,
            'modelPersonDetail' => $modelPersonDetail,
            'modelAddress' => $modelAddress,
        ])
        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->
