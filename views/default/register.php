<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\Customer */

$this->title = Yii::t('customer', 'ใบสมัครสมาชิก');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->

    <div class='box-body pad'>

        <?=
        $this->render('_form', [
            'model' => $model,
            'modelPerson' => $modelPerson,
            'modelPersonDetail' => $modelPersonDetail,
            'modelAddress' => $modelAddress,
            'modelContactAddress' => $modelContactAddress,
            'modelPersonContact' => $modelPersonContact,
            'modelPersonCareer' => $modelPersonCareer,
        ])
        ?>

    </div><!--box-body pad-->
</div><!--box box-info-->


<?php
Modal::begin();

Modal::end();
