<?php

namespace backend\controllers;

use Yii;
use yii\data\Sort;
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
						'roles' => ['admin'],
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

		$sort_form = new Sort([
			'attributes' => ['username', 'created_at', 'status'],
		]);

		$db_users = User::find()
			->where(['not', ['id' => 1]])
			->orderBy($sort_form->orders)
			->all();

		return $this->render('index', [
			'db_users' => $db_users,
			'sort_config' => User::tableSort(sort_form: $sort_form->orders),
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
	 * @brief Blocks a user
	 * 
	 * @param int $id
	 */
	public function actionBlock($id) {

		if (Yii::$app->user->can(permissionName: 'bloquearCliente')) $this->findModel($id)->block();
		else Yii::$app->session->setFlash('error', 'Não tem permissões para bloquear');

		return $this->redirect(['index', 'sort' => 'username']);
	}

	/**
	 * @brief Unblocks a user
	 * 
	 * @param int $id
	 */
	public function actionUnblock($id) {

		if (Yii::$app->user->can(permissionName: 'desbloquearCliente')) $this->findModel($id)->unblock();
		else Yii::$app->session->setFlash('error', 'Não tem permissões para desbloquear');

		return $this->redirect(['index', 'sort' => 'username']);
	}

	/**
	 * @brief Deletes a user
	 * 
	 * @param int $id
	 */
	public function actionDelete($id) {

		//* Alterar permissão para 'eliminarGestor'
		if (Yii::$app->user->can(permissionName: 'desbloquearCliente')) $this->findModel($id)->delete();
		else Yii::$app->session->setFlash('error', 'Não tem permissões para eliminar');

		return $this->redirect(['index', 'sort' => 'username']);
	}
}
