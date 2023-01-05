<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Sessao;

/** @var $this yii\web\View */
/** @var $model_sessao common\models\Sessao */

$this->registerCssFile("@web/css/sessao/view.css");

$date_format = datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "d 'de' MMMM");
$sessao_data = explode(' de ', datefmt_format($date_format, strtotime($model_sessao->data)));

$this->title = 'Sessão - ' . $sessao_data[0] . ' de ' . ucfirst($sessao_data[1]);
?>
<div class="sessao-view">
	<div class="card">
		<div class="card-header">
			<div>
				<h5 id="title"><?= $model_sessao->evento->titulo ?></h5>
				<h6 id="data"><?= $sessao_data[0] . ' de ' . ucfirst($sessao_data[1]) ?></h6>
			</div>
			<p>Selecione o lugar do bilhete que pretende comprar</p>
		</div>
		<?php ActiveForm::begin([
			'action' => ['sessao/view', 'id' => $model_sessao->id],
			'method' => 'post',
		]) ?>
		<div class="card-body">
			<div class="radio-list">
				<table class="table">
					<tr>
						<th></th>
						<?php
						for ($coluna = 1; $coluna <= ceil(count($numeroLugares) / 2); $coluna++)
							echo "<th class='label'>$coluna</th>";
						?>
					</tr>
					<tr>
						<?php
						echo Html::radioList('numero_lugar', null, $numeroLugares, [
							'item' => function ($index, $label, $name, $checked, $value) {
								$model_sessao = Sessao::findOne(Yii::$app->request->get('id'));

								$disabled = $model_sessao->bilhetes[$index]->isIndisponivel() ? 'disabled' : '';
								$column = '';
								$column_order = range('A', 'Z');
								$column_index = 0;

								if ($index == 0)
									$column = "<td class='label'>" . $column_order[$column_index] . "</td>";
								elseif (($index % ceil(count($model_sessao->bilhetes) / 2)) == 0)
									$column = "</tr><tr><td class='label'>" . $column_order[++$column_index] . "</td>";;

								return $column .
									"<td>
										<input type='radio' name='$name' value='$value' $disabled>
										<span class='checkmark'></span>
									</td>";
							}
						]);
						?>
					</tr>
				</table>
			</div>
		</div>
		<div class="card-footer">
			<div class="table-legend">
				<ul>
					<li>
						<span id="active"></span>
						<h6>Disponível</h6>
					</li>
					<li>
						<span id="disabled"></span>
						<h6>Ocupado</h6>
					</li>
					<li>
						<span id="checked"></span>
						<h6>Selecionado</h6>
					</li>
				</ul>
			</div>
			<?= Html::submitButton('<ion-icon name="ticket-outline"></ion-icon> Comprar', ['class' => 'btn-default ripple']) ?>
		</div>
		<?php ActiveForm::end() ?>
	</div>
</div>