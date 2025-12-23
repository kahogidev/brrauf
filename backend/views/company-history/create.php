<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyHistory */

$this->title = 'Yangi tarix qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Kompaniya tarixi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>