<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_pagamento frontend/models/Pagamento */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/pagamento/view.css");

$this->title = 'Fatura' . ' #' . $model_pagamento->fatura->id . strtotime($model_pagamento->fatura->data);
?>

<div class="pagamento-view">
	<div class="card view-form">
		<div class="card-header">
			<h5 id="title">
				<ion-icon name="card-outline"></ion-icon> Dados do pagamento
			</h5>
			<p id="subtitle"><?= $this->title ?></p>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'view-form']) ?>
		<div class="card-body">
			<?php
			echo $form->field($model_pagamento, 'numero_cartao', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Número do cartão :')
				->textInput(['disabled' => true]);

			echo $form->field($model_pagamento, 'data_validade', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Data de validade :')
				->textInput(['disabled' => true]);

			echo $form->field($model_pagamento, 'codigo_seguranca', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Código de segunrança :')
				->textInput(['disabled' => true]);;
			?>
		</div>
		<div class="card-footer">
			<?= Html::a('<ion-icon name="chevron-back-outline"></ion-icon> Voltar', ['fatura/index'], ['class' => 'btn-default']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>