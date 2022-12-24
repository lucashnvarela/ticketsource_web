<?php

namespace common\models;

use frontend\models\Favorito;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "evento".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property string $categoria
 * @property string $nome_pic
 *
 * @property Favorito[] $favoritos
 * @property Sessao[] $sessoes
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
			[['titulo'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['titulo'], 'string', 'max' => 45, 'message' => 'O campo {attribute} deve ter no máximo 45 caracteres'],

			//[['descricao'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['descricao'], 'string', 'max' => 135, 'message' => 'O campo {attribute} deve ter no máximo 135 caracteres'],

			[['categoria'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['categoria'], 'string', 'message' => 'O campo {attribute} deve ser uma string'],
			[['categoria'], 'in', 'range' => self::getCategoriaList(), 'message' => 'O campo {attribute} deve conter uma opção válida'],

			[['nome_pic'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['nome_pic'], 'string', 'max' => 45, 'message' => 'O campo {attribute} deve ter no máximo 45 caracteres'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'titulo' => 'título',
			'descricao' => 'descrição',
			'categoria' => 'categoria',
			'nome_pic' => 'imagem do evento',
		];
	}

	public static function getCategoriaList() {
		return [
			'Desporto', 'Música', 'Teatro', 'Festival'
		];
	}

	/**
	 * Elimina um evento e todas as sessões e bilhetes associados
	 * @Override
	 */
	public function delete() {
		//* Elimina todas as sessões do evento
		foreach ($this->sessoes as $model_sessao)
			$model_sessao->delete();

		parent::delete();

		Yii::$app->session->setFlash('success', 'Evento eliminado com sucesso');
	}

	/**
	 * Retorna todas as sessões do evento
	 * @return array
	 */
	public function getSessoes(): array {
		return Sessao::find()
			->where(['id_evento' => $this->id])
			->all();
	}

	/**
	 * Verifica se o evento é favorito do utilizador autenticado
	 * @return bool True se o evento for favorito do utilizador, False caso contrário
	 */
	public function isFavorito(): bool {
		return Favorito::find()
			->where(['id_user' => Yii::$app->user->id])
			->andWhere(['id_evento' => $this->id])
			->exists();
	}

	/**
	 * Retorna todas as categorias de evento e em primeiro a categoria do evento atual
	 * @return array
	 */
	public function getDropdownList() {
		foreach (self::getCategoriaList() as $type) $dropdown_list[$type] = $type;

		$dropdown_list = array_merge(
			[$this->categoria => $this->categoria],
			$dropdown_list
		);

		return $dropdown_list;
	}

	/**
	 * Retorna a classe CSS do botão da categoria do evento
	 * @param string $evento_categoria Categoria do evento
	 * @return string
	 */
	public static function getCategoriaBtnClass(string $evento_categoria): string {
		$btnClass = [
			'Desporto' => 'blue',
			'Música' => 'purple',
			'Teatro' => 'green',
			'Festival' => 'red'
		];

		return $btnClass[$evento_categoria];
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
