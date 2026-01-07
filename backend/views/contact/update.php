<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AboutCompany */

$this->title = 'Tahrirlash: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Kontaktlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>