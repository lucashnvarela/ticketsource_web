<?php

use yii\helpers\Html;
use common\models\Evento;

use function PHPUnit\Framework\isNull;

/** @var $this yii\web\View */
/** @var $model_sessao common\models\Sessao */

$this->registerCssFile("@web/css/sessao/view.css");

$this->title = 'Lista de Sessões';
?>

<div class="view-page">
	<div class="card">
		<div class="card-header">
			<h5 id="title">
				<ion-icon name="calendar-outline"></ion-icon> <?= $this->title ?>
			</h5>
			<div class="header-actions">
				<?php
				if (!is_null(Yii::$app->request->get('id_evento'))) {
					echo Html::a(
						'<ion-icon name="add-outline"></ion-icon> Registar Sessão',
						['sessao/create', 'id_evento' => Yii::$app->request->get('id_evento')],
						['class' => 'btn-default']
					);
				}
				echo $this->render('@backend/views/layouts/search', ['model_search' => $model_search]);
				?>
			</div>
		</div>
		<div class="card-body">
			<?php
			$date_format = datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "d 'de' MMMM, YYYY");
			$sessao_data = explode(' de ', datefmt_format($date_format, strtotime(Yii::$app->request->get('data'))));

			if (is_null(Yii::$app->request->get('id_evento'))) { ?>
				<h6 id="subtitle">Data : <span><?= $sessao_data[0] . ' de ' . ucfirst($sessao_data[1]) ?></span></h6>
			<?php } else { ?>
				<h6 id="subtitle">Evento : <span><?= Evento::findOne(Yii::$app->request->get('id_evento'))->titulo ?></span></h6>
			<?php }

			if (!empty($db_sessao)) { ?>
				<div class="table-border">
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<?php
								if (is_null(Yii::$app->request->get('id_evento'))) { ?>
									<th class="th-evento">Evento</th>
									<th class="th-categoria">Categoria</th>
								<?php } else { ?>
									<th class="th-data">Data</th>
								<?php } ?>
								<th class="th-local">Localização</th>
								<th class="th-bilhetes">Bilhetes disponíveis</th>
								<th class="th-preco">Preço</th>
								<th class="th-actions">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($db_sessao as $model_sessao) : ?>
								<tr>
									<td class="td-id">
										<p><?= $model_sessao->id ?></p>
									</td>
									<?php
									if (is_null(Yii::$app->request->get('id_evento'))) { ?>
										<td class="td-evento">
											<p><?= $model_sessao->evento->titulo ?></p>
										</td>
										<td class="td-categoria">
											<?= '<p class="' . Evento::getCategoriaBtnClass($model_sessao->evento->categoria) . '">' . $model_sessao->evento->categoria . '</p>' ?>
										</td>
									<?php } else { ?>
										<td class="td-data">
											<p><?= date('d-m-Y', strtotime($model_sessao->data)) ?></p>
										</td>
									<?php } ?>
									<td class="td-local">
										<p><?= $model_sessao->localizacao ?></p>
									</td>
									<td class="td-bilhetes">
										<?php
										if ($model_sessao->countLugaresDisponiveis() > 0) :
											echo '<p>' . $model_sessao->countLugaresDisponiveis() . ' / ' . $model_sessao->numero_lugares . '</p>';
										else :
											echo '<p class="esgotado">Esgotado</p>';
										endif;
										?>
									</td>
									<td class="td-preco">
										<p><?= number_format($model_sessao->preco, 2, ',', ' ') . 	"€" ?></p>
									</td>
									<td class="td-actions">
										<?php
										echo Html::a(
											'<ion-icon name="create-outline"></ion-icon> Editar',
											['sessao/update', 'id' => $model_sessao->id],
											['class' => 'btn-default']
										);
										echo Html::a(
											'<ion-icon name="trash-outline"></ion-icon> Eliminar',
											['sessao/delete', 'id' => $model_sessao->id],
											['class' => 'btn-default', 'data' => ['confirm' => 'Tem a certeza que pretende eliminar esta sessão?', 'method' => 'post']]
										);
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php  } else { ?>
				<div class="no-data">
					<p>Não existem sessões registadas</p>
				</div>
			<?php } ?>
		</div>
		<div class="card-footer">
		</div>
	</div>
</div>