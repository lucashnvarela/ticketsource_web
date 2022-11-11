<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;
use common\models\Evento;
use common\models\Sessao;
use common\models\Bilhete;
use frontend\models\FaturaBilhete;

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
				'only' => ['logout', 'signup', 'index'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['admin'],
					],
					[
						'actions' => ['logout', 'index'],
						'allow' => true,
						'roles' => ['admin', 'gestorBilheteira'],
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
		];
	}

	/**
	 * Displays dashboard.
	 *
	 * @return string
	 */
	public function actionIndex() {
		//* Numero de Eventos
		$db_evento = Evento::find()->all();

		//* Numero de Sessoes
		$db_sessao = Sessao::find()->all();

		//* Numero de Bilhetes
		$db_bilhete = Bilhete::find()->all();

		//* Total de Rendimentos
		$db_faturabilhete = FaturaBilhete::find()->all();
		$tRendimentos = 0;
		foreach ($db_faturabilhete as $faturabilhete) $tRendimentos += $faturabilhete->preco;

		return $this->render('index', [
			'nEventos' => count($db_evento),
			'nSessoes' => count($db_sessao),
			'nBilhetes' => count($db_bilhete),
			'tRendimentos' => $tRendimentos,
		]);
	}

	/**
	 * Login action.
	 *
	 * @return string|Response
	 */
	public function actionLogin() {
		if (!Yii::$app->user->isGuest) return $this->goHome();

		$this->layout = 'blank';

		$model_login = new LoginForm();
		if ($model_login->load(Yii::$app->request->post())) {

			$user_login = User::findByUsername($model_login->username);

			if (is_null($user_login))
				Yii::$app->session->setFlash('error', 'Username ou password incorretos');

			elseif (!$user_login->isCliente()) {
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
	 * Logout action.
	 *
	 * @return Response
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
		if ($model_signup->load(Yii::$app->request->post()) && $model_signup->signup(User::ROLE_GESTOR)) {
			//Yii::$app->session->setFlash('success', 'Registo efetuado com sucesso');
			return $this->redirect(['user/index', 'sort' => 'username']);
		}

		return $this->render('signup', [
			'model_signup' => $model_signup,
		]);
	}
}
