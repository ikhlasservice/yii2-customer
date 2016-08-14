<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$asset = backend\assets\AppAsset::register($this);

$this->title = $modelPerson->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'ลูกค้าทั้งหมด'), 'url' => ['/customer/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('customer', 'ใบสมัครทั้งหมด'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-body pad'>




        <div class="row"> 
            <div class="col-xs-6 col-sm-5"> 
                <?= Html::img($asset->baseUrl . "/images/banner.png", ['width' => '100%']) ?>
            </div>
            <div class="col-xs-6 col-sm-5 col-sm-offset-2"> 

                <div class="row">
                    <div class="hidden-xs hidden-sm col-md-12">&nbsp;</div>

                    <div class="col-xs-9 col-sm-8 text-right">
                        <?= Html::tag('label', $model->getAttributeLabel('id')) ?>                 
                    </div>
                    <div class="col-xs-3 col-sm-4" style="padding-left: 0px;">    
                        <?= Html::tag('span', '&nbsp;' . $model->id . '&nbsp;', ['class' => 'border-bottom-dotted']) ?>
                    </div>
                    <div class="col-xs-9 col-sm-8 text-right">
                        <?= Html::tag('label', $model->getAttributeLabel('status')) ?>                    
                    </div>
                    <div class="col-xs-3 col-sm-4" style="padding-left: 0px;">
                        <?= $model->statusLabel ?>
                    </div>
                </div>

            </div>
        </div>
        <hr />
        <?= Html::tag('h2', 'ใบสมัครสมาชิก(IKHLAS Member)', ['class' => 'text-center']) ?>


        <div class="row"> 
            <div class="col-xs-4 col-xs-offset-8 col-sm-3 col-sm-offset-9">
                <label><?= Yii::t('credit', 'วันที่') ?></label>
                <?= Yii::$app->formatter->asDate($model->created_at, 'php:d M Y') ?>
            </div>
        </div><!-- /.row -->

        <p>&nbsp;</p>

        <div class="row"> 
            <div class="col-sm-12"> 
                <?php
                $template = '<tr><th width="30%" class="text-right">{label}</th><td width="65%" class="">{value}</td></tr>';
                
                echo $this->render('view/person', [
                    'template'=>$template,
                    'model' => $model,
                    'modelPerson' => $modelPerson,
                    'modelPersonDetail' => $modelPersonDetail,
                    'modelAddress' => $modelAddress,
                ]);

                echo $this->render('view/contact', [
                    'template'=>$template,
                    'model' => $model,
                    'modelPerson' => $modelPerson,
                    'modelPersonContact' => $modelPersonContact,
                    'modelContactAddress' => $modelContactAddress,
                ]);

                echo $this->render('view/career', [
                    'template'=>$template,
                     'model' => $model,
                    'modelPerson' => $modelPerson,
                    'modelPersonCareer' => $modelPersonCareer,
                ]);

                echo $this->render('view/document', [
                    'template'=>$template,
                    'form' => $form,
                    'model' => $model,
                    'modelPerson' => $modelPerson,
                ]);

//                echo $this->render('view/confirm', [
//                    'template'=>$template,
//                    'form' => $form,
//                    'model' => $model,
//                ]);
                ?>







            </div>
        </div>


    </div><!--box-body pad-->
</div><!--box box-info-->

<?=
$this->render('viewComment', [
    'model' => $model,
    'modelConsider' => $modelConsider,
    'ajax' => $ajax
]);
