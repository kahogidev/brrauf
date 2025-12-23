<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Partner */

$this->title = $model->brand_name_uz;
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

                    <!-- Logo -->
                    <?php if ($model->logo): ?>
                        <div class="mb-4 pb-3 border-1 border-bottom">
                            <h6 class="mb-3 fs-16 fw-bold">Logo</h6>
                            <div class="text-center">
                                <img src="/<?= $model->logo ?>" class="img-fluid rounded border" alt="Logo" style="max-height: 200px;">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Ma'lumotlar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">O'zbekcha</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Brend nomi:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->brand_name_uz) ?></p>
                            </div>
                            <?php if ($model->description_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Qisqa ma'lumot:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_uz)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">Русский</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Название бренда:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->brand_name_ru) ?></p>
                            </div>
                            <?php if ($model->description_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Краткая информация:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_ru)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Veb-sayt -->
                    <?php if ($model->website): ?>
                        <div class="mb-4 pb-3 border-1 border-bottom">
                            <h6 class="mb-2 fs-14 fw-medium text-body">Veb-sayt:</h6>
                            <p class="mb-0">
                                <a href="<?= $model->website ?>" target="_blank" class="text-primary">
                                    <?= Html::encode($model->website) ?>
                                    <i class="ti ti-external-link ms-1"></i>
                                </a>
                            </p>
                        </div>
                    <?php endif; ?>

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
                                    <?= $model->status == 1 ? 'Faol' : 'Nofaol' ?>
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
                                'confirm' => 'Rostdan ham bu hamkorni o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>