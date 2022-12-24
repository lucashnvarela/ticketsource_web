<?php

namespace frontend\models;

use Yii;
use common\models\Bilhete;

/**
 * This is the model class for table "fatura_bilhete".
 *
 * @property int $id
 * @property int $id_fatura
 * @property int $id_bilhete
 * @property float $preco
 *
 * @property Bilhete $bilhete
 * @property Fatura $fatura
 */
class FaturaBilhete extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'fatura_bilhete';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['preco'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['preco'], 'number', 'message' => 'O campo {attribute} deve ser um número'],

			[['id_bilhete'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_bilhete'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_bilhete'], 'exist', 'skipOnError' => true, 'targetClass' => Bilhete::class, 'targetAttribute' => ['id_bilhete' => 'id']],

			[['id_fatura'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_fatura'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_fatura'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['id_fatura' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'id_fatura' => 'id_fatura',
			'id_bilhete' => 'id_bilhete',
			'preco' => 'preço',
		];
	}

	/**
	 * Gets query for [[Bilhete]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getBilhete() {
		return $this->hasOne(Bilhete::class, ['id' => 'id_bilhete']);
	}

	/**
	 * Gets query for [[Fatura]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getFatura() {
		return $this->hasOne(Fatura::class, ['id' => 'id_fatura']);
	}
}
