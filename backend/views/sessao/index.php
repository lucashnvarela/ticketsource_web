<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $calendarModel common\models\Calendar */
/** @var $calendarDate array */

$this->registerCssFile("@web/css/sessao/index.css");

$this->title = 'Calendario de Eventos';
?>

<div class="sessao-index container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><i class="fa-regular fa-calendar-days"></i> <?= $this->title ?></h5>
            <div class="calendar-tools">
                <?php
                echo Html::a(
                    'HOJE',
                    ['sessao/index', 'month' => date('n'), 'year' => date('Y')],
                    ['class' => 'btn-today ripple']
                );
                $previousMonth = $calendarModel->getPreviousMonth($calendarDate['month'], $calendarDate['year']);
                echo Html::a(
                    '<i class="fa-solid fa-chevron-left"></i>',
                    ['sessao/index', 'month' => $previousMonth['month'], 'year' => $previousMonth['year']],
                    ['class' => 'btn-previous-month ripple']
                );
                $nextMonth = $calendarModel->getNextMonth($calendarDate['month'], $calendarDate['year']);
                echo Html::a(
                    '<i class="fa-solid fa-chevron-right"></i>',
                    ['sessao/index', 'month' => $nextMonth['month'], 'year' => $nextMonth['year']],
                    ['class' => 'btn-next-month ripple']
                );
                ?>
                <h5 class="calendar-date"><?= $calendarModel->getMonth($calendarDate['month']) . ' ' . $calendarDate['year'] ?></h5>
            </div>
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
                        <tr>
                            <?php
                            foreach ($calendarModel->getWeeks($calendarDate['month']) as $week) {
                                foreach ($week as $day) {
                                    if ($day == date('d') && $calendarDate['month'] == date('n')) $dayClass = 'day today';
                                    else $dayClass = 'day';
                                    if ($day != null) {
                                        echo
                                        '<td><a href="' .
                                            Url::toRoute(['sessao/view', 'date' => $calendarDate['year'] . '-' . $calendarDate['month'] . '-' . $day]) .
                                            '" class="td-container">
                                                <div class="day-container">
                                                    <div class="' . $dayClass . '">' . $day . '</div>
                                                </div>
                                                <div class="event-container">';
                                        $sessaoElements = $calendarModel->getSessions($db_sessao, $calendarDate['year'] . '-' . $calendarDate['month'] . '-' . $day);
                                        if ($sessaoElements != null) foreach ($sessaoElements as $el) echo $el;
                                        echo '</div>
                                            </a></td>';
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