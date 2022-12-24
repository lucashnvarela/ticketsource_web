<?php

namespace frontend\controllers;

use Yii;
use common\models\Evento;
use common\models\EventoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller {
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
						'actions' => ['index', 'view'],
						'allow' => true,
						'roles' => ['?'],
					],
				],
			],
		];
	}

	/**
	 * Lists all Evento models.
	 * @return mixed
	 */
	public function actionIndex($filter = null) {
		$model_search = new EventoSearch();
		$data_provider = $model_search->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'model_search' => $model_search,
			'db_evento' => $data_provider->getModels(),
		]);
	}

	/**
	 * Displays a single Evento model.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model_evento' => $this->findModel($id),
		]);
	}

	/**
	 * Finds the Evento model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Evento the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Evento::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
