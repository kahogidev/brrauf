<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Manager */

$this->title = 'Yangi meneger qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Menegerlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>