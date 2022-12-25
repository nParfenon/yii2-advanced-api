<?php

namespace api\modules\v1;

use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function (){
                            return true; // TODO Проверка токена
                        }
                    ],
                ],
            ],
        ];
    }

}