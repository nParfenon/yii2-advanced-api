<?php

namespace frontend\modules\user;


use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([

            // правила URL описываются здесь
        ], false);
    }

}