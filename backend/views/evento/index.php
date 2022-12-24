<?php

use yii\helpers\Html;
use common\models\Evento;

/** @var $this yii\web\View */
/** @var $db_evento common\models\Evento */

$this->registerCssFile("@web/css/evento/index.css");

$this->title = 'Lista de Eventos';
?>

<div class="index-page">
	<div class="card">
		<div class="card-header">
			<h5 id="title">
				<ion-icon name="today-outline"></ion-icon> <?= $this->title ?>
			</h5>
			<div class="header-actions">
				<?php
				echo Html::a(
					'<ion-icon name="add-outline"></ion-icon> Registar Evento',
					['evento/create'],
					['class' => 'btn-default']
				);
				echo $this->render('@backend/views/layouts/search', ['model_search' => $model_search]);
				?>
			</div>
		</div>
		<div class="card-body">
			<?php
			if (!empty($db_evento)) { ?>
				<div class="table-border">
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<th class="th-titulo">Título</th>
								<th class="th-categoria">Categoria</th>
								<th class="th-actions">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($db_evento as $evento) { ?>
								<tr>
									<td class="td-id">
										<p><?= $evento->id ?></p>
									</td>
									<td class="td-titulo">
										<p><?= $evento->titulo ?></p>
									</td>
									<td class="td-categoria">
										<?= '<p class="' . Evento::getCategoriaBtnClass($evento->categoria) . '">' . $evento->categoria . '</p>' ?>
									</td>
									<td class="td-actions">
										<?php
										echo Html::a(
											'<ion-icon name="calendar-outline"></ion-icon> Sessões',
											['sessao/view', 'id_evento' => $evento->id],
											['class' => 'btn-default']
										);
										echo Html::a(
											'<ion-icon name="create-outline"></ion-icon> Editar',
											['evento/update', 'id' => $evento->id],
											['class' => 'btn-default']
										);
										echo Html::a(
											'<ion-icon name="trash-outline"></ion-icon> Eliminar',
											['evento/delete', 'id' => $evento->id],
											['class' => 'btn-default', 'data' => ['confirm' => 'Tem a certeza que pretende eliminar este evento?', 'method' => 'post']]
										);
										?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			<?php  } else { ?>
				<div class="no-data">
					<p>Não existem eventos registados</p>
				</div>
			<?php } ?>
		</div>
		<div class="card-footer">
		</div>
	</div>
</div>