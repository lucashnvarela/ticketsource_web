<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model_fatura frontend\models\Fatura */

$this->registerCssFile("@web/css/fatura/index.css");

$this->title = 'Histórico de compras';
?>

<div class="fatura-index">
	<div class="card">
		<div class="card-header">
			<h5 id="title">
				<ion-icon name="receipt-outline"></ion-icon> <?= $this->title ?>
			</h5>
			<div class="header-actions">
				<?= $this->render('@backend/views/layouts/search', ['model_search' => $model_search]) ?>
			</div>
		</div>

		<div class="card-body">
			<?php
			if (!empty($db_fatura)) { ?>
				<div class="table-border">
					<table>
						<thead>
							<tr>
								<th class="th-id">#</th>
								<th class="th-data">Data da compra</th>
								<th class="th-total">Total</th>
								<th class="th-actions">Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($db_fatura as $model_fatura) { ?>
								<tr>
									<td class="td-id">
										<p><?= $model_fatura->id ?></p>
									</td>
									<td class="td-data">
										<p>
											<?php
											$date = new DateTime("$model_fatura->data");
											echo $date->format('d-m-Y');
											?>
										</p>
									</td>
									<td class="td-total">
										<p><?= number_format($model_fatura->total, 2, ',', ' ') . 	"€" ?></p>
									</td>
									<td class="td-actions">
										<?php
										echo Html::a(
											'<ion-icon name="ticket-outline"></ion-icon> Bilhetes',
											['fatura/view', 'id' => $model_fatura->id],
											['class' => 'btn-default']
										);
										echo Html::a(
											'<ion-icon name="card-outline"></ion-icon> Pagamento',
											['pagamento/view', 'id' => $model_fatura->pagamento->id],
											['class' => 'btn-default']
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
					<p>Não existem compras registadas</p>
				</div>
			<?php } ?>
		</div>
		<div class="card-footer">
		</div>

		<div class="menu">
			<?= Html::a('<ion-icon name="person-circle-outline"></ion-icon> Informações pessoais', ['perfil/update'], ['class' => 'btn-default']) ?>
			<?= Html::a('<ion-icon name="receipt-outline"></ion-icon> Histórico de compras', ['fatura/index'], ['class' => 'btn-default active']) ?>
		</div>
	</div>
</div>