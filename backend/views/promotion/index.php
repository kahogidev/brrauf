<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aksiyalar';
?>

<div class="content">
    <div class="row">
        <div class="col-lg-12">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                <?= Html::a('<i class="ti ti-plus me-1"></i>Yangi qo\'shish', ['create'], ['class' => 'btn btn-primary']) ?>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Aksiyalar ro'yxati</h4>
                </div>
                <div class="card-body">

                    <?php Pjax::begin(); ?>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Rasm</th>
                                <th>Sarlavha (UZ)</th>
                                <th>Chegirma</th>
                                <th>Boshlanish</th>
                                <th>Tugash</th>
                                <th>Mahsulotlar</th>
                                <th>Tartiblash</th>
                                <th>Status</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($dataProvider->getModels()): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <th scope="row"><?= $dataProvider->pagination->offset + $index + 1 ?></th>
                                        <td>
                                            <?php if ($model->image): ?>
                                                <div class="avatar avatar-md avatar-rounded">
                                                    <img src="/<?= $model->image ?>" alt="rasm">
                                                </div>
                                            <?php else: ?>
                                                <div class="avatar avatar-md avatar-rounded bg-light">
                                                    <i class="ti ti-photo fs-20 text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 fs-14 fw-semibold">
                                                <?= Html::encode($model->title_uz) ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success-emphasis">
                                                <?= $model->discount_percent ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-13">
                                                <?= Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-13">
                                                <?= Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-outline-primary">
                                                <?= count($model->products) ?> ta
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold"><?= $model->sort_order ?></span>
                                        </td>
                                        <td>
                                            <?php if ($model->isActive()): ?>
                                                <span class="badge badge-outline-success">Faol</span>
                                            <?php elseif ($model->status == 1): ?>
                                                <span class="badge badge-outline-warning">Kutilmoqda</span>
                                            <?php else: ?>
                                                <span class="badge badge-outline-danger">Nofaol</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= Html::a('<i class="ti ti-eye"></i>', ['view', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'Ko\'rish',
                                            ]) ?>
                                            <?= Html::a('<i class="ti ti-pencil"></i>', ['update', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'Tahrirlash',
                                            ]) ?>
                                            <?= Html::a('<i class="ti ti-trash"></i>', ['delete', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'O\'chirish',
                                                'data' => [
                                                    'confirm' => 'Rostdan ham bu aksiyani o\'chirmoqchimisiz?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        Ma'lumot topilmadi
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?= \yii\widgets\LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination justify-content-center mt-3'],
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'active',
                        'disabledPageCssClass' => 'disabled',
                        'prevPageLabel' => '<i class="ti ti-chevron-left"></i>',
                        'nextPageLabel' => '<i class="ti ti-chevron-right"></i>',
                    ]) ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>