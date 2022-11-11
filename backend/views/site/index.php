<?php

/** @var $this yii\web\View */
/** @var $nEventos common\models\Evento */
/** @var $nSessoes common\models\Sessao */
/** @var $nBilhetes common\models\Bilhete */
/** @var $tRendimentos frontend\models\FaturaBilhete */

$this->registerCssFile("@web/css/site/index.css");

$this->title = 'Dashboard';
?>

<div class="dashboard-page">
    <div class="dashboard-row">
        <div class="card info-form">
            <div class="card-icon">
                <span><i class="fas fa-calendar-day fa-lg"></i></span>
            </div>
            <div class="card-body">
                <h4>№ de Eventos</h4>
                <h4><?= $nEventos ?></h4>
            </div>
        </div>
        <div class="card info-form">
            <div class="card-icon">
                <span><i class="far fa-calendar-days fa-lg"></i></span>
            </div>
            <div class="card-body">
                <h4>№ de Sessões</h4>
                <h4><?= $nSessoes ?></h4>
            </div>
        </div>
        <div class="card info-form">
            <div class="card-icon">
                <span><i class="fas fa-ticket fa-lg"></i></span>
            </div>
            <div class="card-body">
                <h4>№ de Bilhetes</h4>
                <h4><?= $nBilhetes ?></h4>
            </div>
        </div>
        <div class="card info-form">
            <div class="card-icon">
                <span><i class="far fa-credit-card fa-lg"></i></span>
            </div>
            <div class="card-body">
                <h4>Rendimentos</h4>
                <h4><?= $tRendimentos ?><span>€</span></h4>
            </div>
        </div>
    </div>
</div>