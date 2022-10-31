<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->registerCssFile("@web/css/site/error.css");

$this->title = $name;
?>

<div class="h-100 d-flex flex-column justify-content-center align-items-center">
    <div class="alert alert-danger page-not-found">
        <div class="text-center">
            <h3>Page not found</h3>
            <p>The requested URL was not found on this server.<br>
                Please contact us if you think this is a server error.<br>
                Thank you.</p>

            <?= Html::a('', ['/site/index'], ['class' => 'btn btn-dark rounded-circle ti-home']) ?>
        </div>
    </div>
</div>