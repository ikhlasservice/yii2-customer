<?php 

use yii\helpers\Html;

$asset = backend\assets\AppAsset::register($this);

?>

<div class="row"> 
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="row"> 
                    <div class="col-sm-5"> 
                        <?= Html::img($asset->baseUrl . "/images/banner.png", ['width' => '100%']) ?>
                    </div>
                    <div class="col-sm-3 col-sm-offset-4"> 
                        <?= Html::tag('label', $model->getAttributeLabel('id')) ?>
                        <?= $model->id ?>
                    </div>
                </div>
                <hr />
                <?= Html::tag('h2', 'ใบสมัครสมาชิก(IKHLAS Member)', ['class' => 'text-center']) ?>

                <div class="row">     
                    <div class="col-sm-2 col-sm-offset-9 text-right"> 
                        <?= Yii::$app->formatter->asDate($model->created_at) ?>
                    </div>
                </div>
                <p>&nbsp;</p>

                <div class="row"> 
                    <div class="col-sm-12"> 
                        <?php
                        echo $this->render('/default/detail/person', [
                            'form' => $form,
                            //'model' => $model,
                            'modelPerson' => $modelPerson,
                            'modelPersonDetail' => $modelPersonDetail,
                            'modelAddress' => $modelAddress,
                        ]);

                        echo $this->render('/default/detail/contact', [
                            'form' => $form,
                            //'model' => $model,
                            'modelPerson' => $modelPerson,
                            'modelPersonContact' => $modelPersonContact,
                            'modelContactAddress' => $modelContactAddress,
                        ]);

                        echo $this->render('/default/detail/career', [
                            'form' => $form,
                            //'model' => $model,
                            'modelPerson' => $modelPerson,
                            'modelPersonCareer' => $modelPersonCareer,
                        ]);

                        echo $this->render('/default/detail/document', [
                            'form' => $form,
                            'model' => $model,
                            'modelPerson' => $modelPerson,
                        ]);
                        ?>


                    </div>
                </div>
            </div>
        </div>

