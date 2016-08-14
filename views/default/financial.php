<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$asset = backend\assets\AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model ikhlas\customer\models\Customer */

$this->title = Yii::t('customer', 'สร้างบัญชีลูกค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-body pad'>

        <?php $form = ActiveForm::begin(); ?>
        <div class="row"> 
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="row"> 
                    <div class="col-sm-5"> 
                        <?= Html::img($asset->baseUrl . "/images/banner.png", ['width' => '100%']) ?>
                    </div>
                    <div class="col-sm-3 col-sm-offset-4"> 
                        <?= $form->field($model, 'id')->textInput(['readonly' => TRUE]) ?>
                    </div>
                </div>
                <hr />
                <div class="row"> 
                    <div class="col-sm-12">
                        <?php
                        echo DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table '],
                            'template' => '<tr><th width="100" class="text-right text-nowrap table-responsive">{label}</th><td>{value}</td></tr>',
                            'attributes' => [
                                'fullname',
                                [
                                    'attribute' => 'financial_amount',
                                    'format' => ['decimal', 2]
                                ],
                                'created_at:datetime',
                                [
                                    'attribute' => 'seller_id',
                                    'value' => $model->seller->displayname
                                ]
                            ],
                        ]);
                        ?>

                    </div>
                </div>
                <div class="row"> 
                    <div class="col-sm-5 col-sm-offset-1">
                        <?=
                        $form->field($model, 'financial_amount')->widget(MaskedInput::className(), [
                            'clientOptions' => [
                                'alias' => 'decimal',
                                'groupSeparator' => ',',
                                'autoGroup' => true
                            ],
                        ])
                        ?> 
                    </div>
                </div>

                <div class="row"> 
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('system', 'แก้ไข'), ['class' => 'btn btn-primary']) ?>
                            &nbsp;&nbsp;
                            <?= Html::a(Yii::t('system', 'กลับหน้าหลัก'), ['class' => 'btn btn-success btn_confirm', 'name' => 'btnConfirm',]) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>


    </div><!--box-body pad-->
</div><!--box box-info-->


