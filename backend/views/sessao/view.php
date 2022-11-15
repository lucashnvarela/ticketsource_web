<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $db_sessao common\models\Sessao */

$this->registerCssFile("@web/css/sessao/index.css");

$this->title = 'Lista de Sessões';
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
				if ($db_sessao != null) { ?>
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<th class="th-data">Data</th>
								<th class="th-localizacao">Localização</th>
								<th class="th-lugares">Lugares disponíveis</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($db_sessao as $sessao) { ?>
								<tr>

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