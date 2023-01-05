<?php

use yii\helpers\Url;
use backend\models\UploadForm;

/** @var $this yii\web\View */
/** @var $model_evento common\models\Evento */

$this->registerCssFile("@web/css/evento/form.css");
?>

<a href=<?= Url::toRoute(['evento/view', 'id' => $model_evento->id]) ?> name=<?= $model_evento->titulo ?>>
	<div class="card card-evento">
		<div class="card-header">
			<img class="evento-image" src=<?= UploadForm::getImageDir() . $model_evento->nome_pic  ?>>
		</div>
		<div class="card-body">
			<h5 class="evento-title"><?= $model_evento->titulo ?></h5>
		</div>
	</div>
</a>