<?php

/** @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap5\Carousel;
use common\models\Evento;

$this->registerCssFile("@web/css/site/index.css");

$this->title = Yii::$app->name;
?>

<div class="site-index">
	<?= Carousel::widget(['items' => $carousel_items]) ?>

	<div class="card">
		<div class="card-header">
			<h4 class="title">Novidades</h4>
			<?= Html::a(
				'VER MAIS',
				['evento/index'],
				['class' => 'btn-seemore ripple']
			); ?>
		</div>
		<div class="card-body">
			<?php
			foreach ($db_eventoNovidades as $evento) {
				echo $this->render('@frontend/views/evento/form', [
					'model_evento' => $evento,
				]);
			} ?>
		</div>
	</div>

	<?php
	foreach (Evento::getCategoriaList() as $categoria) {
		if (!empty($db_evento[$categoria]) and count($db_evento[$categoria]) >= 5) { ?>
			<div class="card">
				<div class="card-header">
					<h4 class="title"><?= $categoria ?></h4>
					<?= Html::a(
						'VER MAIS',
						['evento/index', 'filter' => $categoria],
						['class' => 'btn-seemore ripple']
					); ?>
				</div>
				<div class="card-body">
					<?php
					foreach ($db_evento[$categoria] as $evento) {
						echo $this->render('@frontend/views/evento/form', [
							'model_evento' => $evento,
						]);
					} ?>
				</div>
			</div>
	<?php }
	} ?>
</div>