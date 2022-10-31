<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;

//import font awesome
$this->registerJsFile('https://kit.fontawesome.com/af38e31d5d.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile("@web/css/layouts/main.css");

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <main role="main">
        <?= $content ?>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
