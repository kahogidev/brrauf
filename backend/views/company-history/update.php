<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyHistory */

$this->title = 'Tahrirlash: ' . $model->title_uz . ' (' . $model->year . ')';
$this->params['breadcrumbs'][] = ['label' => 'Kompaniya tarixi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_uz, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>