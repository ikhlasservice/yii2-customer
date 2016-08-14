<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel ikhlas\customer\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('customer', 'ลูกค้าทั้งหมด');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
      <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'headerOptions' => ['width' => '100']
                ],
                'fullname',
                [
                    'attribute' => 'profit_id',
                    'filter' => ikhlas\customer\models\Profit::getList(),
                    'value' => function($model) {
                        return $model->profit_id?$model->profit->val:null;
                    }
                ],
                [
                    'attribute' => 'financial_amount',
                    'value' => function($model) {
                        return Yii::$app->formatter->asDecimal($model->financial_amount);
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'filter' => ikhlas\customer\models\Customer::getItemStatus(),
                    'value' => function($model) {
                        return $model->statusLabel;
                    }
                ],
                [
                    'attribute' => 'seller_id',
                    'format' => 'html',
                    //'filter' => ikhlas\customer\models\Customer::getItemStatus(),
                    'value' => function($model) {
                        return $model->seller->displayname;
                    },
                    'visible' => Yii::$app->user->can('staff'),
                ],
                // 'seller_id',
                // 'staff_id',
                [
                    //'label'=>'',
                    'content' => function($model) {
                        return
                                Html::beginTag('div', ['class' => 'btn-group'])
                                . Html::a('<span class="glyphicon glyphicon-pencil"></span> รายละเอียด', ['view', 'id' => $model->id], ['class' => 'btn btn-primary'])
                                . Html::beginTag('button', ['type' => 'button', 'class' => 'btn btn-primary dropdown-toggle', 'data-toggle' => "dropdown", 'aria-haspopup' => "true", 'aria-expanded' => "false"])
                                . Html::tag('span', '', ['class' => 'caret'])
                                . Html::tag('span', 'Toggle Dropdown', ['class' => 'sr-only'])
                                . Html::endTag('button')
                                . Html::beginTag('ul', ['class' => "dropdown-menu"])
                                . Html::tag('li', Html::a('<span class="glyphicon glyphicon-eye-open"></span> ดู', ['view', 'id' => $model->id]))
                                . Html::tag('li', Html::a('<span class="glyphicon glyphicon-trash"></span> ลบ', ['delete', 'id' => $model->id], [
                                            'title' => "Delete",
                                            'aria-label' => "Delete",
                                            'data-confirm' => "Are you sure you want to delete this item?",
                                            'data-method' => "post"
                                ]))
                                . Html::endTag('ul')
                                . Html::endTag('div');
                    },
                            'visible' => Yii::$app->user->can('seller'),
                        ],
                        [
                            //'label'=>'',
                            'content' => function($model) {
                                return
                                        //Html::beginTag('div', ['class' => 'btn-group'])
                                        Html::a('<span class="glyphicon glyphicon-eye-open"></span> รายละเอียด', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                //. Html::beginTag('button', ['type' => 'button', 'class' => 'btn btn-primary dropdown-toggle', 'data-toggle' => "dropdown", 'aria-haspopup' => "true", 'aria-expanded' => "false"])
                                //. Html::tag('span', '', ['class' => 'caret'])
                                //. Html::tag('span', 'Toggle Dropdown', ['class' => 'sr-only'])
                                //. Html::endTag('button')
                                //. Html::beginTag('ul', ['class' => "dropdown-menu"])
                                //. Html::tag('li', Html::a('<span class="glyphicon glyphicon-eye-open"></span> ดู', ['view', 'id' => $model->id]))                                        
                                //. Html::endTag('ul')
//                                        . Html::endTag('div');
                            },
                                    'visible' => Yii::$app->user->can('staff'),
                                ],
                            //['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]);
                        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->
