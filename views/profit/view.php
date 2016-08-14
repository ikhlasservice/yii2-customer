<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\Profit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'Profits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="profit-view">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <p>
                <?= Html::a(Yii::t('customer', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('customer', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => Yii::t('customer', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                ],
                ]) ?>
            </p>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'val',
            ],
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
