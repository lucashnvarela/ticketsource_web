<?php

/** @var yii\web\View $this */

$this->registerCssFile("@web/css/index.css");

\hail812\adminlte3\assets\AdminLteAsset::register($this);

$this->title = 'Dashboard';
?>

<div class="site-index container">
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Utilizadores',
                        'number' => '1,410',
                        'icon' => 'ti-user',
                    ]) ?>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Whislist',
                        'number' => '410',
                        'theme' => 'danger',
                        'icon' => 'ti-heart',
                    ]) ?>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Eventos',
                        'number' => '13,648',
                        'theme' => 'gradient-warning',
                        'icon' => 'ti-ticket',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>