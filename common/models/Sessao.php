<?php

namespace common\models;

use Yii;
use common\models\Bilhete;

/**
 * This is the model class for table "sessao".
 *
 * @property int $id
 * @property int $id_evento
 * @property string $data
 * @property string $localizacao
 * @property int $numero_lugares
 * @property float $preco 
 *
 * @property Bilhete[] $bilhetes
 * @property Evento $evento
 */
class Sessao extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'sessao';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['data'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['data'], 'date', 'format' => 'php:Y-m-d', 'message' => 'O campo {attribute} deve ter o formato yyyy-mm-dd'],

			[['localizacao'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['localizacao'], 'string', 'max' => 45, 'message' => 'O campo {attribute} deve ter no máximo 45 caracteres'],

			[['numero_lugares'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['numero_lugares'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],

			[['preco'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['preco'], 'number', 'message' => 'O campo {attribute} deve ser um número'],

			[['id_evento'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_evento'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'id_evento' => 'id_evento',
			'data' => 'data',
			'localizacao' => 'localização',
			'numero_lugares' => 'lugares disponíveis',
			'preco' => 'preço',
		];
	}

	/**
	 * Criação de bilhetes para uma sessão
	 */
	public function addBilhetes() {
		for ($i = 1; $i <= $this->numero_lugares; $i++) {
			$model_bilhete = new Bilhete();
			$model_bilhete->id_sessao = $this->id;
			$model_bilhete->generateUUID();
			$model_bilhete->numero_lugar = $i;
			$model_bilhete->disponivel = Bilhete::STATUS_DISPONIVEL;
			$model_bilhete->status = Bilhete::STATUS_ATIVO;
			$model_bilhete->save();
		}
	}

	/**
	 * Retorna todos os bilhetes da sessão
	 * @return array
	 */
	public function getBilhetes(): array {
		return Bilhete::find()
			->where(['id_sessao' => $this->id])
			->all();
	}

	/**
	 * Retorna o número de lugares disponíveis da sessão
	 * @return int
	 */
	public function countLugaresDisponiveis(): int {
		return Bilhete::find()
			->where(['id_sessao' => $this->id])
			->andWhere(['disponivel' => Bilhete::STATUS_DISPONIVEL])
			->count();
	}

	/**
	 * @Override
	 * Elimina a sessão e todos os bilhetes associados
	 */
	public function delete() {
		//* Elimina todos os bilhetes associados à sessão
		foreach ($this->bilhetes as $model_bilhete) {
			if ($model_bilhete->faturaBilhete != null)
				$model_bilhete->fatura_bilhete->delete();

			$model_bilhete->delete();
		}

		parent::delete();

		Yii::$app->session->setFlash('success', 'Sessão eliminada com sucesso');
	}

	/**
	 * Gets query for [[Evento]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getEvento() {
		return $this->hasOne(Evento::class, ['id' => 'id_evento']);
	}
}
