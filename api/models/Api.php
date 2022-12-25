<?php

namespace api\modules\api\models;

use Yii;
use yii\db\ActiveRecord;

class Api extends ActiveRecord
{

    const _TOKEN_LENGTH = 64;

    public function rules(): array
    {
        return [
            [['name','token'],'required'],
            ['name', 'string', 'max' => 50],
            ['token', 'string', 'length' => [self::_TOKEN_LENGTH, self::_TOKEN_LENGTH]],
            ['expired', 'date'],
            [['created_at','updated_at'], 'safe']
        ];
    }

    public function checkToken(string $token)
    {
        return self::find()->andWhere(['= BINARY', 'token', $token])->one();
    }

    public function generateToken(): string
    {
        return Yii::$app->security->generateRandomString(self::_TOKEN_LENGTH);
    }

}