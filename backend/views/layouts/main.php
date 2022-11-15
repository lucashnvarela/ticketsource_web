<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;
use common\widgets\Alert;

//import font awesome
$this->registerJsFile('https://kit.fontawesome.com/af38e31d5d.js');

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

<?= $this->render('navbar') ?>

<body>
	<?php $this->beginBody() ?>

	<div class="alert-container">
		<?= Alert::widget() ?>
	</div>

	<main role="main">
		<?= $content ?>
	</main>

	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>