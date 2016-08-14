<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>
<?= Html::tag('h4', '2. ' . Yii::t('person', 'ข้อมูลการติดต่อ'), ['class' => 'col-sm-offset-1']); ?>

<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table '],
            'template' => $template,
            'attributes' => [
                [
                    'attribute' => 'person.contactAddress.contactBy',
                    'value' => $model->person->contactAddress->contactByLabel
                ],
                [
                    'attribute' => 'person.address_contact',
                    'value' => $model->person->addressContact
                ],
                [
                    'attribute' => 'person.telephone',
                    'value' => $model->person->telephone
                ],
                [
                    'attribute' => 'person.home_phone',
                    'value' => $model->person->home_phone
                ],
                [
                    'attribute' => 'person.email',
                    'value' => $model->person->email
                ],
                [
                    'attribute' => 'person.facebook',
                    'value' => $model->person->facebook
                ],
            ]
        ]);
        ?>
    </div>
</div>


<?= Html::tag('h4', '3. ' . Yii::t('person', 'บุคคลที่สามารถติดต่อแทนท่านได้'), ['class' => 'col-sm-offset-1']); ?>

<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table '],
            'template' => $template,
            'attributes' => [
                [
                    'attribute' => 'person.personContact.fullname',
                    'value' => $model->person->personContact->fullname
                ],
                [
                    'attribute' => 'person.personContact.relationship',
                    'value' => $model->person->personContact->relationship
                ],
                [
                    'attribute' => 'person.personContact.address',
                    'value' => $model->person->personContact->address
                ],
                [
                    'attribute' => 'person.personContact.tel_number',
                    'value' => $model->person->personContact->tel_number
                ],
                [
                    'attribute' => 'person.personContact.home_phone',
                    'value' => $model->person->personContact->home_phone
                ],
                [
                    'attribute' => 'person.personContact.email',
                    'value' => $model->person->personContact->email
                ],
            ]
        ]);
        ?>
    </div>
</div>