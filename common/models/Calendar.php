<?php

namespace common\models;

use yii\helpers\Html;
use common\models\Evento;

class Calendar {
    /**
     * @brief Retorna o primeiro dia da semana de um mês
     * 
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getFirstWeekday(int $month) {
        return intval(date('N', strtotime('01-' . $month . '-' . date('Y')))) - 1;
    }

    /**
     * @brief Retorna o número de dias de um mês
     * 
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getMonthDays(int $month) {
        return intval(date('t', strtotime('01-' . $month . '-' . date('Y'))));
    }

    /**
     * @brief Retorna o nome de um mês
     * 
     * @param int $month
     * @return string
     */
    public function getMonth(int $month) {
        $months = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        return $months[$month];
    }


    /**
     * @brief Retorna os dias de cada semana de um mês
     * 
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getWeeks(int $month) {
        $firstWeekday = $this->getFirstWeekday($month);
        $monthWeeks = array();
        $day = 1;

        while ($day <= $this->getMonthDays($month)) {
            $week = array();
            for ($weekday = 0; $weekday <= 6; $weekday++) {
                if ($monthWeeks != null) {
                    if ($day <= $this->getMonthDays($month)) {
                        $week[$weekday] = $day;
                        $day++;
                    } else $week[$weekday] = null;
                } elseif ($weekday >= $firstWeekday) {
                    $week[$weekday] = $day;
                    $day++;
                } else $week[$weekday] = null;
            }
            $monthWeeks[] = $week;
        }

        return $monthWeeks;
    }

    /**
     * @brief Retorna o mês anterior
     * 
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getNextMonth(int $month, int $year) {
        if ($month == 12) {
            $month = 1;
            $year++;
        } else $month++;

        return ['month' => $month, 'year' => $year];
    }

    /**
     * @brief Retorna o mês seguinte
     * 
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getPreviousMonth(int $month, int $year) {
        if ($month == 1) {
            $month = 12;
            $year--;
        } else $month--;

        return ['month' => $month, 'year' => $year];
    }

    /**
     * @brief Retorna as sessoes de uma data
     * 
     * @param array $db_sessao
     * @param string $date
     * @return array|void
     */
    public function getSessions(array $db_sessao, string $date) {
        $btnClass = ['x1', 'x2', 'x3'];

        if ($db_sessao != null) {
            $date = date('Y-m-d', strtotime($date));
            $sessaoElements = array();

            $i = 0;
            foreach ($db_sessao as $sessaoModel) {
                if ($sessaoModel->data == $date) {
                    $sessaoElements[] = Html::tag(
                        'p',
                        Evento::findOne($sessaoModel->id_evento)->titulo . $sessaoModel->id,
                        ['class' => 'btn-event ' . $btnClass[rand(0, 2)]]
                    );
                    $i++;
                    if ($i > 3) break;
                }
            }

            return $sessaoElements;
        }
    }
}
