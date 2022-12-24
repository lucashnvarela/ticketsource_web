<?php

namespace common\models;

use yii\helpers\Html;
use common\models\Evento;
use common\models\Sessao;

/**
 * This is the model class "calendar".
 *
 * @property string $day
 * @property string $month
 * @property string $year
 * @property string $filter
 */
class Calendar {

	public string|null $day;
	public string $month;
	public string $year;
	public string|null $filter;

	/**
	 * Define o calendário
	 * @param int $month
	 * @param int $year
	 * @param string $filter
	 */
	public function setCalendar($month, $year, $filter): void {
		$this->month = $month;
		$this->year = $year;
		$this->filter = $filter;
	}

	/**
	 * Retorna true se for o dia de hojo, false caso contrário
	 * @return bool
	 */
	public function isToday(): bool {
		if ($this->day == date('d') and $this->month == date('n') and $this->year == date('Y')) return true;
		else return false;
	}

	/**
	 * Retorna o primeiro dia da semana de um mês
	 * @param int $month Mês
	 * @return int
	 */
	public function getFirstWeekday(int $month): int {
		return intval(date('N', strtotime('01-' . $month . '-' . $this->year))) - 1;
	}

	/**
	 * Retorna o número de dias de um mês
	 * @param int $month Mês
	 * @return int
	 */
	public function getMonthDays(int $month): int {
		return intval(date('t', strtotime('01-' . $month . '-' . $this->year)));
	}

	/**
	 * Retorna o nome de um mês
	 * @param int $month Mês
	 * @return string
	 */
	public function getMonth(int $month): string {
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
	 * Retorna os dias de cada semana de um mês
	 * @param int $month Mês
	 * @return array
	 */
	public function getWeeks(int $month): array {
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
	 * Retorna o mês anterior
	 * @return array
	 */
	public function getNextMonth(): array {
		if ($this->month == 12) return ['month' => '1', 'year' => strval($this->year + 1)];
		else return ['month' => strval($this->month + 1), 'year' => $this->year];
	}

	/**
	 * Retorna o mês seguinte
	 * @return array
	 */
	public function getPreviousMonth(): array {
		if ($this->month == 1) return ['month' => '12', 'year' => strval($this->year - 1)];
		else return ['month' => strval($this->month - 1), 'year' => $this->year];
	}

	/**
	 * Retorna uma lista com cada categoria de evento com a ação de filtrar
	 * @return array
	 */
	public function getCalendarFilters(): array {
		$filterList = array();

		$filterList[] = Html::a(
			'Todos',
			['sessao/index', 'month' => $this->month, 'year' => $this->year],
			['class' => 'btn-category all' . ($this->filter == null ? ' active' : null)]
		);

		foreach (Evento::getCategoriaList() as $category) {
			$filterList[] = Html::a(
				$category,
				['sessao/index', 'month' => $this->month, 'year' => $this->year, 'filter' => $category],
				['class' => 'btn-category ' . Evento::getCategoriaBtnClass($category) . ($this->filter == $category ? ' active' : null)]
			);
		}

		return $filterList;
	}

	/**
	 * Retorna as sessoes de uma data
	 * @return array|null
	 */
	public function getSessions(): ?array {
		$date = date('Y-m-d', strtotime($this->year . '-' . $this->month . '-' . $this->day));
		$db_sessao = Sessao::find()
			->where(
				[
					'month(data)' => date('m', strtotime($date)),
					'year(data)' => date('Y', strtotime($date)),
				]
			)->all();

		if (!empty($db_sessao)) {
			$sessaoList = array();

			$i = 0;
			foreach ($db_sessao as $sessao) {
				if ($date == $sessao->data and ($this->filter == $sessao->evento->categoria or $this->filter == null)) {

					$sessaoList[] =
						'<p class="btn-event ' . Evento::getCategoriaBtnClass($sessao->evento->categoria) . '">' .
						$sessao->evento->titulo .
						'</p>';
					$i++;
					if ($i > 5) break;
				}
			}

			return $sessaoList;
		}

		return null;
	}
}
