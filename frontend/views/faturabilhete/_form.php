<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\FaturaBilhete */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="fatura-bilhete-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_fatura')->textInput() ?>

    <?= $form->field($model, 'id_bilhete')->textInput() ?>

    <?= $form->field($model, 'preco')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
