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
        'owlcarousel/assets/owl.theme.default.min.css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css'
    ];
    public $js = [
        'template/js/jquery-migrate-1.2.1.min.js',
        'template/js/bootstrap.bundle.min.js',
        'template/js/templatemo.js',
        'template/js/custom.js',
        'template/js/slick.min.js',
        'template/js/cart.js',
        'owlcarousel/owl.carousel.min.js',
        '//cdn.jsdelivr.net/npm/sweetalert2@11',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js',
        'https://polyfill.io/v3/polyfill.min.js?features=default',
        'https://unpkg.com/aos@2.3.1/dist/aos.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
