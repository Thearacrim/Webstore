<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'template/css/templatemo.css',
        'template/css/custom.css',
        'template/css/fontawesome.min.css',
        'owlcarousel/assets/owl.carousel.min.css',
        'owlcarousel/assets/owl.theme.default.min.css'
    ];
    public $js = [
        'template/js/jquery-migrate-1.2.1.min.js',
        'template/js/bootstrap.bundle.min.js',
        'template/js/templatemo.js',
        'template/js/custom.js',
        'template/js/slick.min.js',
        'template/js/cart.js',
        'owlcarousel/owl.carousel.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
