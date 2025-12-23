<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductItem */
/* @var $products array */

$this->title = 'Tahrirlash: ' . $model->name_uz;
$this->params['breadcrumbs'][] = ['label' => 'Mahsulot variantlari', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_uz, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>

<?= $this->render('_form', [
    'model' => $model,
    'products' => $products,
]) ?>