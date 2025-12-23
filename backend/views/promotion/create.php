<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Promotion */
/* @var $products array */

$this->title = 'Yangi aksiya qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Aksiyalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'products' => $products,
]) ?>