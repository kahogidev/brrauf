<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Portfolio */

$this->title = 'Tahrirlash: ' . $model->title_uz;
$this->params['breadcrumbs'][] = ['label' => 'Portfolio', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_uz, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>