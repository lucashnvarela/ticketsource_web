<?php

namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use common\models\User;
use common\models\Sessao;
use common\models\SessaoSearch;
use common\models\Calendar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
	 * Lists all Sessao models.
	 * @return mixed
	 */
	public function actionIndex($month, $year, $filter = null) {
		//* verifiar se o utilizador tem permissões para visualizar as sessões
		if (!Yii::$app->user->can('visualizarSessoes'))
			throw new NotFoundHttpException;

		$class_calendar = new Calendar();
		$class_calendar->setCalendar($month, $year, $filter);

		return $this->render('index', [
			'class_calendar' => $class_calendar,
		]);
	}

	/**
	 * Displays a single Sessao model.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($data = null, $id_evento = null, $filter = null) {
		//* verificar se o utilizador tem permissões para visualizar as sessões
		if (!Yii::$app->user->can('visualizarSessoes'))
			throw new NotFoundHttpException;

		$model_search = new SessaoSearch();
		$data_provider = $model_search->search(Yii::$app->request->queryParams);

		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data_provider->getTotalCount(),
		]);

		return $this->render('view', [
			'db_sessao' => $data_provider->getModels(),
			'model_search' => $model_search,
			'pagination' => $pagination,
		]);
	}

	/**
	 * Creates a new Sessao model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($id_evento) {
		//* verificar se o utilizador tem permissões para criar sessões
		if (!Yii::$app->user->can('adicionarSessao'))
			throw new NotFoundHttpException;

		$model_sessao = new Sessao();

		if ($model_sessao->load(Yii::$app->request->post())) {
			$model_sessao->id_evento = $id_evento;
			$model_sessao->data = date('Y-m-d', strtotime($model_sessao->data));
			$model_sessao->save();
			$model_sessao->addBilhetes();

			Yii::$app->session->setFlash('success', 'Sessão registada com sucesso');
			return $this->redirect(['view', 'id_evento' => $model_sessao->id_evento]);
		}

		return $this->render('create', [
			'model_sessao' => $model_sessao,
		]);
	}

	/**
	 * Updates an existing Sessao model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		//* verificar se o utilizador tem permissões para editar sessões
		if (!Yii::$app->user->can('editarSessao'))
			throw new NotFoundHttpException;

		$model_sessao = $this->findModel($id);
		$model_sessao->data = date('d-m-Y', strtotime($model_sessao->data));

		if ($model_sessao->load(Yii::$app->request->post())) {
			$model_sessao->data = date('Y-m-d', strtotime($model_sessao->data));
			$model_sessao->save();

			Yii::$app->session->setFlash('success', 'Sessão atualizada com sucesso');
			return $this->redirect(['view', 'id_evento' => $model_sessao->id_evento]);
		}

		return $this->render('update', [
			'model_sessao' => $model_sessao,
		]);
	}

	/**
	 * Deletes an existing Sessao model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		//* verificar se o utilizador tem permissões para eliminar sessões
		if (!Yii::$app->user->can('apagarSessao'))
			throw new NotFoundHttpException;

		$this->findModel($id)->delete();

		return $this->redirect(['view', 'id_evento' => $this->findModel($id)->id_evento]);
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
