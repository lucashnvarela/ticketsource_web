<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_pagamento frontend/models/Pagamento */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/pagamento/create.css");

$this->title = 'Checkout';
?>

<div class="pagamento-create">
	<div class="card create-form">
		<div class="card-header">
			<h5 id="title">
				<ion-icon name="card-outline"></ion-icon> <?= $this->title ?>
			</h5>
			<p id="subtitle">Por favor preencha os seguintes campos</p>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'create-form']) ?>
		<div class="card-body">
			<?php
			echo $form->field($model_pagamento, 'numero_cartao', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Número do cartão :')
				->textInput(['maxlength' => 16, 'placeholder' => '0000 0000 0000 0000']);

			echo $form->field($model_pagamento, 'data_validade', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Data de validade :')
				->textInput(['maxlength' => 7, 'placeholder' => 'MM-AAAA']);

			echo $form->field($model_pagamento, 'codigo_seguranca', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Código de segunrança :')
				->textInput(['maxlength' => 3, 'placeholder' => '000']);
			?>
		</div>
		<div class="card-footer">
			<?= Html::submitButton('<ion-icon name="checkmark-outline"></ion-icon> Efetuar pagamento', ['class' => 'btn-default ripple', 'name' => 'create-button']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>