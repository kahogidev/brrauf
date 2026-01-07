<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

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
                            <?php if ($model->status == 1): ?>
                                <span class="badge bg-success-subtle text-success-emphasis">Faol</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger-emphasis">Nofaol</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Rasm -->
                    <?php if ($model->image): ?>
                        <div class="mb-4 text-center">
                            <img src="/<?= $model->image ?>" class="img-fluid rounded" style="max-height: 300px;" alt="Vakansiya rasmi">
                        </div>
                    <?php endif; ?>

                    <!-- Asosiy ma'lumotlar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">O'zbekcha</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Lavozim nomi:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->title_uz) ?></p>
                            </div>
                            <?php if ($model->description_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Tavsif:</p>
                                    <div class="text-dark"><?= nl2br(Html::encode($model->description_uz)) ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->requirements_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Talablar:</p>
                                    <div class="text-dark"><?= nl2br(Html::encode($model->requirements_uz)) ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->benefits_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Imkoniyatlar:</p>
                                    <div class="text-dark"><?= nl2br(Html::encode($model->benefits_uz)) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">Русский</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Название должности:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->title_ru) ?></p>
                            </div>
                            <?php if ($model->description_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Описание:</p>
                                    <div class="text-dark"><?= nl2br(Html::encode($model->description_ru)) ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->requirements_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Требования:</p>
                                    <div class="text-dark"><?= nl2br(Html::encode($model->requirements_ru)) ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->benefits_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Возможности:</p>
                                    <div class="text-dark"><?= nl2br(Html::encode($model->benefits_ru)) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Qo'shimcha ma'lumotlar -->
                    <div class="row pb-3 mb-3 border-1 border-bottom">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Maosh:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= $model->getFormattedSalary() ?></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Ish turi:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= $model->getEmploymentTypeName() ?></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Muddat:</h6>
                                <h6 class="fs-14 fw-semibold text-dark">
                                    <?= $model->deadline ? Yii::$app->formatter->asDate($model->deadline) : 'Cheksiz' ?>
                                </h6>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Arizalar soni:</h6>
                                <h6 class="fs-14 fw-semibold text-dark">
                                    <?= count($model->applications) ?> ta
                                    <?php if ($model->getNewApplicationsCount() > 0): ?>
                                        <span class="badge bg-success ms-1">+<?= $model->getNewApplicationsCount() ?> yangi</span>
                                    <?php endif; ?>
                                </h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Tartiblash:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= $model->sort_order ?></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Status:</h6>
                                <h6 class="fs-14 fw-semibold text-dark">
                                    <?= $model->status == 1 ? 'Faol' : 'Nofaol' ?>
                                </h6>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Yaratilgan:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Yangilangan:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Tugmalar -->
                    <div class="text-center d-flex align-items-center justify-content-center gap-2">
                        <?= Html::a('<i class="ti ti-file-text me-1"></i>Arizalarni ko\'rish', ['/vacancy-application/index', 'vacancy_id' => $model->id], [
                            'class' => 'btn btn-md btn-info d-flex align-items-center'
                        ]) ?>
                        <?= Html::a('<i class="ti ti-pencil me-1"></i>Tahrirlash', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-primary d-flex align-items-center'
                        ]) ?>
                        <?= Html::a('<i class="ti ti-trash me-1"></i>O\'chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-danger d-flex align-items-center',
                            'data' => [
                                'confirm' => 'Rostdan ham bu vakansiyani o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>