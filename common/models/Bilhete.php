<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bilhete".
 *
 * @property int $id
 * @property int $id_sessao
 * @property int|null $uid
 * @property int|null $numero_lugar
 * @property float|null $preco
 * @property int|null $disponivel
 * @property int|null $status
 *
 * @property Carrinho[] $carrinhos
 * @property FaturaBilhete[] $faturaBilhetes
 * @property Sessao $sessao
 */
class Bilhete extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bilhete';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_sessao'], 'required'],
            [['id', 'id_sessao', 'uid', 'numero_lugar', 'disponivel', 'status'], 'integer'],
            [['preco'], 'number'],
            [['uid'], 'unique'],
            [['id'], 'unique'],
            [['id_sessao'], 'exist', 'skipOnError' => true, 'targetClass' => Sessao::class, 'targetAttribute' => ['id_sessao' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sessao' => 'Id Sessao',
            'uid' => 'Uid',
            'numero_lugar' => 'Numero Lugar',
            'preco' => 'Preco',
            'disponivel' => 'Disponivel',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Carrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhos()
    {
        return $this->hasMany(Carrinho::class, ['bilhete_id' => 'id']);
    }

    /**
     * Gets query for [[FaturaBilhetes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturaBilhetes()
    {
        return $this->hasMany(FaturaBilhete::class, ['id_bilhete' => 'id']);
    }

    /**
     * Gets query for [[Sessao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessao()
    {
        return $this->hasOne(Sessao::class, ['id' => 'id_sessao']);
    }
}
