<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css =[
    "img/favicon.png",
    "img/apple-icon.png",
    "js/theme-script.js",
    "css/bootstrap.min.css",
    "plugins/tabler-icons/tabler-icons.min.css",
    "plugins/simplebar/simplebar.min.css",
    "plugins/datatables/css/dataTables.bootstrap5.min.css",
	"plugins/daterangepicker/daterangepicker.css",
    "css/style.css",
        ];
    public $js = [
        "js/jquery-3.7.1.min.js",
    "js/bootstrap.bundle.min.js",
	"plugins/simplebar/simplebar.min.js",
    "plugins/datatables/js/jquery.dataTables.min.js" ,
    "plugins/datatables/js/dataTables.bootstrap5.min.js",
	"js/moment.min.js" ,
	"plugins/daterangepicker/daterangepicker.js",
	"plugins/apexchart/apexcharts.min.js",
	"plugins/apexchart/chart-data.js",
	"json/deals-project.js" ,
    "js/script.js",
"cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
