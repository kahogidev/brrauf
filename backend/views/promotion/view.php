<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Promotion */

$this->title = $model->title_uz;
?>

<div class="content pb-0">

    <div class="row">
        <div class="col-lg-10 mx-auto">

            <h6 class="mb-3 fs-14">
                <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Ortga', ['index'], ['class' => '']) ?>
            </h6>

            <div class="card">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex align-items-center justify-content-between border-1 border-bottom pb-3 mb-3">
                        <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                        <div>
                            <?php if ($model->isActive()): ?>
                                <span class="badge bg-success-subtle text-success-emphasis">Faol</span>
                            <?php elseif ($model->status == 1): ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis">Kutilmoqda</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger-emphasis">Nofaol</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Rasm -->
                    <?php if ($model->image): ?>
                        <div class="mb-4 pb-3 border-1 border-bottom">
                            <h6 class="mb-3 fs-16 fw-bold">Rasm</h6>
                            <div class="text-center">
                                <img src="/<?= $model->image ?>" class="img-fluid rounded border" alt="Rasm" style="max-height: 300px;">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Asosiy ma'lumotlar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">O'zbekcha</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Sarlavha:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->title_uz) ?></p>
                            </div>
                            <?php if ($model->description_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Tavsif:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_uz)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">Русский</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Заголовок:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->title_ru) ?></p>
                            </div>
                            <?php if ($model->description_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Описание:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_ru)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Aksiya ma'lumotlari -->
                    <div class="mb-4 pb-3 border-1 border-bottom">
                        <h6 class="mb-3 fs-16 fw-bold">Aksiya ma'lumotlari</h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <p class="text-body mb-1">Chegirma:</p>
                                    <p class="text-dark fw-semibold fs-18">
                                        <span class="badge bg-success-subtle text-success-emphasis fs-16">
                                            <?= $model->discount_percent ?>%
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <p class="text-body mb-1">Boshlanish sanasi:</p>
                                    <p class="text-dark fw-semibold">
                                        <?= Yii::$app->formatter->asDate($model->start_date, 'php:d.m.Y') ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <p class="text-body mb-1">Tugash sanasi:</p>
                                    <p class="text-dark fw-semibold">
                                        <?= Yii::$app->formatter->asDate($model->end_date, 'php:d.m.Y') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mahsulotlar -->
                    <div class="mb-4 pb-3 border-1 border-bottom">
                        <h6 class="mb-3 fs-16 fw-bold">
                            Mahsulotlar
                            <span class="badge bg-primary-subtle text-primary-emphasis ms-2">
                                <?= count($model->products) ?> ta
                            </span>
                        </h6>
                        <?php if ($model->products): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Mahsulot nomi (UZ)</th>
                                        <th>Mahsulot nomi (RU)</th>
                                        <th>Kategoriya</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($model->products as $index => $product): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= Html::encode($product->name_uz) ?></td>
                                            <td><?= Html::encode($product->name_ru) ?></td>
                                            <td>
                                                <?php if (isset($product->category)): ?>
                                                    <span class="badge badge-outline-secondary">
                                                        <?= Html::encode($product->category->name_uz) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Mahsulotlar bog'lanmagan</p>
                        <?php endif; ?>
                    </div>

                    <!-- Qo'shimcha ma'lumotlar -->
                    <div class="row pb-3 mb-3 border-1 border-bottom">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Tartiblash:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= $model->sort_order ?></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Yaratilgan:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Status:</h6>
                                <h6 class="fs-14 fw-semibold text-dark">
                                    <?php if ($model->isActive()): ?>
                                        Faol
                                    <?php elseif ($model->status == 1): ?>
                                        Kutilmoqda
                                    <?php else: ?>
                                        Nofaol
                                    <?php endif; ?>
                                </h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Yangilangan:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Tugmalar -->
                    <div class="text-center d-flex align-items-center justify-content-center gap-2">
                        <?= Html::a('<i class="ti ti-pencil me-1"></i>Tahrirlash', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-primary d-flex align-items-center'
                        ]) ?>
                        <?= Html::a('<i class="ti ti-trash me-1"></i>O\'chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-danger d-flex align-items-center',
                            'data' => [
                                'confirm' => 'Rostdan ham bu aksiyani o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>