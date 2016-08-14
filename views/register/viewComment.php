<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ikhlas\customer\models\RegisterCustomer;
use ikhlas\customer\models\RegisterCustomerConsider;
use yii\widgets\MaskedInput;

//if (isset($model->staffMaterial_id) && $model->status > 1):



if ($model->registerCustomerConsiders):

    foreach ($model->registerCustomerConsiders as $considers):
        ?>
        <div class="box box-widget">
            <div class="box-header with-border">
                <?= $considers->createdBy->displaynameImg ?>
            </div>
            <div class="box-body">
                <?php
                //print_r($considers->data);
                if (isset($considers->data['doc_fully'])) {
                    echo Html::tag('label', $considers->getAttributeLabel('doc_fully'));
                    echo Html::beginTag('blockquote');
                    foreach (RegisterCustomerConsider::getItemDocFully() as $key => $val):
                        $check = $considers->data['doc_fully'] == $key;
                        echo Html::tag('p', '<i class="fa ' . ($check ? 'fa-check-circle' : 'fa-circle-o') . '"></i> ' . $val, ['class' => $check ? 'text-green' : '']);
                    endforeach;
                    if ($considers->data['doc_fully'] == '0'):
                        echo Html::tag('label', $considers->getAttributeLabel('doc_comment'));
                        echo $considers->data['doc_comment'];
                    endif;
                    echo Html::endTag('blockquote');
                    echo Html::tag('hr');
                }

                if (isset($considers->data['consider_basic'])) {
                    $consider_basic = $considers->data['consider_basic'];
                    echo Html::tag('label', $considers->getAttributeLabel('consider_basic'));
                    echo Html::beginTag('table', ['class' => 'table table-bordered table-striped']);
                    echo Html::beginTag('tr');
                    echo Html::tag('th', 'ตัวชี้วัด', ['rowspan' => 2, 'class' => 'text-center']);
                    echo Html::tag('th', 'การให้คะแนน', ['colspan' => 4, 'class' => 'text-center']);
                    echo Html::endTag('tr');

                    echo Html::beginTag('tr');
                    for ($i = 0; $i <= 3; $i++):
                        echo Html::tag('th', $i, ['class' => 'text-center']);
                    endfor;
                    echo Html::endTag('tr');

                    foreach (RegisterCustomerConsider::getItemConsiderBasic() as $index => $val):
                        echo Html::beginTag('tr');
                        echo Html::tag('td', $val['title']);
                        foreach ($val['choice'] as $key => $choice):
                            echo Html::beginTag('td');
                            echo Html::tag('span', $choice, ['class' => 'label' . ($consider_basic[$index][$key] ? ' label-success' : ' label-default')]);
                            echo Html::endTag('td');
                        endforeach;
                        echo Html::endTag('tr');

                    endforeach;
                    echo Html::endTag('table');
                }

                if (isset($considers->data['should_receive'])) {
                    echo Html::tag('hr');
                    echo Html::tag('label', $considers->getAttributeLabel('should_receive'));
                    echo Html::beginTag('blockquote');
                    foreach (RegisterCustomerConsider::getItemShouldReceive() as $key => $val):
                        $check = $considers->data['should_receive'] == $key;
                        echo Html::tag('p', '<i class="fa ' . ($check ? 'fa-check-circle' : 'fa-circle-o') . '"></i> ' . $val, ['class' => $check ? 'text-green' : '']);
                    endforeach;
                    echo Html::endTag('blockquote');
                }


                if ($considers->comment) {
                    echo Html::tag('label', '<i class="fa fa-comment"></i> ' . $considers->getAttributeLabel('comment') . ' ');
                    echo $considers->comment ? $considers->comment : '';
                }


                if (isset($considers->data['staff_receive'])) {
                    echo Html::tag('label', $considers->getAttributeLabel('should_receive'));
                    echo Html::beginTag('blockquote');
                    foreach (RegisterCustomer::getItemStaffReceive() as $key => $val):
                        $check = $considers->data['staff_receive'] == $key;
                        echo Html::tag('p', '<i class="fa ' . ($check ? 'fa-check-circle' : 'fa-circle-o') . '"></i> ' . $val, ['class' => $check ? 'text-green' : '']);
                    endforeach;

                    if ($considers->data['staff_receive_because']) {
                        echo Html::tag('label', '<i class="fa fa-comment"></i> ' . $considers->getAttributeLabel('comment') . ' &nbsp;');
                        echo $considers->data['staff_receive_because'];
                    }
                    if (isset($considers->data['financial_amount'])) {
                        echo Html::tag('label', '<i class="fa fa-money"></i> ' . $model->getAttributeLabel('financial_amount') . ' &nbsp;');
                        echo $considers->data['financial_amount'] . ' &nbsp;';
                        echo Yii::t('customer', 'บาท');
                    }

                    echo Html::endTag('blockquote');
                }
                ?>
            </div>


            <div class="box-footer box-comments">
                <div class="box-comment">
                    <div class="comment-text"> 
                        <span class="username">                            
                            <span class="text-muted pull-right"> 
                                <?= Html::tag('label', '<i class="fa fa-clock-o"></i> ' . $considers->getAttributeLabel('created_at')) ?>
                                <?= Yii::$app->formatter->asDatetime($considers->created_at) ?>
                            </span>
                        </span>
                    </div><!-- /.comment-text -->
                </div><!-- /.box-comment -->
            </div>

        </div>
        <?php
    endforeach;
endif;
?>


<?php
//if(!$ajax):

if (Yii::$app->user->can('seller') && in_array($model->status, [0, 4])):
    $form = ActiveForm::begin();
    ?>
    <div class="box box-widget">
        <div class="box-header with-border">
            <?= common\models\User::getThisUser()->displaynameImg ?>
        </div>
        <div class="box-body">      
            <?php
            // echo Html::tag('h4', $modelConsider->getAttributeLabel('doc_fully'));
            echo Html::beginTag('blockquote');
            echo $form->field($modelConsider, "doc_fully")->radioList(RegisterCustomerConsider::getItemDocFully())->label(false);
            echo $form->field($modelConsider, 'doc_comment')->textarea(['rows' => 2, 'placeholder' => $modelConsider->getAttributeLabel('doc_comment')])->label(false);
            echo Html::endTag('blockquote');
            ?>
            <hr/>
            <?= Html::tag('h4', $modelConsider->getAttributeLabel('consider_basic')) ?>
            <?= Html::tag('label', '(ให้เลือกประเมินในแต่ละตัวชี้วัด)') ?>
            <?php
            echo Html::beginTag('table', ['class' => 'table table-bordered table-striped']);
            echo Html::beginTag('tr');
            echo Html::tag('th', 'ตัวชี้วัด', ['rowspan' => 2, 'class' => 'text-center']);
            echo Html::tag('th', 'การให้คะแนน', ['colspan' => 4, 'class' => 'text-center']);
            echo Html::endTag('tr');

            echo Html::beginTag('tr');
            for ($i = 0; $i <= 3; $i++):
                echo Html::tag('th', $i, ['class' => 'text-center']);
            endfor;
            echo Html::endTag('tr');

            foreach (RegisterCustomerConsider::getItemConsiderBasic() as $index => $val):

                echo Html::beginTag('tr');
                echo Html::tag('td', $val['title']);
                foreach ($val['choice'] as $key => $choice):
                    echo Html::beginTag('td');
                    echo $form->field($modelConsider, "consider_basic[{$index}][]")->radio(['label' => $choice])->label(false);
                    echo Html::endTag('td');
                endforeach;
                echo Html::endTag('tr');

            endforeach;

            echo Html::endTag('table');
            ?>

        </div>
        <div class="box-footer box-comments">
            <div class="box-comment">
                <div class="comment-text"> 
                    <div class="row"> 
                        <div class="col-sm-12">
                            <?= $form->field($modelConsider, 'should_receive')->radioList(RegisterCustomerConsider::getItemShouldReceive()) ?>
                            <?= $form->field($modelConsider, 'comment')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>           

                    <div class="form-group">               
                        <?= Html::submitButton(Yii::t('system', 'ยืนยันการสมัคร'), ['class' => 'btn btn-success btn_confirm', 'name' => 'btnConfirm']) ?>

                        <?= Html::a(Yii::t('system', 'ยกเลิก'), ['create', 'id' => $model->id], ['class' => 'btn btn-link']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
    ActiveForm::end();
elseif (Yii::$app->user->can('staff') && in_array($model->status, [1, 2])):
    $form = ActiveForm::begin();
    ?>
    <div class="box box-widget">
        <div class="box-header with-border">
            <?= common\models\User::getThisUser()->displaynameImg ?>
        </div>
        <div class="box-body">
            <?= Html::tag('b', 'ส่วนของเจ้าที่หน้าที่ผู้อนุมัติ'); ?>
            <?= Html::beginTag('blockquote'); ?>
            <?= $form->field($model, 'staff_receive')->radioList(RegisterCustomer::getItemStaffReceive(), ['prompt' => '']) ?>                           

            <div class="staff_receive receive1">
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
            <div class="staff_receive receive0">
                <?= $form->field($model, 'staff_receive_because')->textarea(['rows' => 6]) ?>
            </div>
            <div class="staff_receive receive2">
                <?= $form->field($model, 'staff_receive_because')->textarea(['rows' => 6]) ?>
            </div>
            <?= Html::endTag('blockquote'); ?>
        </div>



        <div class="box-footer box-comments">
            <div class="box-comment">
                <div class="comment-text"> 
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

    $this->registerCss(" 
        .staff_receive{
            display:none;
        }            
    ");

    $this->registerJs(" 
        $('input[name=\"RegisterCustomer[staff_receive]\"]').change(function(){
            var receive =$(this).val();
            $('.staff_receive').hide();
            $('.receive'+receive).show();
        });

    ");

endif;

//endif; //ajax
?>
