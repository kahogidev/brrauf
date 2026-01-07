<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ProductAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/product-cart.js', // Cart uchun alohida JS
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}