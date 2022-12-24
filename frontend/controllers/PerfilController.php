<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Perfil;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PerfilController implements the CRUD actions for Perfil model.
 */
class PerfilController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'actions' => ['update'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
					],
				],
			],
		];
	}

	/**
	 * Updates an existing Perfil model.
	 * @return mixed
	 */
	public function actionUpdate() {
		//* verificar se o utilizador tem permissão para atualizar o perfil
		if (!Yii::$app->user->can('editarPerfil'))
			throw new NotFoundHttpException;

		$user_perfil = Perfil::findOne(['id_user' => Yii::$app->user->id]);

		if ($user_perfil != null) $model_perfil = $user_perfil;
		else $model_perfil = Perfil::addPerfil(id_user: Yii::$app->user->id);

		if ($model_perfil->load(Yii::$app->request->post()) && $model_perfil->save()) {
			Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso');
			return $this->refresh();
		}

		return $this->render('update', [
			'model_perfil' => $model_perfil,
		]);
	}

	/**
	 * Finds the Perfil model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id_user
	 * @return Perfil the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Perfil::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
