<?php

use yii\helpers\Html;
?>



<?= Html::tag('h4', '5. ' . Yii::t('person', 'สถานที่ที่สะดวกให้จัดส่งเอกสาร'), ['class' => 'col-sm-offset-1']); ?>


<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?= Html::tag('label', $modelPerson->getAttributeLabel('doc_delivery')) ?>
        <?= $modelPerson->docDeliveryLabel ?>
    </div>  
</div>

<?= Html::tag('h4', '6. ' . Yii::t('person', 'เอกสารประกอบการสมัคร'), ['class' => 'col-sm-offset-1']); ?>

<div class="row">
    <div class="col-sm-8 col-sm-offset-2">

        <?= Html::tag('span', 'เพื่อให้ใบสมัครของท่านได้รับการพิจารณาอย่างรวดเร็ว กรุณากรอกใบสมัครให้ครบถ้วน และเตรียมเอกสารตามรายการต่อไปนี้ พร้อมร้บรองสำเนาถูกต้องทุกฉบับ') ?>
        &nbsp;
        <?php
        $label = \backend\modules\customer\models\RegisterCustomer::getItemDocList();
        $list = $model->doc_list;
        echo Html::beginTag('ul', ['style' => 'list-style:none;']);

        foreach ($label as $key => $val) {
            $chk = ($list && @in_array($key, $list)) ? '&nbsp;<i class="fa fa-check"></i>' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo Html::tag('li', $chk . $key . Html::tag('label', '&nbsp;' . $val));
        }
        echo Html::beginTag('ul');
        ?>


    </div>  
</div>

<div class="row">
    <div class="col-sm-11 col-sm-offset-1">
        <?= Html::tag('label', $model->getAttributeLabel('doc')) ?>
        <?php /* dosamigos\gallery\Gallery::widget(['items' => $model->viewPreview($model->doc)]); */ ?>
        <?= $model->viewPreview($model->doc); ?>

    </div>  
</div>


<?php
if (!$model->isNewRecord):

    $this->registerJs(' 
    
    
    $("input[name=\'Image[name_file]\']").on("fileuploaded", function(event, data, previewId, index) {
    //alert(55);
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response.files, reader = data.reader;
    
        response = data.response.files
        console.log("1"+form+"2"+files+"3"+extra+"4"+response+"5"+reader);
        console.log("File batch upload complete"+files);
        loadImg(data.response.path,data.response.files);
        $("#modal-img").modal("hide");
    });

var loadImg = function(path,id){
    $("#slide-img_id").val(id);
    $(".img_id").css("background","url("+path+id+")");
}


');

endif;
?>