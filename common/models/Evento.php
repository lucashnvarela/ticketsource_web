<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property string $tipo
 * @property string $nome_pic
 *
 * @property Favorito[] $favoritos
 * @property Sessao[] $sessaos
 */
class Evento extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'evento';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['titulo', 'descricao', 'tipo', 'nome_pic'], 'required'],
			[['tipo'], 'string'],
			[['titulo', 'descricao', 'nome_pic'], 'string', 'max' => 45],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'titulo' => 'Titulo',
			'descricao' => 'Descricao',
			'tipo' => 'Tipo',
			'nome_pic' => 'Nome Pic',
		];
	}

	/**
	 * Gets query for [[Favoritos]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getFavoritos() {
		return $this->hasMany(Favorito::class, ['id_evento' => 'id']);
	}

	/**
	 * Gets query for [[Sessaos]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getSessaos() {
		return $this->hasMany(Sessao::class, ['id_evento' => 'id']);
	}
}
