<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\SignupForm;
use backend\models\UploadForm;
use common\models\User;
use common\models\Evento;

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
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
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
		$carousel_files = FileHelper::findFiles(dirname(Yii::$app->basePath) . '\\api\\web\\imagens\\carousel\\');
		$carousel_files = array_map(function ($file) {
			return '<img src="' . substr($file, 13) . '"/>';
		}, $carousel_files);

		$db_eventoNovidades = Evento::find()
			->orderBy(['id' => SORT_DESC])
			->limit(5)
			->all();

		$db_evento['Desporto'] = Evento::find()
			->where(['categoria' => 'Desporto'])
			->orderBy(['id' => SORT_DESC])
			->limit(5)
			->all();

		$db_evento['Música'] = Evento::find()
			->where(['categoria' => 'Música'])
			->orderBy(['id' => SORT_DESC])
			->limit(5)
			->all();

		$db_evento['Teatro'] = Evento::find()
			->where(['categoria' => 'Teatro'])
			->orderBy(['id' => SORT_DESC])
			->limit(5)
			->all();

		$db_evento['Festival'] = Evento::find()
			->where(['categoria' => 'Festival'])
			->orderBy(['id' => SORT_DESC])
			->limit(5)
			->all();

		return $this->render('index', [
			'carousel_items' => $carousel_files,
			'db_eventoNovidades' => $db_eventoNovidades,
			'db_evento' => $db_evento,
		]);
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

			$user_login = User::findByUsername(username: $model_login->username);

			if (is_null($user_login))
				Yii::$app->session->setFlash('error', 'Username ou password incorretos');

			elseif ($user_login->validatePassword(password: $model_login->password)) {
				if ($user_login->isCliente()) {
					if ($user_login->isActive()) {
						$model_login->login();

						return $this->goHome();
					} else
						Yii::$app->session->setFlash('error', 'Login indisponível');
				} else
					Yii::$app->session->setFlash('error', 'Sem permissão de acesso');
			} else
				Yii::$app->session->setFlash('error', 'Username ou password incorretos');
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
		if (!Yii::$app->user->isGuest) return $this->goHome();

		$model_signup = new SignupForm();
		if ($model_signup->load(Yii::$app->request->post()) && $model_signup->signup(role: User::ROLE_CLIENTE)) {
			Yii::$app->session->setFlash('success', 'Registo efetuado com sucesso');
			return $this->redirect(['login']);
		}

		return $this->render('signup', [
			'model_signup' => $model_signup,
		]);
	}
}
