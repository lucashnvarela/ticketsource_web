<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\LoginForm;
use yii\rest\ActiveController;
use common\models\User;


class UserController extends ActiveController {
	public $modelClass = 'common\models\User';

	public function actionRegisto() {

		$model_signup = new User();
		$model_signup->username = Yii::$app->request->post('username');
		$model_signup->email = Yii::$app->request->post('email');
		$model_signup->setPassword(Yii::$app->request->post('password'));
		$model_signup->generateEmailVerificationToken();
		$model_signup->save();

		//* rbac
		$auth = Yii::$app->authManager;
		$auth->assign($auth->getRole(User::ROLE_CLIENTE), $model_signup->id);

		return true;
	}

	public function actionLogin() {

		$model_login = new LoginForm();
		$model_login->username = Yii::$app->request->post('username');
		$model_login->password = Yii::$app->request->post('password');

		$user_login = User::findByUsername($model_login->username);

		if (!is_null($user_login)) {
			if ($user_login->isActive()) {
				$model_login->login();

				return $user_login;
			} else
				throw new \yii\web\NotFoundHttpException("Login indisponível");
		} else
			throw new \yii\web\NotFoundHttpException("Login indisponível");
	}

	public function actionCheck($token) {
		$user = User::findOne(['verification_token' => $token]);
		return Yii::$app->authManager->getAssignment(User::ROLE_CLIENTE, $user->id) ? true : false;
	}
}
