<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\customer\models\RegisterCustomer;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\customer\models\RegisterCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('person', 'ใบสมัครทั้งหมด');
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'ลูกค้าทั้งหมด'), 'url' => ['/customer/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->

    <div class='box-body pad'>


<?php Pjax::begin(); ?>  
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
                        'seller_date:datetime',
                         [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
//                            'filter' => RegisterCustomer::getItemStatus(),
//                            'value' => function($model) {
//                                return $model->statusLabel;
//                            },
                              'visible' => Yii::$app->user->can('seller'),
                        ],   
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'filter' => RegisterCustomer::getItemStatus(),
                            'value' => function($model) {
                                return $model->statusLabel;
                            },
                        ],
                        [
                            //'label'=>'',
                            'content' => function($model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> ตรวจสอบ', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                                ],
                            ],
                        ]);
                        ?>
<?php Pjax::end(); ?> 

    </div><!--box-body pad-->
</div><!--box box-info-->

