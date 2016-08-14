<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\customer\models\RegisterCustomer;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\customer\models\RegisterCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('person', 'ร่างใบสมัคร');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'ลูกค้าทั้งหมด'), 'url' => ['/customer/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'ใบสมัครทั้งหมด'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>

<!--    <p>
        <?= Html::a(Yii::t('system', 'Create Register Customer'), ['create'], ['class' => 'btn btn-success']) ?>
</p>-->

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'attribute' => 'fullname',
                    'format' => 'html',
                    'value' => function($model) {
                        return Html::a($model->fullname, ['view', 'id' => $model->id]);
                    },
                        ],
                        'created_at:datetime',
//                        [
//                            'label' => (new RegisterCustomer)->getAttributeLabel('status'),
//                            'format' => 'html',
//                            //'filter' => RegisterCustomer::getItemStatus(),
//                            'value' => function($model) {
//                                return $model->statusLabel;
//                            },
//                        ],
                        [
                            //'label'=>'',
                            'content' => function($model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span> แก้ไข', ['create', 'id' => $model->id], ['class' => 'btn btn-danger']);
                            },
                                ],
                            ],
                        ]);
                        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->

