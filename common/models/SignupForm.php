<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Necessário introduzir um nome de utilizador'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este nome de utlizador já está registado'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Necessário introduzir um email'],
            ['email', 'email', 'message' => 'Email incorreto'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já está registado'],

            ['password', 'required', 'message' => 'Necessário introduzir uma password'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($role) {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->save();

        //rbac
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole($role), $user->getId());

        return true;
    }
}
