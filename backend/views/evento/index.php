<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $db_evento common\models\Evento */

$this->registerCssFile("@web/css/evento/index.css");

$this->title = 'Lista de Eventos';
?>

<div class="index-page">
	<div class="card">
		<div class="card-header">
			<h5 class="title"><i class="fas fa-users"></i> <?= $this->title ?> </h5>
			<div class="search-bar input-group">
				<input type="search" class="form-control" placeholder="Pesquisar" />
				<a class="btn-search">
					<i class="fas fa-search"></i>
				</a>
			</div>
		</div>

		<div class="card-body">
			<div class="table-border">
				<?php
				if ($db_evento != null) { ?>
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<th class="th-titulo">Titulo</th>
								<th class="th-tipo">Tipo</th>
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
									<td class="td-tipo">
										<p><?= $evento->tipo ?></p>
									</td>
									<td class="td-actions">
										<?php
										echo Html::a(
											'<i class="fas fa-edit"></i> Editar',
											['evento/update', 'id' => $evento->id],
											['class' => 'table-link']
										);
										echo Html::a(
											'<i class="fas fas fa-trash-alt"></i> Eliminar',
											['evento/delete', 'id' => $evento->id],
											['class' => 'table-link']
										);
										?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php  } ?>
			</div>
		</div>
		<div class="card-footer">
		</div>
	</div>
</div>