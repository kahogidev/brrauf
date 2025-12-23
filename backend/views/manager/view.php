<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Manager */

$this->title = $model->full_name;
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
                        <div class="d-flex align-items-center">
                            <?php if ($model->photo): ?>
                                <div class="avatar avatar-xl avatar-rounded me-3">
                                    <img src="/<?= $model->photo ?>" alt="<?= Html::encode($model->full_name) ?>">
                                </div>
                            <?php else: ?>
                                <div class="avatar avatar-xl avatar-rounded bg-primary text-white me-3 d-flex align-items-center justify-content-center">
                                    <span class="fs-24 fw-bold"><?= strtoupper(substr($model->full_name, 0, 1)) ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h4 class="mb-1"><?= Html::encode($model->full_name) ?></h4>
                                <p class="text-muted mb-0"><?= Html::encode($model->position_uz) ?></p>
                            </div>
                        </div>
                        <div>
                            <?php if ($model->status == 1): ?>
                                <span class="badge bg-success-subtle text-success-emphasis">Faol</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger-emphasis">Nofaol</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Ma'lumotlar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">O'zbekcha</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Lavozim:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->position_uz) ?></p>
                            </div>
                            <?php if ($model->bio_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Biografiya:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->bio_uz)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">Русский</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Должность:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->position_ru) ?></p>
                            </div>
                            <?php if ($model->bio_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Биография:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->bio_ru)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
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
                                'confirm' => 'Rostdan ham bu menegerni o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>