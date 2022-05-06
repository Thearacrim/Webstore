<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SwupAsset extends AssetBundle
{
    public $sourcePath = "@npm/swup";
    // public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'swup.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        SwupAsset::class
    ];
}
