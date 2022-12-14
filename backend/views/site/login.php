<?php

/** @var $this yii\web\View */
/** @var $form yii\bootstrap5\ActiveForm */
/** @var $model_login common\models\LoginForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->registerCssFile("@web/css/site/login.css");

$this->title = 'Iniciar sessão';
?>

<div class="login-page">
	<div class="card login-form">
		<div class="card-header">
			<h5 id="title"><?= $this->title ?></h5>
			<p id="subtitle">Por favor preencha os seguintes campos</p>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
		<div class="card-body">
			<?php
			echo $form->field($model_login, 'username', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Nome de utilizador :')
				->textInput();

			echo $form->field($model_login, 'password', [
				'options' => ['class' => 'input-group has-feedback'],
				'template' => '<div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}'
			])
				->label('Palavra-passe :')
				->passwordInput();
			?>
		</div>
		<div class="card-footer">
			<?= Html::submitButton('<ion-icon name="log-in-outline"></ion-icon> Login', ['class' => 'btn-default ripple', 'name' => 'login-button']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>