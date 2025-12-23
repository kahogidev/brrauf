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
    "css/bootstrap.min.css",
    "css/style.css",

    "images/favicon.png",
    "images/favicon.png",
    ];
    public $js = [
        "cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js",
"js/popper.min.js",
"js/bootstrap.min.js",
"js/jquery.fancybox.js",
"js/slick.min.js",
"js/slick-animation.min.js",
"js/wow.js",
"js/appear.js",
"js/mixitup.js",
"js/flatpickr.js",
"js/swiper.min.js",
"js/gsap.min.js",
"js/ScrollTrigger.min.js",
"js/SplitText.min.js",
"js/splitType.js",
"js/script.js",
"js/script-gsap.js",
        "https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015",
        'background-color.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
