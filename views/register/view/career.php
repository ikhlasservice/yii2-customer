<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


?>
<?= Html::tag('h4', '4. ' . Yii::t('person', 'ข้อมูลการทำงาน/อาชีพ'), ['class' => 'col-sm-offset-1']); ?>


<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table '],
            'template' => $template,
            'attributes' => [
                [
                    'attribute' => 'person.personCareer.career_id',
                    'value' => $model->person->personCareer->career->title
                ],
                [
                    'attribute' => 'person.personCareer.position_title',
                    'value' => $model->person->personCareer->position_title
                ],
                [
                    'attribute' => 'person.personCareer.working_age',
                    'value' => $model->person->personCareer->working_age
                ],
                [
                    'attribute' => 'person.personCareer.workplace_title',
                    'value' => $model->person->personCareer->workplace_title
                ],
                [
                    'attribute' => 'person.personCareer.address',
                    'value' => $model->person->personCareer->address
                ],
                [
                    'attribute' => 'person.personCareer.workplace_phone',
                    'value' => $model->person->personCareer->workplace_phone
                ],
                [
                    'attribute' => 'person.personCareer.workplace_fax',
                    'value' => $model->person->personCareer->workplace_fax
                ],
                [
                    'attribute' => 'person.personCareer.salary',
                    'value' => $model->person->personCareer->salary
                ],
            ]
        ]);
        ?>
    </div>
</div>



<?php /* = $form->field($modelPersonCareer, 'income_other')->textarea(['rows' => 6]) */ ?>

<?php /* = $form->field($modelPersonCareer, 'expenses')->textarea(['rows' => 6]) */ ?>    










<?php
$this->registerJs("
 $('input[name=\"PersonCareer[career_id]\"').click(function(){
 //console.log($(this).select());
    if($(this).val()==0){
       $('input[name=\"Career[title]\"').attr('disabled',false);
       $('input[name=\"Career[title]\"').focus();
    }else{
       $('input[name=\"Career[title]\"').attr('disabled',true);
    }
 });

       $('input[name=\"Career[title]\"').attr('disabled',true);

    
        
        
        
         ");

