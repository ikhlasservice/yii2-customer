<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Customer */

$this->title = $model->person->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>


        <div class='box-tools'>
            <?php
            if (Yii::$app->user->can('seller')):
                ?>  

                <?= Html::a(Yii::t('customer', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-sm pull-right']) ?>

            <?php endif;
            ?>
            <?php
//        echo Html::a(Yii::t('system', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('system', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ])
            ?>
        </div>
    </div><!--box-header -->

    <div class='box-body pad'>

        <div class='row'>
            <div class='col-sm-3'>
                <?= Html::img($model->person->image, ['width' => '100%']) ?>
            </div>
            <div class='col-sm-9'>
                <?php
                echo DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table '],
                    'template' => '<tr><th width="100" class="text-right text-nowrap table-responsive">{label}</th><td>{value}</td></tr>',
                    'attributes' => [
                        [
                            'attribute' => 'id',
                            'format' => 'raw',
                            'value' => $model->id . ' ' . Html::button(Yii::t('customer', 'ประวัติการสมัคร'), ['class' => 'btn btn-link btn-xs activity-view-link',
                                'data-toggle' => 'modal',
                                'data-target' => '#activity-modal',
                                'data-id' => $model->registerCustomer->id])
                        ],
                        [
                            'attribute' => 'person.fullname',
                            'value' => $model->person->fullname . " " . ($model->person->fullname_en ? '(' . $model->person->fullname_en . ')' : ''),
                        ],
                        [
                            'attribute' => 'person.telephone',
                            'value' => implode(', ', [$model->person->telephone, $model->person->home_phone])
                        ],
                        [
                            'attribute' => 'person.email',
                            'format' => 'email',
                            'value' => $model->person->email
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => $model->statusLabel
                        ],
                        [
                            'attribute' => 'profit_id',
                            'format' => 'html',
                            'value' => $model->profit->val . ' ' . Html::a('แก้ไข', ['profit', 'id' => $model->id]),
                            'visible' => Yii::$app->user->can('staff')
                        ],
                        [
                            'attribute' => 'financial_amount',
                            'format' => 'html',
                            'value' => Yii::$app->formatter->asDecimal($model->financial_amount) . ' ' . Yii::t('customer', 'บาท') . ' ' . Html::a('แก้ไข', ['financial', 'id' => $model->id]),
                            'visible' => Yii::$app->user->can('staff')
                        ],
                    ],
                ]);


                Modal::begin([
                    'id' => 'activity-modal',
                    'header' => Html::tag('h4', 'ประวัติการสมัคร', ['class' => 'modal-title']),
                    'size' => 'modal-lg',
                    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
                ]);
                Modal::end();
                ?>
            </div>
        </div>


        <div class='row'>
            <div class='col-sm-12'>
                <?php
                echo Tabs::widget([
                    'items' => [
                        [
                            'label' => 'ข้อมูลทั่วไป',
                            'content' => $this->render('view/person', ['model' => $model->person]),
                            'active' => true
                        ],
                        [
                            'label' => 'ข้อมูลการชำระ',
                        //'content' => 'ข้อมูลการชำระ',
                        //'headerOptions' => 'Anim pariatur cliche...',
                        //'options' => ['id' => 'myveryownID'],
                        ],
                    ]
                ]);
                ?>


            </div>
        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->


<?php
$this->registerJs("
$('.activity-view-link').click(function(e) {
            var id = $(this).attr('data-id');
            $.get(
                '" . Url::to(['/customer/register/view']) . "',
                {
                    id: id
                },
                function (data)
                {
                    $('#activity-modal').find('.modal-body').html(data);
                    $('.modal-body').html(data);
                    $('#activity-modal').modal('show');
                }
            );
        });
        
        ");
