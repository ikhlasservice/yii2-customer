<?php
use yii\bootstrap\Html;
use yii\widgets\DetailView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class='row'>
            <div class='col-sm-12'>
                <?php
                echo DetailView::widget([
                    'model' => $model,                    
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'fullname',
                            'value' => $model->fullname,
                        ],                       
                        
                        [
                            'attribute' => 'email',
                            'format' => 'email',
                            'value' => $model->email
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        
