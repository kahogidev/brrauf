<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductItem */
/* @var $products array */

$this->title = 'Yangi variant qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Mahsulot variantlari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'products' => $products,
]) ?>