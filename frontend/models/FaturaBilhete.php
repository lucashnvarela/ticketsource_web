<?php

namespace frontend\models;

use Yii;

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
class FaturaBilhete extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fatura_bilhete';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_fatura', 'id_bilhete', 'preco'], 'required'],
            [['id_fatura', 'id_bilhete'], 'integer'],
            [['preco'], 'number'],
            [['id_bilhete'], 'exist', 'skipOnError' => true, 'targetClass' => Bilhete::class, 'targetAttribute' => ['id_bilhete' => 'id']],
            [['id_fatura'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['id_fatura' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_fatura' => 'Id Fatura',
            'id_bilhete' => 'Id Bilhete',
            'preco' => 'Preco',
        ];
    }

    /**
     * Gets query for [[Bilhete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBilhete()
    {
        return $this->hasOne(Bilhete::class, ['id' => 'id_bilhete']);
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'id_fatura']);
    }
}
