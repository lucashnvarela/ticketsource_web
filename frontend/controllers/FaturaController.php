<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\Carrinho;
use Yii;
use frontend\models\Fatura;
use frontend\models\FaturaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * FaturaController implements the CRUD actions for Fatura model.
 */
class FaturaController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'only' => ['index', 'create', 'view'],
				'rules' => [
					[
						'actions' => ['index', 'create', 'view'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
					],
				],
			],
		];
	}

	/**
	 * Lists all Fatura models.
	 * @return mixed
	 */
	public function actionIndex() {
		//* verificar se o utilizador tem permissão para visualizar as faturas
		if (!Yii::$app->user->can('visualizarBilhetes'))
			throw new NotFoundHttpException;

		$model_search = new FaturaSearch();
		$dataProvider = $model_search->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'model_search' => $model_search,
			'db_fatura' => $dataProvider->getModels(),
		]);
	}

	/**
	 * Creates a new Fatura model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($id) {
		//* verificar se o utilizador tem permissão para criar uma fatura
		if (!Yii::$app->user->can('comprarBilhetes'))
			throw new NotFoundHttpException;

		$user_carrinho = Carrinho::getUserCarrinho();

		//* adicionar bilhetes do carrinho à fatura
		foreach ($user_carrinho as $item_carrinho)
			$this->findModel($id)->addBilhete($item_carrinho);

		//* atualizar o estado dos bilhetes para indisponível
		foreach ($user_carrinho as $item_carrinho)
			$item_carrinho->bilhete->setIndisponivel();

		//* remover os bilhetes do carrinho
		Carrinho::deleteAll(['id_user' => Yii::$app->user->id]);

		//* atualizar o total da fatura com o valor dos bilhetes e o valor do seguro
		foreach ($this->getBilhetes() as $item_fatura)
			$this->total += $item_fatura->bilhete->sessao->preco;
		$this->total += Carrinho::VALOR_SEGURO;

		$this->save();

		return $this->redirect(['carrinho/index']);
	}

	/**
	 * Displays a single Fatura model.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model_fatura' => $this->findModel($id),
		]);
	}

	/**
	 * Finds the Fatura model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Fatura the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Fatura::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
