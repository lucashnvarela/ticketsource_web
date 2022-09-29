<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>

<style>
    .site-error {
        margin-top: 10% !important
    }

    p:first-of-type {
        margin-bottom: 0 !important;
    }
</style>

<div class="site-error">

    <div class="col-6 offset-3 alert alert-danger shadow-sm">
        <div class="text-center">
            <h2>Page not found</h2>
            <p>The requested URL was not found on this server.</p>
            <p>Please contact us if you think this is a server error. Thank you.</p>

            <?= Html::a('Go to home page', ['/site/index'], ['class' => 'btn btn-dark']) ?>

        </div>
    </div>

</div>