<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pagamento".
 *
 * @property int $id
 * @property int $id_fatura
 * @property int $numero_cartao
 * @property string $data_validade
 * @property int $codigo_seguranca
 *
 * @property Fatura $fatura
 */
class Pagamento extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'pagamento';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['data_validade'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['data_validade'], 'date', 'format' => 'M-yyyy', 'message' => 'O campo {attribute} deve ter o formato mês-ano'],
			[['data_validade'], 'validateDate'],

			[['numero_cartao'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['numero_cartao'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['numero_cartao'], 'match', 'pattern' => '/^[0-9]{16}$/', 'message' => '{attribute} inválido'],

			[['codigo_seguranca'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['codigo_seguranca'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['codigo_seguranca'], 'match', 'pattern' => '/^[0-9]{3}$/', 'message' => '{attribute} inválido'],

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
			'numero_cartao' => 'número do cartão',
			'data_validade' => 'data de validade',
			'codigo_seguranca' => 'código de segura',
		];
	}

	/**
	 * Valida a data de validade do cartão
	 * @param string $attribute
	 * @param array $params
	 * @return void
	 */
	public function validateDate($attribute, $params): void {
		$data_validade = explode('-', $this->$attribute);

		//* verifica se a data de validade já expirou
		if ($data_validade[1] < date('Y') || ($data_validade[1] == date('Y') && $data_validade[0] < date('m')))
			$this->addError($attribute, '{attribute} inválida');
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
