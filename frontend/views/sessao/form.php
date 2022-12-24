<?php

use yii\helpers\Url;

use function PHPUnit\Framework\equalTo;

/** @var $this yii\web\View */
/** @var $model_sessao common\models\Sessao */

$this->registerCssFile("@web/css/sessao/form.css");

$sessao_mes = datefmt_format(
	datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "MMM"),
	strtotime($model_sessao->data)
);
$sessao_dia = datefmt_format(
	datefmt_create('pt_PT', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Lisbon', IntlDateFormatter::GREGORIAN, "E"),
	strtotime($model_sessao->data)
);
?>

<li>
	<a href=<?= Url::to(['sessao/view', 'id' => $model_sessao->id]) ?>>
		<div class="date">
			<p id="month"><?= substr($sessao_mes, 0, -1) ?></p>
			<p id="day"><?= date('d', strtotime($model_sessao->data)) ?></p>
			<p id="weekday"><?= substr($sessao_dia, 0, $sessao_dia != 'sábado' ? 3 : 4) ?></p>
		</div>

		<div class="detalhes">
			<p><span>Localização : </span><?= $model_sessao->localizacao ?></p>
			<p><span>Bilhetes disponíveis : </span> <?= $model_sessao->countLugaresDisponiveis() . ' / ' . $model_sessao->numero_lugares . '</p>' ?></p>
		</div>

		<p><?= number_format($model_sessao->preco, 2, ',', ' ') . "€" ?></p>
	</a>
	<?php if ($model_sessao->countLugaresDisponiveis() == 0) : ?>
		<div class="blocker">
			<h6>Esgotado</h6>
		</div>
	<?php endif ?>
</li>