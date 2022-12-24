<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $class_calendar common\models\Calendar */

$this->registerCssFile("@web/css/sessao/index.css");

$this->title = 'Calendario de Sessões';
?>

<div class="index-page">
	<div class="card">
		<div class="card-header">
			<h5 class="title">
				<ion-icon name="calendar-outline"></ion-icon> <?= $this->title ?>
			</h5>
			<div class="calendar-tools">
				<?php
				echo Html::a(
					'HOJE',
					['sessao/index', 'month' => date('n'), 'year' => date('Y'), 'filter' => $class_calendar->filter],
					['class' => 'btn-default ripple']
				);
				$previousMonth = $class_calendar->getPreviousMonth();
				echo Html::a(
					'<ion-icon name="chevron-back-outline"></ion-icon>',
					['sessao/index', 'month' => $previousMonth['month'], 'year' => $previousMonth['year'], 'filter' => $class_calendar->filter],
					['class' => 'btn-default ripple']
				);
				$nextMonth = $class_calendar->getNextMonth();
				echo Html::a(
					'<ion-icon name="chevron-forward-outline"></ion-icon>',
					['sessao/index', 'month' => $nextMonth['month'], 'year' => $nextMonth['year'], 'filter' => $class_calendar->filter],
					['class' => 'btn-default ripple']
				);
				?>
				<h5 class="calendar-date"><?= $class_calendar->getMonth(month: $class_calendar->month) . ' ' . $class_calendar->year ?></h5>
			</div>
		</div>
		<div class="calendar-filters">
			<ion-icon name="funnel-outline"></ion-icon>
			<?php foreach ($class_calendar->getCalendarFilters() as $el) echo $el ?>
		</div>
		<div class="card-body">
			<div class="table-border">
				<table>
					<thead>
						<tr>
							<th>Seg</th>
							<th>Ter</th>
							<th>Qua</th>
							<th>Qui</th>
							<th>Sex</th>
							<th>Sáb</th>
							<th>Dom</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($class_calendar->getWeeks(month: $class_calendar->month) as $week) {
							echo '<tr>';

							foreach ($week as $class_calendar->day) {
								$class_calendar->isToday() ? $todayClass = ' class="today"' : $todayClass = null;

								if ($class_calendar->day != null) {
									echo
									'<td><a href="' .
										Url::toRoute([
											'sessao/view',
											'data' => $class_calendar->year . '-' . $class_calendar->month . '-' . $class_calendar->day,
											'filter' => $class_calendar->filter
										]) .
										'" class="td-container">
                                                <div class="day-container">
                                                    <div' . $todayClass . '>' . $class_calendar->day . '</div>
                                                </div>
                                                <div class="event-container">';

									$sessaoList = $class_calendar->getSessions();
									if (!empty($sessaoList)) foreach ($sessaoList as $el) echo $el;

									echo '</div></a></td>';
								} else echo '<td></td>';
							}
							echo '</tr>';
						} ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer">
		</div>
	</div>
</div>