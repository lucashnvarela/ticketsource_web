<?php

/** @var $this yii\web\View */
/** @var $model_search frontend\models\FavoritoSearch */
/** @var $db_favorito frontend\models\Favorito[] */
/** @var $model_favortio frontend\models\Favorito */

use common\models\Evento;
use yii\helpers\Html;

$this->registerCssFile("@web/css/favorito/index.css");

$this->title = 'Favoritos';
?>

<div class="favorito-index">
	<div class="card">
		<div class="card-header">
			<div class="header">
				<h5 class="title">
					<ion-icon name="heart-outline"></ion-icon> <?= $this->title ?>
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
					['favorito/index'],
					['class' => 'btn-category all' . ($param_filter == null ? ' active' : null)]
				);

				foreach (Evento::getCategoriaList() as $category) {
					echo Html::a(
						$category,
						['favorito/index', 'filter' => $category],
						['class' => 'btn-category ' . Evento::getCategoriaBtnClass($category) . ($param_filter == $category ? ' active' : null)]
					);
				} ?>
			</div>
		</div>
		<div class="card-body">
			<?php
			if (!empty($db_favorito)) :
				foreach ($db_favorito as $model_favorito) {
					echo $this->render('@frontend/views/evento/form', [
						'model_evento' => $model_favorito->evento,
					]);
				}
			else : ?>
				<div class="no-data">
					<p>Não existem eventos <?= !is_null($param_filter) ? 'de ' . lcfirst($param_filter) : null ?> favoritos</p>
				</div>
			<?php
			endif ?>
		</div>
	</div>
</div>