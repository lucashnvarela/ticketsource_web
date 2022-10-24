<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\FaturaBilhete $model */

$this->title = 'Update Fatura Bilhete: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fatura Bilhetes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fatura-bilhete-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
