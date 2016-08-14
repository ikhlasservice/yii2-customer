<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\seller\models\RegisterSeller;
$model->confirm=1;
?>

<hr />

<div class="row">
    <div class="col-sm-12">
        <div style="padding: 10px 10px;">
            <?php
            foreach ($model->getItemCondition() as $key => $val) {
                echo Html::tag('p', $val,['style'=>'text-indent:20px;']);
            }
            ?>
        </div>
        <?= $form->field($model, 'confirm')->checkbox() ?>
    </div>
</div>
<?php
$this->registerJs("
        $('input[name=\"RegisterCustomer[confirm]\"]').click(function(){
            if($(this).is(':checked')){
            $('.btn_confirm').attr('disabled',false);
            }else{
            $('.btn_confirm').attr('disabled',true);
            }

        });
        
        
        ")
?>




