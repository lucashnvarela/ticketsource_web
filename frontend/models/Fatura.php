<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property int $user_id
 * @property int $id_pagamento
 * @property string|null $data
 * @property float|null $total
 *
 * @property FaturaBilhete[] $faturaBilhetes
 * @property Pagamento $pagamento
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
            [['id', 'user_id', 'id_pagamento'], 'required'],
            [['id', 'user_id', 'id_pagamento'], 'integer'],
            [['data'], 'safe'],
            [['total'], 'number'],
            [['id'], 'unique'],
            [['id_pagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Pagamento::class, 'targetAttribute' => ['id_pagamento' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'id_pagamento' => 'Id Pagamento',
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
     * Gets query for [[Pagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagamento()
    {
        return $this->hasOne(Pagamento::class, ['id' => 'id_pagamento']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
