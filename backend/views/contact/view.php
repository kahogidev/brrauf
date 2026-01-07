<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = 'Kontakt sozlamalari';
?>

<div class="content">
    <div class="row">
        <div class="col-lg-10 mx-auto">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                <?= Html::a('<i class="ti ti-pencil me-1"></i>Tahrirlash', ['index'], ['class' => 'btn btn-primary']) ?>
            </div>

            <div class="card">
                <div class="card-body">

                    <!-- Telefon va Email -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h6 class="mb-3 fs-16 fw-bold">Aloqa ma'lumotlari</h6>

                            <div class="mb-3">
                                <p class="text-body mb-1">Telefon 1:</p>
                                <p class="text-dark fw-semibold">
                                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $model->phone1) ?>">
                                        <?= Html::encode($model->phone1) ?>
                                    </a>
                                </p>
                            </div>

                            <?php if ($model->phone2): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Telefon 2:</p>
                                    <p class="text-dark fw-semibold">
                                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $model->phone2) ?>">
                                            <?= Html::encode($model->phone2) ?>
                                        </a>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <p class="text-body mb-1">Email:</p>
                                <p class="text-dark fw-semibold">
                                    <a href="mailto:<?= Html::encode($model->email) ?>">
                                        <?= Html::encode($model->email) ?>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <h6 class="mb-3 fs-16 fw-bold">Ish vaqti</h6>

                            <?php if ($model->working_hours_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">O'zbekcha:</p>
                                    <p class="text-dark"><?= Html::encode($model->working_hours_uz) ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ($model->working_hours_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Ruscha:</p>
                                    <p class="text-dark"><?= Html::encode($model->working_hours_ru) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Manzillar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h6 class="mb-3 fs-16 fw-bold">Manzil (O'zbekcha)</h6>

                            <div class="mb-3">
                                <p class="text-body mb-1">Manzil 1:</p>
                                <p class="text-dark"><?= nl2br(Html::encode($model->address1_uz)) ?></p>
                            </div>

                            <?php if ($model->address2_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Manzil 2:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->address2_uz)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-6">
                            <h6 class="mb-3 fs-16 fw-bold">Manzil (Ruscha)</h6>

                            <div class="mb-3">
                                <p class="text-body mb-1">Адрес 1:</p>
                                <p class="text-dark"><?= nl2br(Html::encode($model->address1_ru)) ?></p>
                            </div>

                            <?php if ($model->address2_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Адрес 2:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->address2_ru)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Ijtimoiy tarmoqlar -->
                    <div class="pb-3 border-1 border-bottom mb-4">
                        <h6 class="mb-3 fs-16 fw-bold">Ijtimoiy tarmoqlar</h6>

                        <div class="d-flex flex-wrap gap-3">
                            <?php if ($model->instagram): ?>
                                <a href="<?= Html::encode($model->instagram) ?>" target="_blank" class="btn btn-outline-danger">
                                    <i class="fab fa-instagram me-1"></i> Instagram
                                </a>
                            <?php endif; ?>

                            <?php if ($model->facebook): ?>
                                <a href="<?= Html::encode($model->facebook) ?>" target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook me-1"></i> Facebook
                                </a>
                            <?php endif; ?>

                            <?php if ($model->telegram): ?>
                                <a href="<?= Html::encode($model->telegram) ?>" target="_blank" class="btn btn-outline-info">
                                    <i class="fab fa-telegram me-1"></i> Telegram
                                </a>
                            <?php endif; ?>

                            <?php if ($model->youtube): ?>
                                <a href="<?= Html::encode($model->youtube) ?>" target="_blank" class="btn btn-outline-danger">
                                    <i class="fab fa-youtube me-1"></i> YouTube
                                </a>
                            <?php endif; ?>

                            <?php if ($model->linkedin): ?>
                                <a href="<?= Html::encode($model->linkedin) ?>" target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-linkedin me-1"></i> LinkedIn
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Xarita koordinatalari -->
                    <?php if ($model->map_latitude && $model->map_longitude): ?>
                        <div class="pb-3 mb-3">
                            <h6 class="mb-3 fs-16 fw-bold">Xarita</h6>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="text-body mb-1">Latitude:</p>
                                    <p class="text-dark fw-semibold"><?= Html::encode($model->map_latitude) ?></p>
                                </div>
                                <div class="col-6">
                                    <p class="text-body mb-1">Longitude:</p>
                                    <p class="text-dark fw-semibold"><?= Html::encode($model->map_longitude) ?></p>
                                </div>
                            </div>

                            <iframe
                                width="100%"
                                height="400"
                                frameborder="0"
                                style="border:0"
                                src="https://maps.google.com/maps?q=<?= $model->map_latitude ?>,<?= $model->map_longitude ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            ></iframe>
                        </div>
                    <?php endif; ?>

                    <!-- Yangilangan vaqt -->
                    <div class="text-muted small">
                        <i class="ti ti-clock me-1"></i>
                        Oxirgi yangilanish: <?= Yii::$app->formatter->asDatetime($model->updated_at) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>