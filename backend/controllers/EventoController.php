<?php

namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use common\models\User;
use common\models\Evento;
use common\models\EventoSearch;
use backend\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

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
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['index', 'create', 'update', 'delete'],
						'allow' => true,
						'roles' => [User::ROLE_GESTOR],
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
	 * Lists all Evento models.
	 * @return mixed
	 */
	public function actionIndex() {
		//* verificar se o utilizador tem permissões para visualizar os eventos
		if (!Yii::$app->user->can('visualizarEventos'))
			throw new NotFoundHttpException;

		$model_search = new EventoSearch();
		$data_provider = $model_search->search(Yii::$app->request->queryParams);

		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data_provider->getTotalCount(),
		]);

		return $this->render('index', [
			'model_search' => $model_search,
			'db_evento' => $data_provider->getModels(),
			'pagination' => $pagination,
		]);
	}

	/**
	 * Creates a new Evento model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		//* verificar se o utilizador tem permissões para criar eventos
		if (!Yii::$app->user->can('adicionarEvento'))
			throw new NotFoundHttpException;

		$model_evento = new Evento();
		$model_upload = new UploadForm();

		if ($model_evento->load(Yii::$app->request->post()) and $model_upload->load(Yii::$app->request->post())) {
			// Upload da imagem
			$model_upload->imageFile = UploadedFile::getInstance($model_upload, 'imageFile');
			$model_upload->upload();

			// Nome do ficheiro
			$model_evento->nome_pic = $model_upload->imageFile->name;
			$model_evento->save();

			Yii::$app->session->setFlash('success', 'Evento registado com sucesso');
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model_evento' => $model_evento,
			'model_upload' => $model_upload,
		]);
	}

	/**
	 * Updates an existing Evento model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		//* verificar se o utilizador tem permissões para atualizar eventos
		if (!Yii::$app->user->can('editarEvento'))
			throw new NotFoundHttpException;

		$model_evento = $this->findModel($id);
		$model_upload = new UploadForm();

		if ($model_evento->load(Yii::$app->request->post()) and $model_upload->load(Yii::$app->request->post())) {
			$model_upload->imageFile = UploadedFile::getInstance($model_upload, 'imageFile');

			if (!is_null($model_upload->imageFile)) {
				// Upload da imagem
				$model_upload->upload();

				// Nome do ficheiro
				$model_evento->nome_pic = $model_upload->imageFile->name;
				$model_evento->save();
			}

			Yii::$app->session->setFlash('success', 'Evento atualizado com sucesso');
			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'model_evento' => $model_evento,
			'model_upload' => $model_upload,
		]);
	}

	/**
	 * Deletes an existing Evento model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		//* verificar se o utilizador tem permissões para apagar eventos
		if (!Yii::$app->user->can('apagarEvento'))
			throw new NotFoundHttpException;

		$this->findModel($id)->delete();

		return $this->redirect(['index']);
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
