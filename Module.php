<?php

namespace ikhlas\customer;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'ikhlas\customer\controllers';

    public function init()
    {
        $this->layout = 'left-menu.php';
        parent::init();

        // custom initialization code goes here
    }
}
