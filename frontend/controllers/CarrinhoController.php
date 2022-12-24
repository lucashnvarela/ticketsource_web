<?php

namespace frontend\controllers;

use common\models\Bilhete;
use common\models\User;
use Yii;
use frontend\models\Carrinho;
use frontend\models\CarrinhoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * CarrinhoController implements the CRUD actions for Carrinho model.
 */
class CarrinhoController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'only' => ['index', 'create', 'delete', 'deleteall'],
				'rules' => [
					[
						'actions' => ['index', 'create', 'delete', 'deleteall'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Carrinho models.
	 * @return mixed
	 */
	public function actionIndex() {
		//* verificar se o utilizador tem permissão para visualizar o carrinho
		if (!Yii::$app->user->can('visualizarCarrinho'))
			throw new NotFoundHttpException;

		$user_carrinho = Carrinho::getUserCarrinho();
		$carrinho_total = 0;

		//* somar o preço de cada bilhete ao total
		foreach ($user_carrinho as $item_carrinho)
			$carrinho_total += $item_carrinho->bilhete->sessao->preco;

		//* adicionar o valor do seguro ao total
		$carrinho_total += Carrinho::VALOR_SEGURO;

		return $this->render('index', [
			'db_carrinho' => $user_carrinho,
			'carrinho_total' => $carrinho_total,
		]);
	}

	/**
	 * Creates a new Carrinho model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($id_bilhete) {
		//* verificar se o utilizador tem permissão para adicionar ao carrinho
		if (!Yii::$app->user->can('adicinarBilhetesAoCarrinho'))
			throw new NotFoundHttpException;

		$model_bilhete = Bilhete::findOne($id_bilhete);

		//* verifica se o bilhete está indisponível
		if ($model_bilhete->isIndisponivel()) {
			Yii::$app->session->setFlash('error', 'O número do lugar que selecionou já não se encontra disponível');
			return $this->redirect(['sessao/view', 'id' => $model_bilhete->sessao->id]);
		}

		//* verifica se o bilhete já se encontra no carrinho
		if (
			Carrinho::find()
			->where(['id_user' => Yii::$app->user->id])
			->andWhere(['id_bilhete' => $model_bilhete->id])
			->exists()
		) {
			Yii::$app->session->setFlash('error', 'O bilhete que selecionou já se encontra no seu carrinho');
			return $this->redirect(['sessao/view', 'id' => $model_bilhete->sessao->id]);
		}

		//* cria um item carrinho do bilhete escolhido
		$model_carrinho = new Carrinho();
		$model_carrinho->id_user = Yii::$app->user->id;
		$model_carrinho->id_bilhete = $model_bilhete->id;

		if ($model_carrinho->save()) {
			Yii::$app->session->setFlash('success', 'Bilhete adicionado ao carrinho com sucesso');
			return $this->redirect(['evento/view', 'id' => $model_bilhete->sessao->id_evento]);
		}
	}

	public function actionFinalizar() {
		//* verificar se o utilizador tem permissão para finalizar o carrinho
		if (!Yii::$app->user->can('comprarBilhetes'))
			throw new NotFoundHttpException;

		$user_carrinho = Carrinho::find()->where(['id_user' => Yii::$app->user->id])->all();

		//* verificar se todos os bilhetes do carrinho estão disponíveis
		foreach ($user_carrinho as $item_carrinho) {
			if ($item_carrinho->bilhete->isIndisponivel()) {
				Yii::$app->session->setFlash('warning', 'Um ou mais bilhetes do seu carrinho já não se encontram disponíveis');
				return $this->redirect(['index']);
			}
		}

		if (!is_null($user_carrinho)) {
			//* verificar se o utilizador tem perfil
			if (User::hasPerfil())
				return $this->redirect(['pagamento/create']);
			else {
				Yii::$app->session->setFlash('warning', 'Para finalizar a compra, necessita de atualizar os seus ' . Html::a('dados pessoais', ['perfil/update']));
				return $this->redirect(['index']);
			}
		}
	}

	/**
	 * Deletes an existing Carrinho model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		//* verificar se o utilizador tem permissão para eliminar o item do carrinho
		if (!Yii::$app->user->can('apagarBilhetesdoCarrinho'))
			throw new NotFoundHttpException;

		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionDeleteall() {
		$user_carrinho = Carrinho::find()
			->where(['id_user' => Yii::$app->user->id])
			->all();

		foreach ($user_carrinho as $item_carrinho)
			$item_carrinho->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Carrinho model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Carrinho the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Carrinho::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
