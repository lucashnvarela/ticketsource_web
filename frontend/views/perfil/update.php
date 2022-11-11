<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_perfil common\models\Perfil */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use common\widgets\Alert;

$this->registerCssFile("@web/css/perfil/update.css");

$this->title = 'Informações pessoais';
?>

<div class="update-page">
	<div class="update-container">
		<div class="card update-form">
			<div class="card-header">
				<h5 class="title"><i class="far fa-address-card"></i> <?= $this->title ?></h5>
				<p class="subtitle">Por favor preencha os seguintes campos</p>
			</div>
			<?php $form = ActiveForm::begin(['id' => 'update-form']) ?>
			<div class="card-body">
				<?php
				echo $form->field($model_perfil, 'nome', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Nome completo :')
					->textInput();
				?>
				<div>
					<?php
					echo $form->field($model_perfil, 'telefone', [
						'options' => ['class' => 'input-group has-feedback'],
						'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
					])
						->label('Telefone :')
						->textInput(['maxlength' => 9]);

					echo $form->field($model_perfil, 'nif', [
						'options' => ['class' => 'input-group has-feedback'],
						'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
					])
						->label('NIF :')
						->textInput(['maxlength' => 9]);
					?>
				</div>
				<div>
					<?php
					echo $form->field($model_perfil, 'pais', [
						'options' => ['class' => 'input-group has-feedback'],
						'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
					])
						->label('País :')
						->textInput();

					echo $form->field($model_perfil, 'distrito', [
						'options' => ['class' => 'input-group has-feedback'],
						'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
					])
						->label('Distrito :')
						->textInput();
					?>
				</div>
				<?php
				echo $form->field($model_perfil, 'morada', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Morada :')
					->textInput();
				?>
			</div>
			<div class="card-footer">
				<?= Html::submitButton('Guardar', ['class' => 'btn btn-success ripple', 'name' => 'update-button']) ?>
			</div>
			<?php ActiveForm::end() ?>
		</div>
		<?= Alert::widget() ?>
	</div>
	<div class="card menu">
		<div class="card-body">
			<?= Html::a('<i class="far fa-address-card"></i> Informações pessoais', ['perfil/update'], ['class' => 'menu-link active']) ?>
			<?= Html::a('<i class="fas fa-cart-shopping"></i> Histórico de Compras', ['fatura/index'], ['class' => 'menu-link']) ?>
		</div>
	</div>
</div>