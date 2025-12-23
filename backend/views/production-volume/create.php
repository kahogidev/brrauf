<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductionVolume */

$this->title = 'Yangi hajm qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Ishlab chiqarish hajmi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>