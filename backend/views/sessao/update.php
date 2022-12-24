<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_sessao common\models\Sessao */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;

$this->registerCssFile("@web/css/sessao/update.css");

$this->title = 'Editar - Sessão';
?>

<div class="update-page">
	<div class="card sessao-form">
		<div class="card-header">
			<h5 id="title">Editar : <span>Sessão</span></h5>
			<p id="subtitle">Por favor preencha os seguintes campos</p>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'form-sessao']) ?>
		<div class="card-body">
			<div>
				<?php
				echo $form->field($model_sessao, 'localizacao', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Localização :')
					->textInput();

				echo $form->field($model_sessao, 'data', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Data :')
					->widget(
						DatePicker::class,
						[
							'language' => 'pt',
							'dateFormat' => 'dd-MM-yyyy',
							'options' => ['class' => 'form-control']
						]
					)
					->textInput();
				?>
			</div>
			<div>
				<?php
				echo $form->field($model_sessao, 'preco', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Preço dos bilhetes :')
					->textInput();

				echo $form->field($model_sessao, 'numero_lugares', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Número de lugares :')
					->textInput(['disabled' => true]);
				?>
			</div>
		</div>
		<div class="card-footer">
			<?= Html::submitButton('<ion-icon name="sync-outline"></ion-icon> Atualizar', ['class' => 'btn-default ripple', 'name' => 'update-button']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>