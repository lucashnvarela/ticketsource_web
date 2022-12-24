<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_evento common\models\Evento */
/** @var $model_upload backend\models\UploadForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/evento/update.css");

$this->title = 'Editar - Evento';
?>

<div class="update-page">
	<div class="card evento-form">
		<div class="card-header">
			<h5 id="title">Editar : <span>Evento</span></h5>
			<p id="subtitle">Por favor preencha os seguintes campos</p>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'form-evento', 'options' => ['enctype' => 'multipart/form-data']]) ?>
		<div class="card-body">
			<div>
				<?php
				echo $form->field($model_evento, 'titulo', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Título :')
					->textInput();

				echo $form->field($model_evento, 'categoria', [
					'options' => ['class' => 'input-group has-feedback'],
					'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
				])
					->label('Categoria :')
					->dropDownList($model_evento->getDropdownList());
				?>
			</div>
			<?php
			echo $form->field($model_upload, 'imageFile', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Imagem do evento :')
				->fileInput(['accept' => 'image/*',]);

			echo $form->field($model_evento, 'descricao', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Descrição :')
				->textarea();
			?>
		</div>
		<div class="card-footer">
			<?= Html::submitButton('<ion-icon name="sync-outline"></ion-icon> Atualizar', ['class' => 'btn-default ripple', 'name' => 'update-button']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>