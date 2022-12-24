<?php

namespace api\modules\v1\controllers;

use common\models\Evento;
use yii\rest\ActiveController;

class EventoController extends ActiveController {
	public $modelClass = 'common\models\Evento';

	public function actionLista() {
		$eventos = Evento::find()->all();

		if (!empty($eventos)) {
			foreach ($eventos as $evento)
				$evento->nome_pic =  'http://' . \Yii::$app->request->getUserIP() . ':8080/imagens/' . $evento->nome_pic;

			return $eventos;
		} else
			throw new \yii\web\NotFoundHttpException("Não existem eventos");
	}
}
