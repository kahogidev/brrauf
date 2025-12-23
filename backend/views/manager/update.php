<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Manager */

$this->title = 'Tahrirlash: ' . $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Menegerlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>