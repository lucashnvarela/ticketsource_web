<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pagamento".
 *
 * @property int $id
 * @property int|null $numero_cartao
 * @property string|null $data_validade
 * @property int|null $codigo_seguranca
 *
 * @property Fatura[] $faturas
 */
class Pagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pagamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'numero_cartao', 'codigo_seguranca'], 'integer'],
            [['data_validade'], 'safe'],
            [['numero_cartao'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero_cartao' => 'Numero Cartao',
            'data_validade' => 'Data Validade',
            'codigo_seguranca' => 'Codigo Seguranca',
        ];
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['id_pagamento' => 'id']);
    }
}