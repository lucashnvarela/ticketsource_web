<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\FaturaBilhete $model */

$this->title = 'Create Fatura Bilhete';
$this->params['breadcrumbs'][] = ['label' => 'Fatura Bilhetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-bilhete-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
