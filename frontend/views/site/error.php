<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

$this->registerCssFile("@web/css/site/error.css");

$this->title = $name;
?>

<div class="error-page">
	<div class="alert alert-danger page-not-found">
		<div>
			<h3><?= $name ?></h3>
			<p>The requested URL was not found on this server.<br>
				Please contact us if you think this is a server error.<br>
				Thank you.</p>
		</div>
	</div>
</div>