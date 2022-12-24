<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $model_search common\models\*Search */
/** @var $form yii\widgets\ActiveForm */

$this->registerCssFile("@web/css/layouts/search.css");
?>

<div class="layout-search">
	<?php
	$form = ActiveForm::begin(['method' => 'get']);

	echo $form->field(
		$model_search,
		'searchstring',
		['template' => '<div class="search-bar input-group">{input}' .
			Html::submitButton('<ion-icon name="search-outline"></ion-icon>', ['class' => 'btn-search']) .
			'</span></div>',]
	)->textInput(['placeholder' => 'Pesquisar']);

	ActiveForm::end(); ?>
</div>