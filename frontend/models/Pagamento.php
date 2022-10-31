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
            [['id_fatura', 'numero_cartao', 'data_validade', 'codigo_seguranca'], 'required'],
            [['id_fatura', 'numero_cartao', 'codigo_seguranca'], 'integer'],
            [['data_validade'], 'safe'],
            [['numero_cartao'], 'unique'],
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
            'numero_cartao' => 'Numero Cartao',
            'data_validade' => 'Data Validade',
            'codigo_seguranca' => 'Codigo Seguranca',
        ];
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
