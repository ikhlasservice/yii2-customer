<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\seller\models\RegisterSeller;


?>


               
                <?=Html::tag('h4',Yii::t('person', 'ข้อกำหนดแลเงื่อนไงการเป็นตัวแทนของบริษัท อิคลาส เซอร์วิสจำกัด'),['class'=>'text-center'])?>
                <div class="row">
                    <div class="col-sm-12">
                        <div style="padding: 10px 10px">
                    <?php
                    foreach ($model->getItemCondition() as $key => $val) {
                        echo $key . ". " . $val . '<br/>';
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



                
                