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
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Já existe um utilizador com este nome'],
			['username', 'string', 'min' => 2, 'tooShort' => 'O nome de utilizador deve conter pelo menos 2 caracteres'],
			['username', 'string', 'max' => 255],

			['email', 'trim'],
			['email', 'required', 'message' => 'Necessário introduzir um email'],
			['email', 'email', 'message' => 'Email inválido'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Já existe um utlizador com este email'],

			['password', 'required', 'message' => 'Necessário introduzir uma password'],
			['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'A Palavra-passe deve conter pelo menos 8 caracteres'],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return bool whether the creating new account was successful and email was sent
	 */
	public function signup($role) {
		if (!$this->validate()) return null;

		$model_user = new User();
		$model_user->username = $this->username;
		$model_user->email = $this->email;
		$model_user->setPassword($this->password);
		$model_user->save();

		//* rbac
		$auth = Yii::$app->authManager;
		$auth->assign($auth->getRole($role), $model_user->getId());

		return true;
	}
}
