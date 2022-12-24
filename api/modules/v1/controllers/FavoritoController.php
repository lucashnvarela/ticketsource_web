<?php

namespace api\modules\v1\controllers;

use common\models\User;
use frontend\models\Favorito;
use yii\rest\ActiveController;


class FavoritoController extends ActiveController {
	public $modelClass = 'common\models\Favorito';

	public function actionLista($token) {
		$user = User::findOne(['verification_token' => $token]);
		$eventos = $user->getFavoriteEvents();

		if (!empty($eventos)) {
			foreach ($eventos as $evento)
				$evento->nome_pic = 'http://' . \Yii::$app->request->getUserIP() . ':8080/imagens/' . $evento->nome_pic;

			return $eventos;
		} else
			throw new \yii\web\NotFoundHttpException("Utilizador não adicionou nenhum evento aos favoritos");
	}

	public function actionAdicionar($id, $token) {
		$user = User::findOne(['verification_token' => $token]);

		if (!is_null($user)) {
			$favorito = new Favorito();
			$favorito->id_user = $user->id;
			$favorito->id_evento = $id;

			if ($favorito->save()) return $favorito;
			else return null;
		} else
			throw new \yii\web\NotFoundHttpException("Utilizador não encontrado");
	}

	public function actionRemover($id, $token) {
		$user = User::findOne(['verification_token' => $token]);

		if (!is_null($user))
			return Favorito::deleteUserFavorito($id, $user->id);
		else
			throw new \yii\web\NotFoundHttpException("Utilizador não encontrado");
	}

	public function actionCheck($id, $token) {
		$user = User::findOne(['verification_token' => $token]);

		if (!is_null($user)) {
			$favorito = Favorito::findOne(['id_user' => $user->id, 'id_evento' => $id]);

			if (!is_null($favorito)) return true;
			else return false;
		} else
			throw new \yii\web\NotFoundHttpException("Utilizador não encontrado");
	}
}
