<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Profit */

$this->title = Yii::t('customer', 'Create Profit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'Profits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="profit-create">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
