<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\models\Product;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

$base_url = Yii::getAlias("@web");
$meta = Product::find()->where(['id' => 1]);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <link rel="icon" href="<?= Yii::getAlias('@web') ?>/template/img/favicon.ico" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->registerMetaTag(Yii::$app->params['og_title'], 'og_title');
    $this->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
    $this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
    $this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
    ?>
    <?php $this->head() ?>
</head>
<?php
Modal::begin([
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<body data-spy="scroll" data-target="#navbar" data-offset="72" class="position-relative">
    <?php $this->beginBody() ?>
    <?= $this->render("top_nav", ['base_url' => $base_url]) ?>
    <header id="header">
        <?= $this->render("header", ['base_url' => $base_url]) ?>
    </header>
    <div class="header-space"></div>
    <?= $this->render("modal", ['base_url' => $base_url]) ?>

    <?= $content ?>

    <?= $this->render("footer", ['base_url' => $base_url]) ?>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage(); ?>

<?php
$script = <<< JS

    JS;
$this->registerJs($script);
