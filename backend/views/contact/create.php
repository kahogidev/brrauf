<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AboutCompany */

$this->title = 'Yangi qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Kontaktlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>