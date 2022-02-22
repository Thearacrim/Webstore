<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

$base_url = Yii::getAlias("@web");

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <?= $this->render("top_nav", ['base_url' => $base_url]) ?>

    <?= $this->render("header", ['base_url' => $base_url]) ?>

    <?= $this->render("modal", ['base_url' => $base_url]) ?>

    <?= $content ?>

    <?= $this->render("footer", ['base_url' => $base_url]) ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
