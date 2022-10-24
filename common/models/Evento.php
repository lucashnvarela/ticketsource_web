<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $id
 * @property string|null $titulo
 * @property string|null $descricao
 * @property string|null $nome_pic
 *
 * @property Favorito[] $favoritos
 * @property Sessao[] $sessaos
 */
class Evento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['titulo', 'descricao', 'nome_pic'], 'string', 'max' => 45],
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
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'nome_pic' => 'Nome Pic',
        ];
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['id_evento' => 'id']);
    }

    /**
     * Gets query for [[Sessaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessaos()
    {
        return $this->hasMany(Sessao::class, ['evento_id' => 'id']);
    }
}
