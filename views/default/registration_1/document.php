<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

use kartik\widgets\FileInput;
use ikhlas\persons\models\Person;
use backend\modules\seller\models\RegisterSeller;

/* @var $this yii\web\View */
/* @var $model ikhlas\persons\models\Person */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('person', 'ข้อมูลเอกสาร-ตัวแทนจำหน่าย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'Sellers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?= $this->render('navbar', ['event' => $event]); ?>


        <?= Html::tag('h4', '5. ' . Yii::t('person', 'สถานที่ที่สะดวกให้จัดส่งเอกสาร')); ?>


        <?php
        $form = ActiveForm::begin();
        ?>

        <div class="row">
            <div class="col-sm-11 col-sm-offset-1">
                <?= $form->field($model, 'doc_delivery')->inline()->radioList(Person::getItemDocDelivery()) ?>
            </div>
        </div>
        
        

        <?= Html::tag('h4', '6. ' . Yii::t('person', 'เอกสารประกอบการสมัคร')); ?>
<div class="row">
            <div class="col-sm-11 col-sm-offset-1">
                <?= $form->field($modelRegisterCustomer, 'doc')->textInput()?>
                
            <?php /* = $form->field(new \backend\modules\image\models\Image, 'name_file')->widget(FileInput::classname(), [
                //'options' => ['accept' => 'image/*'],               
                'pluginOptions' => [
                     'uploadUrl' => Url::to(['/file/default/uploadajax']),
                    'initialPreview'=>[],
                    'allowedFileExtensions'=>['pdf','doc','docx'],
                    'showPreview' => true,
                    'showRemove' => true,
                    'showUpload' => true,
                    'uploadExtraData' => [
                        'upload_folder' => RegisterSeller::UPLOAD_FOLDER,
                    ],
                ]
            ]); */?>
                
                
            </div>
        </div>

        <?= $this->render('buttonNav', ['event' => $event]); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>


<?php
if (!$model->isNewRecord):
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
    ?>


    <?php
    ActiveForm::end();
    Modal::end();

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