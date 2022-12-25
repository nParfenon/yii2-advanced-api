<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\LoginForm;

class DefaultController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['get'],
                    'verify-login' => ['post']
                ],
            ],
        ];
    }

    public function actionLogin(): string
    {
        var_dump(Yii::$app->urlManager->ru);die();
        return $this->render('login', [
            'model' => new LoginForm(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionVerifyLogin(): \yii\web\Response
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($login = $model->login()) return $this->goHome();

            $message = implode($model->firstErrors);

        }

        Yii::$app->session->setFlash('login_message', $message ?? 'Ошибка входа. Попробуйте позже');

        return $this->redirect(['/login']);
    }

}
