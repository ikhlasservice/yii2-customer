<?php

use yii\helpers\Html;
use yii\grid\GridView;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//print_r($model);

if ($listDataProvider) {
    ?>

    <div class="row">
        <div class="col-sm-12">
            <?=
            GridView::widget([
                'dataProvider' => $listDataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => '',
                        'format' => 'html',
                        'headerOptions' => ['width' => '100'],
                        'content' => function($model) {
                    //return Html::button('เลือก', ['class' => 'btn btn-primary select-data', 'value' => $model->id]);
                    return Html::a('เลือก', ['/contract/credit/create','customer_id' => $model->id], [
                                'class' => 'btn btn-primary',
                                'data' => [
                                    
                                    'method' => 'post',
                                ]
                    ]);
                },
                    ],
                    'id',
                    'person.fullname',
                    'created_at:datetime',
                //'problem:text',                   
                ]
            ]);
        }
        ?>
    </div>
</div>

<?php
if (isset($ajax)) {
    $this->registerJs(' 
        
$(".select-data").each(function(){
    var id = $(this).val();    
    $(this).click(function(){     
        //alert(id);
        $.getJSON( "' . Yii::$app->urlManager->createUrl('/customer/default/find') . '",
            {
               "id":id,                    
           },
           function(data){   
                console.log(data); 
                console.log(data.id); 
                $(".fullname").text(data.fullname);               
                $(".customer_id").text(data.id);
                $(".profit").text(data.profit);
                
                $("input[name=\"Credit[customer_id]\"]").val(data.id);
                $("#modalHistory").modal("hide");
           }          
        );  


    });
});
');
}

