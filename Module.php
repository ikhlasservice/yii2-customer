<?php

namespace backend\modules\customer;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\customer\controllers';

    public function init()
    {
        $this->layout = 'left-menu.php';
        parent::init();

        // custom initialization code goes here
    }
}
