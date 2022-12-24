<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Favorito;
use frontend\models\FavoritoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'only' => ['index'],
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
					],
				],
			],
		];
	}

	/**
	 * Lists all Favorito models.
	 * @return mixed
	 */
	public function actionIndex($filter = null) {
		//* verificar se o utilizador tem permissão para aceder aos favoritos
		if (!Yii::$app->user->can('visualizarFavoritos'))
			throw new NotFoundHttpException;

		$model_search = new FavoritoSearch();
		$dataProvider = $model_search->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'model_search' => $model_search,
			'db_favorito' => $dataProvider->getModels(),
		]);
	}

	/**
	 * Creates a new Favorito model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($id_evento) {
		//* verificar se o utilizador tem permissão para adicionar um evento aos favoritos
		if (!Yii::$app->user->can('adicionarFavoritos'))
			throw new NotFoundHttpException;

		if (!is_null(Favorito::findOne(['id_user' => Yii::$app->user->id, 'id_evento' => $id_evento])))
			return $this->redirect(['evento/view', 'id' => $id_evento]);

		$model_favorito = new Favorito();

		$model_favorito->id_user = Yii::$app->user->id;
		$model_favorito->id_evento = $id_evento;

		if ($model_favorito->save()) return $this->redirect(['evento/view', 'id' => $id_evento]);
	}

	/**
	 * Deletes an existing Favorito model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id_evento) {
		//* verificar se o utilizador tem permissão para remover um evento dos favoritos
		if (!Yii::$app->user->can('apagarFavoritos'))
			throw new NotFoundHttpException;

		$model_favorito = Favorito::findOne([
			'id_user' => Yii::$app->user->id,
			'id_evento' => $id_evento
		]);

		if ($model_favorito->delete()) return $this->redirect(['evento/view', 'id' => $id_evento]);
	}

	/**
	 * Finds the Favorito model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Favorito the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Favorito::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
