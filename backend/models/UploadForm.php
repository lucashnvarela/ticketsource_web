<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model {
	/**
	 * @var UploadedFile
	 */
	public $imageFile;

	public function rules() {
		return [
			[['imageFile'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['imageFile'], 'file'],
		];
	}

	public function attributeLabels() {
		return [
			'imageFile' => 'imagem do evento',
		];
	}

	public function upload() {
		if ($this->validate()) {
			$this->imageFile->saveAs(dirname(Yii::$app->basePath) . '\\api\\web\\imagens\\' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

			return true;
		} else  return false;
	}

	public static function getImageDir() {
		return '/ticketsource/api/web/imagens/';
	}
}
