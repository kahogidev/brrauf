<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Portfolio */

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
                        <div>
                            <h4 class="mb-1"><?= Html::encode($model->title_uz) ?></h4>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary-subtle text-primary-emphasis">
                                    <?= Html::encode($model->company_name_uz) ?>
                                </span>
                                <?php if ($model->project_date): ?>
                                    <span class="text-muted fs-14">
                                        <i class="ti ti-calendar me-1"></i>
                                        <?= Yii::$app->formatter->asDate($model->project_date) ?>
                                    </span>
                                <?php endif; ?>
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

                    <!-- Logo -->
                    <?php if ($model->company_logo): ?>
                        <div class="mb-4">
                            <h6 class="mb-3 fs-16 fw-bold">Kompaniya logosi</h6>
                            <div class="border rounded p-3 d-inline-block">
                                <img src="/<?= $model->company_logo ?>" style="max-height: 100px;" alt="Logo">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Ma'lumotlar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">O'zbekcha</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Kompaniya:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->company_name_uz) ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="text-body mb-1">Sarlavha:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->title_uz) ?></p>
                            </div>
                            <?php if ($model->description_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Qisqa tavsif:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_uz)) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->content_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Batafsil matn:</p>
                                    <div class="text-dark"><?= $model->content_uz ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">Русский</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Компания:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->company_name_ru) ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="text-body mb-1">Заголовок:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->title_ru) ?></p>
                            </div>
                            <?php if ($model->description_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Краткое описание:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_ru)) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($model->content_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Подробный текст:</p>
                                    <div class="text-dark"><?= $model->content_ru ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Rasmlar -->
                    <?php if (!empty($model->getImagesArray())): ?>
                        <div class="mb-4">
                            <h6 class="mb-3 fs-16 fw-bold">Rasmlar</h6>
                            <div class="row">
                                <?php foreach ($model->getImagesArray() as $image): ?>
                                    <div class="col-md-3 mb-3">
                                        <div class="border rounded p-2">
                                            <img src="/<?= $image ?>" class="img-fluid rounded" alt="Rasm">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Videolar -->
                    <?php if (!empty($model->getVideosArray())): ?>
                        <div class="mb-4">
                            <h6 class="mb-3 fs-16 fw-bold">Videolar</h6>
                            <div class="list-group">
                                <?php foreach ($model->getVideosArray() as $index => $video): ?>
                                    <a href="<?= Html::encode($video) ?>" target="_blank" class="list-group-item list-group-item-action">
                                        <i class="ti ti-video me-2"></i>Video <?= $index + 1 ?>: <?= Html::encode($video) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
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
                                'confirm' => 'Rostdan ham bu portfolio yozuvini o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>