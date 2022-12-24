<?php

/** @var $this yii\web\View */
/** @var $model_faturabilhete frontend\models\FaturaBilhete */
/** @var $model_bilhete common\models\Bilhete */

$this->registerCssFile("@web/css/fatura_bilhete/form.css");

$model_bilhete = $model_faturabilhete->bilhete;

$sessao_mes = datefmt_format(
	datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "MMM"),
	strtotime($model_bilhete->sessao->data)
);
$sessao_dia = datefmt_format(
	datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "E"),
	strtotime($model_bilhete->sessao->data)
);
?>

<li class="fatura-bilhete">
	<div class="date">
		<p id="month"><?= substr($sessao_mes, 0, -1) ?></p>
		<p id="day"><?= date('d', strtotime($model_bilhete->sessao->data)) ?></p>
		<p id="weekday"><?= substr($sessao_dia, 0, $sessao_dia != 'sábado' ? 3 : 4) ?></p>
	</div>

	<div class="detalhes">
		<p><span>Evento : </span><?= $model_bilhete->sessao->evento->titulo ?></p>
		<p><span>Número do Lugar : </span><?= $model_bilhete->numero_lugar ?></p>
	</div>

	<p><?= number_format($model_faturabilhete->preco, 2, ',', ' ') . 	"€" ?></p>
</li>