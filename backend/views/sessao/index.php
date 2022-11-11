<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $calendarModel common\models\Calendar */
/** @var $calendarDate array */

$this->registerCssFile("@web/css/sessao/index.css");

$this->title = 'Calendario de Sessões';
?>

<div class="index-page">
    <div class="card">
        <div class="card-header">
            <h5 class="title"><i class="far fa-calendar-days"></i> <?= $this->title ?></h5>
            <div class="calendar-tools">
                <?php
                echo Html::a(
                    'HOJE',
                    ['sessao/index', 'month' => date('n'), 'year' => date('Y')],
                    ['class' => 'btn-today ripple']
                );
                $previousMonth = $calendarModel->getPreviousMonth(month: $calendarDate['month'], year: $calendarDate['year']);
                echo Html::a(
                    '<i class="fas fa-chevron-left"></i>',
                    ['sessao/index', 'month' => $previousMonth['month'], 'year' => $previousMonth['year']],
                    ['class' => 'btn-previous-month ripple']
                );
                $nextMonth = $calendarModel->getNextMonth(month: $calendarDate['month'], year: $calendarDate['year']);
                echo Html::a(
                    '<i class="fas fa-chevron-right"></i>',
                    ['sessao/index', 'month' => $nextMonth['month'], 'year' => $nextMonth['year']],
                    ['class' => 'btn-next-month ripple']
                );
                ?>
                <h5 class="calendar-date"><?= $calendarModel->getMonth(month: $calendarDate['month']) . ' ' . $calendarDate['year'] ?></h5>
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
                        <?php
                        foreach ($calendarModel->getWeeks(month: $calendarDate['month']) as $week) {
                            echo '<tr>';

                            foreach ($week as $day) {
                                $todayClass = null;
                                $calendarModel->isToday(day: $day, calendarDate: $calendarDate) ? $todayClass .= ' class="today"' : null;

                                if ($day != null) {
                                    echo
                                    '<td><a href="' .
                                        Url::toRoute(['sessao/view', 'date' => $calendarDate['year'] . '-' . $calendarDate['month'] . '-' . $day]) .
                                        '" class="td-container">
                                                <div class="day-container">
                                                    <div' . $todayClass . '>' . $day . '</div>
                                                </div>
                                                <div class="event-container">';
                                    $sessaoList = $calendarModel->getSessions(db_sessao: $db_sessao, date: $calendarDate['year'] . '-' . $calendarDate['month'] . '-' . $day);
                                    if ($sessaoList != null) foreach ($sessaoList as $el) echo $el;
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