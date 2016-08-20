<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\FileInput;
use ikhlas\persons\models\Person;
use backend\modules\seller\models\RegisterSeller;
use yii\bootstrap\Modal;
?>

<hr />

<?= Html::tag('h4', '5. ' . Yii::t('person', 'สถานที่ที่สะดวกให้จัดส่งเอกสาร')); ?>


<?= $form->field($modelPerson, 'doc_delivery')->inline()->radioList(Person::getItemDocDelivery()) ?>


<hr />
<?= Html::tag('h4', '6. ' . Yii::t('person', 'เอกสารประกอบการสมัคร')); ?>

<?= Html::tag('span', 'เพื่อให้ใบสมัครของท่านได้รับการพิจารณาอย่างรวดเร็ว กรุณากรอกใบสมัครให้ครบถ้วน และเตรียมเอกสารตามรายการต่อไปนี้ พร้อมร้บรองสำเนาถูกต้องทุกฉบับ') ?>

<?=
$form->field($model, 'doc_list')->checkboxlist(\ikhlas\customer\models\RegisterCustomer::getItemDocList());
    ?>
<?=
$form->field($model, 'doc[]')->widget(FileInput::classname(), [
    'options' => [
        // 'accept' => 'image/*',
        'multiple' => true
    ],
    'pluginOptions' => [
        'initialPreview' => $model->initialPreview($model->doc, 'docs', 'file'),
        'initialPreviewConfig' => $model->initialPreview($model->doc, 'docs', 'config'),
        'uploadUrl' => Url::to(['uploadajax']),
        'overwriteInitial' => false,
        'initialPreviewShowDelete' => true,
        'showPreview' => true,
        'showRemove' => true,
        'showUpload' => true,
        'allowedFileExtensions' => ['pdf', 'png', 'jpg'],
        //'initialPreview'=> $initialPreview,
        //'initialPreviewConfig'=> $initialPreviewConfig,        
        'uploadExtraData' => [
            //'slide_id' => $model->id,
            'id' => $model->id,
            'upload_folder' => \ikhlas\customer\models\RegisterCustomer::UPLOAD_FOLDER . "/" . $model->id,
        //'width' => ArtJob::width,
        ],
    //'maxFileSize' => 2000000,
    //'maxFileCount' => 1,
    ],
]);
?>






<?php
if (!$model->isNewRecord):
    /*
      Modal::begin(['id' => 'modal-img']);
      $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
      ?>
      <?=
      $form->field(new \backend\modules\image\models\Image, 'name_file')->widget(FileInput::classname(), [
      'options' => ['accept' => 'image/*'],
      'pluginOptions' => [
      'uploadUrl' => Url::to(['/file/default/uploadajax']),
      //'overwriteInitial'=>false,
      'initialPreviewShowDelete' => true,
      //'initialPreview'=> $initialPreview,
      //'initialPreviewConfig'=> $initialPreviewConfig,
      'uploadExtraData' => [
      //'slide_id' => $model->id,
      'upload_folder' => Slide::UPLOAD_FOLDER,
      'width' => $model->slide_cate_id ? $model->slideCate->width : 1140,
      'hieth' => $model->slide_cate_id ? $model->slideCate->height : 346,
      ],
      'maxFileCount' => 1,
      ],
      'options' => ['accept' => 'image/*', 'id' => 'name_file']
      ]);

      ActiveForm::end();
      Modal::end();
     */
    $this->registerJs(' 
    $(".photo").click(function(e) {            
        $("#modal-img").modal("show");        
    });   
    
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