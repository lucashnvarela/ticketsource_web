<?php

namespace frontend\models;

use Yii;
use common\models\User;


/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property int $id_user
 * @property string $data
 * @property float $total
 *
 * @property FaturaBilhete[] $faturaBilhetes
 * @property Pagamento $pagamento
 * @property User $user
 */
class Fatura extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'fatura';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['data'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['data'], 'safe'],

			[['total'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['total'], 'number', 'message' => 'O campo {attribute} deve ser um número'],

			[['id_user'], 'required', 'message' => 'O campo {attribute} é obrigatório'],
			[['id_user'], 'integer', 'message' => 'O campo {attribute} deve ser um número inteiro'],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'id',
			'id_user' => 'id_user',
			'data' => 'data',
			'total' => 'total',
		];
	}

	/**
	 * Criar uma nova fatura
	 * @return Fatura Modelo da fatura criada
	 */
	public static function createFatura(): Fatura {
		$model_fatura = new Fatura();
		$model_fatura->id_user = Yii::$app->user->id;
		$model_fatura->data = date('Y-m-d');
		$model_fatura->save();

		return $model_fatura;
	}

	/**
	 * Adiciona um bilhete à fatura
	 * @param Carrinho $model_carrinho Modelo do carrinho com o bilhete a adicionar
	 * @return FaturaBilhete Modelo da fatura_bilhete criada
	 */
	public function addBilhete(Carrinho $model_carrinho): FaturaBilhete {
		$model_faturabilhete = new FaturaBilhete();
		$model_faturabilhete->id_fatura = $this->id;
		$model_faturabilhete->id_bilhete = $model_carrinho->id_bilhete;
		$model_faturabilhete->preco = $model_carrinho->bilhete->sessao->preco;
		$model_faturabilhete->save();

		return $model_faturabilhete;
	}


	/**
	 * Retorna os bilhetes da fatura
	 * @return array
	 */
	public function getBilhetes(): array {
		return FaturaBilhete::find()
			->where(['id_fatura' => $this->id])
			->all();
	}

	/**
	 * Gets query for [[Pagamento]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getPagamento() {
		return $this->hasOne(Pagamento::class, ['id_fatura' => 'id']);
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::class, ['id' => 'id_user']);
	}
}
