<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Sessao;
use common\models\SessaoSearch;
use frontend\models\Carrinho;
use common\models\Bilhete;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SessaoController implements the CRUD actions for Sessao model.
 */
class SessaoController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'only' => ['create'],
				'rules' => [
					[
						'actions' => ['view'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
					],
				],
			],
		];
	}

	/**
	 * Displays a single Sessao model.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id) {
		$model_sessao = $this->findModel($id);

		//* verifica se o utilizador está autenticado
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('error', 'É necessário estar autenticado para poder adicionar bilhetes ao carrinho');
			return $this->redirect(['evento/view', 'id' => $model_sessao->evento->id]);
		}

		//* cria um array com cada número de bilhete da sessão
		$numeroLugares = range(1, $model_sessao->numero_lugares);

		$numero_lugar = Yii::$app->request->post('numero_lugar');
		//* verifica se o utilizador escolheu um número de bilhete
		if (!is_null($numero_lugar)) {
			$model_bilhete = Bilhete::findOne(['id_sessao' => $id, 'numero_lugar' => ++$numero_lugar]);

			//* cria um item carrinho do bilhete escolhido
			return $this->redirect(['carrinho/create', 'id_bilhete' => $model_bilhete->id]);
		}

		return $this->render('view', [
			'model_sessao' => $model_sessao,
			'numeroLugares' => $numeroLugares,
		]);
	}

	/**
	 * Finds the Sessao model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Sessao the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Sessao::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
