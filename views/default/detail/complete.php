<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Registration Wizard Complete';

//echo $event->sender->menu->run();

echo Html::beginTag('div', ['class' => 'section']);
echo Html::tag('h2', 'Person');
echo DetailView::widget([
    'model' => $data['person'][0],
    'attributes' => [
        'name',
        'fullname',
    ]
]);
echo Html::endTag('div');


echo Html::a('Choose Another Demo', '/wizard');
