<?php

namespace api\modules\v1\controllers;

use common\models\User;
use common\models\Bilhete;
use frontend\models\FaturaBilhete;
use yii\rest\ActiveController;

class BilheteController extends ActiveController {
	public $modelClass = 'common\models\Bilhete';

	public function actionLista($token) {
		$user = User::findOne(['verification_token' => $token]);

		if (!is_null($user)) {
			$bilhetes = Bilhete::getUserBilhetes($user->id);

			if (!empty($bilhetes)) return $bilhetes;
			else
				throw new \yii\web\NotFoundHttpException("Utilizador não adquiriu nenhum bilhete");
		} else
			throw new \yii\web\NotFoundHttpException("Utilizador não encontrado");
	}

	public function actionCancelar($id, $token) {
		$user = User::findOne(['verification_token' => $token]);

		if (!is_null($user)) {
			$bilhete = Bilhete::findOne($id);

			if (!is_null($bilhete)) {
				if (
					FaturaBilhete::find()
					->where(['id_bilhete' => $bilhete->id])
					->joinWith('fatura')
					->where(['id_user' => $user->id])
					->exists()
				) {
					$bilhete->disponivel = Bilhete::STATUS_CANCELADO;

					if ($bilhete->save()) return $bilhete;
					else return null;
				} else
					throw new \yii\web\NotFoundHttpException("Não tem permissão para cancelar este bilhete");
			} else
				throw new \yii\web\NotFoundHttpException("Bilhete não encontrado");
		}
	}

	public function actionCheckin($id) {
		$bilhete = Bilhete::findOne($id);

		if (!is_null($bilhete)) {
			$bilhete->disponivel = Bilhete::STATUS_INATIVO;

			if ($bilhete->save()) return $bilhete;
			else return null;
		} else
			throw new \yii\web\NotFoundHttpException("Bilhete não encontrado");
	}
}
