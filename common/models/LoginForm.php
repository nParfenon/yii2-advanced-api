<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username','password'], 'required', 'message' => 'Заполните поле {attribute}'],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => 'Логин должен содержать только латиские буквы и цифры'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'password'=>'Пароль',
            'rememberMe' => 'Запомнить',
            'message'=>'Сообщение',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array|null $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, array|null $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) $this->addError($attribute, 'Incorrect username or password.');

        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     * @throws Exception
     */
    public function login(): bool
    {
        if (!$this->validate()) return false;

        if ($this->rememberMe) {

            $authKey = $this->getUser();
            $authKey->generateAuthKey();
            $authKey->save();

        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) $this->_user = User::findByUsername($this->username);

        return $this->_user;
    }

}
