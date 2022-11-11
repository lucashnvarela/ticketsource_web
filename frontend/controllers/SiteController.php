<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['logout', 'signup'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['cliente'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions() {
		return [
			'error' => [
				'class' => \yii\web\ErrorAction::class,
			],
			'captcha' => [
				'class' => \yii\captcha\CaptchaAction::class,
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		return $this->render('index');
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin() {
		if (!Yii::$app->user->isGuest) return $this->goHome();

		$model_login = new LoginForm();
		if ($model_login->load(Yii::$app->request->post())) {

			$user_login = User::findByUsername($model_login->username);

			if (is_null($user_login))
				Yii::$app->session->setFlash('error', 'Username ou password incorretos');

			elseif ($user_login->isCliente()) {
				if ($user_login->isActive()) {
					if ($user_login->validatePassword($model_login->password)) {
						$model_login->login();

						return $this->goHome();
					} else Yii::$app->session->setFlash('error', 'Username ou password incorretos');
				} else Yii::$app->session->setFlash('error', 'Login indisponível');
			} else Yii::$app->session->setFlash('error', 'Sem permissão de acesso');
		}

		$model_login->password = '';

		return $this->render('login', [
			'model_login' => $model_login,
		]);
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup() {
		$model_signup = new SignupForm();
		if ($model_signup->load(Yii::$app->request->post()) && $model_signup->signup(User::ROLE_CLIENTE)) {
			//Yii::$app->session->setFlash('success', 'Registo efetuado com sucesso');
			return $this->goHome();
		}

		return $this->render('signup', [
			'model_signup' => $model_signup,
		]);
	}
}
