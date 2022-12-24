<?php

namespace backend\controllers;

use Yii;
use yii\data\Sort;
use yii\data\Pagination;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['index', 'block', 'unblock', 'delete'],
						'allow' => true,
						'roles' => [User::ROLE_ADMIN],
					],
				],
			],
		];
	}

	/**
	 * Lists all User models.
	 * @return mixed
	 */
	public function actionIndex() {
		//* verificar se o utilizador tem permissão para visualizar os utilizadores
		if (!Yii::$app->user->can('visualizarUtilizadores'))
			throw new NotFoundHttpException;

		$sort = new Sort([
			'attributes' => ['username', 'created_at', 'status'],
		]);

		$model_search = new UserSearch();
		$data_provider = $model_search->search(Yii::$app->request->queryParams, $sort);

		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data_provider->getTotalCount(),
		]);

		return $this->render('index', [
			'db_users' => $data_provider->getModels(),
			'model_search' => $model_search,
			'pagination' => $pagination,
			'sort_config' => User::tableSort(sort_orders: $sort->orders),
		]);
	}

	/**
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = User::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * Blocks a user
	 * @param int $id
	 */
	public function actionBlock($id) {
		//* verificar se o utilizador tem permissão para bloquear utilizadores
		if (Yii::$app->user->can('bloquearCliente')) $this->findModel($id)->setInactive();
		else Yii::$app->session->setFlash('error', 'Não tem permissões para bloquear este utilizador');

		return $this->redirect(['index', 'sort' => 'username']);
	}

	/**
	 * Unblocks a user
	 * @param int $id
	 */
	public function actionUnblock($id) {
		//* verificar se o utilizador tem permissão para desbloquear utilizadores
		if (Yii::$app->user->can('desbloquearCliente')) $this->findModel($id)->setActive();
		else Yii::$app->session->setFlash('error', 'Não tem permissões para desbloquear este utilizador');

		return $this->redirect(['index', 'sort' => 'username']);
	}

	/**
	 * Deletes a user
	 * @param int $id
	 */
	public function actionDelete($id) {
		//* verificar se o utilizador tem permissão para eliminar utilizadores
		if (Yii::$app->user->can('eliminarGestor')) $this->findModel($id)->setDeleted();
		else Yii::$app->session->setFlash('error', 'Não tem permissões para eliminar este utilizador');

		return $this->redirect(['index', 'sort' => 'username']);
	}
}
