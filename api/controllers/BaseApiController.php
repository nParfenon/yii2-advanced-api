<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class BaseApiController extends Controller
{

    public $modelClass;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            'text/html' => Response::FORMAT_JSON,
        ];

        return $behaviors;
    }

    public function actionIndex(): array
    {
        return $this->modelClass::find()->asArray()->all();
    }

    public function actionView(int $id): object
    {
        return $this->findModel($id);
    }

    public function actionCreate()
    {
    }

    /**
     * @throws yii\base\InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(int $id): object
    {
        $model = $this->findModel($id);

        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($model->save() === false && !$model->hasErrors()) throw new ServerErrorHttpException('Failed to update the object for unknown reason');

        return $model;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionDelete(int $id): bool
    {
        $model = $this->findModel($id);

        if (!$model->delete())  throw new ServerErrorHttpException('Failed to delete the object for unknown reason');

        return true;
    }

    protected function verbs(): array
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    protected function findModel(int $id): object
    {
        return $this->modelClass::findOne(['id' => $id]);
    }

}