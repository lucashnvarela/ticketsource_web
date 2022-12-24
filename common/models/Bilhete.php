<?php

namespace common\models;

use Yii;
use frontend\models\Carrinho;
use frontend\models\FaturaBilhete;

/**
 * This is the model class for table "bilhete".
 *
 * @property int $id
 * @property int $id_sessao
 * @property string $uid
 * @property int $numero_lugar
 * @property string $disponivel
 * @property int $status
 *
 * @property Carrinho[] $carrinhos
 * @property FaturaBilhete $faturaBilhete
 * @property Sessao $sessao
 */
class Bilhete extends \yii\db\ActiveRecord {
	const STATUS_DISPONIVEL = 'Disponível';
	const STATUS_INDISPONIVEL = 'Indisponível';
	const STATUS_CANCELADO = 'Cancelado';
	const STATUS_ATIVO = 1;
	const STATUS_INATIVO = 0;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'bilhete';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['uid'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['uid'], 'string', 'max' => 36, 'message' => 'O campo {attribute} deve ter no máximo 36 caracteres'],
			[['uid'], 'unique', 'message' => 'O campo {attribute} já existe'],

			[['numero_lugar'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['numero_lugar'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],

			[['disponivel'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['disponivel'], 'validateEstado'],

			[['status'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['status'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['status'], 'in', 'range' => [self::STATUS_ATIVO, self::STATUS_INATIVO], 'message' => 'O campo {attribute} deve ser 1 ou 0'],

			[['id_sessao'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_sessao'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_sessao'], 'exist', 'skipOnError' => true, 'targetClass' => Sessao::class, 'targetAttribute' => ['id_sessao' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'id_sessao' => 'id_sessao',
			'uid' => 'UID',
			'numero_lugar' => 'número do lugar',
			'disponivel' => 'estado',
			'status' => 'status',
		];
	}

	/**
	 * Verifica se o estado do bilhete é válido
	 * @param mixed $attribute
	 * @param mixed $params
	 * @return void
	 */
	public function validateEstado($attribute, $params): void {
		if (!in_array($this->$attribute, [self::STATUS_DISPONIVEL, self::STATUS_INDISPONIVEL, self::STATUS_CANCELADO]))
			$this->addError($attribute, 'O campo {attribute} deve ser Disponível, Indisponível ou Cancelado');
	}

	/**
	 * Gera um UUID para o bilhete
	 */
	public function generateUUID() {
		$this->uid = sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,
			// 48 bits for "node"
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff)
		);
	}

	/**
	 * Verifica se o estado do bilhete é disponível
	 * @return bool
	 */
	public function isDisponivel(): bool {
		return $this->disponivel == self::STATUS_DISPONIVEL;
	}

	/**
	 * Verifica se o estado do bilhete é indisponível
	 * @return bool
	 */
	public function isIndisponivel(): bool {
		return $this->disponivel == self::STATUS_INDISPONIVEL;
	}

	/**
	 * Verifica se o estado do bilhete é cancelado
	 * @return bool
	 */
	public function isCancelado(): bool {
		return $this->disponivel == self::STATUS_CANCELADO;
	}

	/**
	 * Atualiza o estado do bilhete para indisponível
	 * @return bool
	 */
	public function setIndisponivel(): bool {
		$this->disponivel = self::STATUS_INDISPONIVEL;
		return $this->save();
	}

	/**
	 * Retorna todos os bilhetes de um utilizador
	 * @param int $id_user ID do utilizador de quem se pretende obter os bilhetes
	 * @return array 
	 */
	public static function getUserBilhetes(int $id_user): array {
		return self::find()
			->joinWith('fatura')
			->where(['fatura.id_user' => $id_user])
			->joinWith('fatura_bilhete')
			->where(['fatura_bilhete.id_fatura' => 'fatura.id'])
			->where(['fatura_bilhete.id_bilhete' => 'bilhete.id'])
			->all();
	}

	/**
	 * Gets query for [[Carrinhos]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getCarrinhos() {
		return $this->hasMany(Carrinho::class, ['bilhete_id' => 'id']);
	}

	/**
	 * Gets query for [[FaturaBilhete]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getFaturaBilhete() {
		return $this->hasOne(FaturaBilhete::class, ['id_bilhete' => 'id']);
	}

	/**
	 * Gets query for [[Sessao]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getSessao() {
		return $this->hasOne(Sessao::class, ['id' => 'id_sessao']);
	}
}
