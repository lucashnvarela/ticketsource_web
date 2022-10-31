<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property int $id_user
 * @property string $data
 * @property float $total
 *
 * @property FaturaBilhete[] $faturaBilhetes
 * @property Pagamento[] $pagamentos
 * @property User $user
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'data', 'total'], 'required'],
            [['id_user'], 'integer'],
            [['data'], 'safe'],
            [['total'], 'number'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'data' => 'Data',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[FaturaBilhetes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturaBilhetes()
    {
        return $this->hasMany(FaturaBilhete::class, ['id_fatura' => 'id']);
    }

    /**
     * Gets query for [[Pagamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagamentos()
    {
        return $this->hasMany(Pagamento::class, ['id_fatura' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
