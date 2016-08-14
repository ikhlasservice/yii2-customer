<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<hr />
    <?php
//    echo "<pre>";
//    print_r($event->sender);
//    echo "</pre>";
    $index = array_search($event->step, $event->sender->steps);
    echo Html::beginTag('div', ['class' => 'text-center','style'=>'']);
    echo Html::beginTag('div', ['class' => 'btn-group','style'=>'display:inline-block;margin:0 auto;']);
     
    if($index>0){
    echo Html::submitButton('<i class="fa fa-angle-double-left"></i> '.Yii::t('app','ก่อนหน้า'), ['class' => 'btn btn-primary btn-lg', 'name' => 'prev', 'value' => 'prev']);
    }
    
    
    
    
    
    //echo Html::submitButton('Pause', ['class' => 'btn', 'name' => 'pause', 'value' => 'pause']);
    //echo Html::submitButton('Cancel', ['class' => 'btn', 'name' => 'cancel', 'value' => 'pause']);
    if($event->step!='confirm'){
        echo Html::submitButton(Yii::t('app','ถัดไป').' <i class="fa fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-lg', 'name' => 'next', 'value' => 'next']);
    }else{
    echo Html::submitButton('<i class="fa fa-send"></i> '.Yii::t('app','ยืนยัน'), ['class' => 'btn btn-success btn-lg', 'name' => 'next', 'value' => 'next']);
    }
    echo Html::endTag('div');
    echo Html::endTag('div');
    ?>