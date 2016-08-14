<?php

use yii\helpers\Html;

//if (isset($model->staffMaterial_id) && $model->status > 1):
?>

<div class="box box-widget">
    <div class="box-header with-border">
        <?= $model->seller->displaynameImg ?>
    </div>
    <div class="box-footer box-comments">
        <div class="box-comment">
            <div class="comment-text"> 
                <span class="username">
                    <?= Html::tag('label', $model->getAttributeLabel('seller_receive')) ?>
                    <?= $model->seller_receive; ?>
                    <span class="text-muted pull-right"> 
                        <?= Html::tag('label', $model->getAttributeLabel('seller_date')) ?>
                        <?= Yii::$app->formatter->asDatetime($model->staff_date) ?>
                    </span>
                </span>

                <?= Html::tag('label', $model->getAttributeLabel('seller_receive_because')) ?>
                <?= $model->seller_receive_because ?>

            </div><!-- /.comment-text -->
        </div><!-- /.box-comment -->
    </div>

</div>
<?php
//endif;
?>


<?php
if (Yii::$app->user->can('staff')&& $model->staff_receive ===null):
    $form = ActiveForm::begin();
    ?>
    <div class="box box-widget">
        <div class="box-header with-border">
    <?= common\models\User::getThisUser()->displaynameImg ?>
        </div>
        <div class="box-footer box-comments">
            <div class="box-comment">
                <div class="comment-text"> 
                    <div class="row"> 
                        <div class="col-sm-12"> ส่วนของเจ้าที่หน้าที่ผู้อนุมัติ
    <?= $form->field($model, 'staff_receive')->radioList(RegisterCustomer::getItemStaffReceive(), ['prompt' => '']) ?>                           

    <?= $form->field($model, 'financial_amount')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'staff_receive_because')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>           

                    <div class="form-group">               
    <?= Html::submitButton(Yii::t('system', 'บันทึก'), ['class' => 'btn btn-success btn_confirm', 'name' => 'btnConfirm']) ?> 

    <?= Html::a(Yii::t('system', 'ยกเลิก'), ['create', 'id' => $model->id], ['class' => 'btn btn-link']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
    ActiveForm::end();

    elseif($model->staff_receive !==null):?>
        <div class="box box-widget">
    <div class="box-header with-border">
        <?= $model->staff->displaynameImg ?>
    </div>
    <div class="box-footer box-comments">
        <div class="box-comment">
            <div class="comment-text"> 
                <span class="username">
                    <?= Html::tag('label', $model->getAttributeLabel('staff_receive')) ?>
                    <?= $model->staff_receive; ?>
                    <span class="text-muted pull-right"> 
                        <?= Html::tag('label', $model->getAttributeLabel('staff_date')) ?>
                        <?= Yii::$app->formatter->asDatetime($model->staff_date) ?>
                    </span>
                </span>

                <?= Html::tag('label', $model->getAttributeLabel('staff_receive_because')) ?>
                <?= $model->staff_receive_because ?>

            </div><!-- /.comment-text -->
        </div><!-- /.box-comment -->
    </div>

</div>
    
    <?php
endif;
?>
