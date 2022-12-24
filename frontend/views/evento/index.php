<?php

/** @var $this yii\web\View */

use common\models\Evento;
use yii\helpers\Html;

$this->registerCssFile("@web/css/evento/index.css");

$this->title = 'Eventos';
?>

<div class="evento-index">
	<div class="card">
		<div class="card-header">
			<div class="header">
				<h5 id="title">
					<ion-icon name="calendar-outline"></ion-icon> <?= $this->title ?>
				</h5>
				<div class="header-actions">
					<?= $this->render('@frontend/views/layouts/search', ['model_search' => $model_search]) ?>
				</div>
			</div>
			<div class="filters">
				<ion-icon name="funnel-outline"></ion-icon>
				<?php
				$param_filter = Yii::$app->request->get('filter');

				echo Html::a(
					'Todos',
					['evento/index'],
					['class' => 'btn-category all' . ($param_filter == null ? ' active' : null)]
				);

				foreach (Evento::getCategoriaList() as $category) {
					echo Html::a(
						$category,
						['evento/index', 'filter' => $category],
						['class' => 'btn-category ' . Evento::getCategoriaBtnClass($category) . ($param_filter == $category ? ' active' : null)]
					);
				} ?>
			</div>
		</div>
		<div class="card-body">
			<?php
			if (!empty($db_evento)) :
				foreach ($db_evento as $evento) {
					echo $this->render('@frontend/views/evento/form', [
						'model_evento' => $evento,
					]);
				}
			else : ?>
				<div class="no-data">
					<p>Não existem eventos <?= !is_null($param_filter) ? 'de ' . lcfirst($param_filter) : null ?> registados</p>
				</div>
			<?php
			endif ?>
		</div>
	</div>
</div>