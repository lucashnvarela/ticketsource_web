<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\Fatura;
use Yii;
use frontend\models\Pagamento;
use frontend\models\PagamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PagamentoController implements the CRUD actions for Pagamento model.
 */
class PagamentoController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'only' => ['view', 'create'],
				'rules' => [
					[
						'actions' => ['view', 'create'],
						'allow' => true,
						'roles' => [User::ROLE_CLIENTE],
					],
				],
			],
		];
	}

	/**
	 * Creates a new Pagamento model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model_pagamento = new Pagamento();


		//* carregar dados do formulário
		if ($model_pagamento->load(Yii::$app->request->post())) {
			$model_pagamento->data_validade = date('Y-m-d', strtotime('01-' . $model_pagamento->data_validade));

			//* criar fatura e associar ao pagamento
			$model_fatura = Fatura::createFatura();
			$model_pagamento->id_fatura = $model_fatura->id;
			$model_pagamento->save(false);

			return $this->redirect(['fatura/create', 'id' => $model_fatura->id]);
		}

		return $this->render('create', [
			'model_pagamento' => $model_pagamento,
		]);
	}

	/**
	 * Displays a single Pagamento model.
	 * @param int $id ID
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model_pagamento' => $this->findModel($id),
		]);
	}

	/**
	 * Finds the Pagamento model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Pagamento the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Pagamento::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
