<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VacancyApplication;

/* @var $this yii\web\View */
/* @var $model common\models\VacancyApplication */

$this->title = $model->full_name . ' - Ariza';
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
                            <h4 class="mb-1"><?= Html::encode($model->full_name) ?></h4>
                            <p class="text-muted mb-0">
                                Vakansiya: <strong><?= Html::encode($model->vacancy->title_uz) ?></strong>
                            </p>
                        </div>
                        <div>
                            <span class="badge <?= $model->getStatusBadgeClass() ?> fs-14">
                                <?= $model->getStatusName() ?>
                            </span>
                        </div>
                    </div>

                    <!-- Shaxsiy ma'lumotlar -->
                    <div class="mb-4">
                        <h5 class="mb-3 fs-16 fw-bold">Shaxsiy ma'lumotlar</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <h6 class="fs-14 fw-medium text-body mb-0">To'liq ism:</h6>
                                    <h6 class="fs-14 fw-semibold text-dark mb-0"><?= Html::encode($model->full_name) ?></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <h6 class="fs-14 fw-medium text-body mb-0">Email:</h6>
                                    <h6 class="fs-14 fw-semibold text-dark mb-0">
                                        <a href="mailto:<?= $model->email ?>"><?= Html::encode($model->email) ?></a>
                                    </h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <h6 class="fs-14 fw-medium text-body mb-0">Telefon:</h6>
                                    <h6 class="fs-14 fw-semibold text-dark mb-0">
                                        <a href="tel:<?= $model->phone ?>"><?= Html::encode($model->phone) ?></a>
                                    </h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php if ($model->birth_date): ?>
                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                        <h6 class="fs-14 fw-medium text-body mb-0">Tug'ilgan sana:</h6>
                                        <h6 class="fs-14 fw-semibold text-dark mb-0">
                                            <?= Yii::$app->formatter->asDate($model->birth_date) ?>
                                        </h6>
                                    </div>
                                <?php endif; ?>
                                <?php if ($model->education): ?>
                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                        <h6 class="fs-14 fw-medium text-body mb-0">Ma'lumoti:</h6>
                                        <h6 class="fs-14 fw-semibold text-dark mb-0"><?= Html::encode($model->education) ?></h6>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <h6 class="fs-14 fw-medium text-body mb-0">Yuborilgan sana:</h6>
                                    <h6 class="fs-14 fw-semibold text-dark mb-0">
                                        <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ish tajribasi -->
                    <?php if ($model->experience): ?>
                        <div class="mb-4">
                            <h5 class="mb-3 fs-16 fw-bold">Ish tajribasi</h5>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0"><?= nl2br(Html::encode($model->experience)) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Qo'shimcha ma'lumot -->
                    <?php if ($model->cover_letter): ?>
                        <div class="mb-4">
                            <h5 class="mb-3 fs-16 fw-bold">Qo'shimcha ma'lumot</h5>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0"><?= nl2br(Html::encode($model->cover_letter)) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Resume -->
                    <?php if ($model->resume_file): ?>
                        <div class="mb-4">
                            <h5 class="mb-3 fs-16 fw-bold">Resume (CV)</h5>
                            <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-file-text fs-24 text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-0"><?= basename($model->resume_file) ?></h6>
                                        <small class="text-muted">Resume fayli</small>
                                    </div>
                                </div>
                                <a href="/<?= $model->resume_file ?>" target="_blank" class="btn btn-primary">
                                    <i class="ti ti-download me-1"></i> Yuklash
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Status o'zgartirish -->
                    <div class="mb-4">
                        <h5 class="mb-3 fs-16 fw-bold">Statusni o'zgartirish</h5>
                        <?php $form = ActiveForm::begin(['action' => ['update-status', 'id' => $model->id]]); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'status')->dropDownList(
                                    VacancyApplication::getStatuses(),
                                    ['class' => 'form-select']
                                ) ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <?= Html::submitButton('<i class="ti ti-check me-1"></i>Saqlash', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <!-- Admin izohlar -->
                    <div class="mb-4">
                        <h5 class="mb-3 fs-16 fw-bold">Admin izohlar</h5>
                        <?php $form = ActiveForm::begin(['action' => ['add-note', 'id' => $model->id]]); ?>
                        <?= $form->field($model, 'admin_notes')->textarea([
                            'rows' => 4,
                            'class' => 'form-control',
                            'placeholder' => 'Izoh yozing...'
                        ])->label(false) ?>
                        <div class="text-end">
                            <?= Html::submitButton('<i class="ti ti-check me-1"></i>Izoh qo\'shish', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <!-- Tugmalar -->
                    <div class="text-center d-flex align-items-center justify-content-center gap-2 border-top pt-3">
                        <?= Html::a('<i class="ti ti-mail me-1"></i>Email yuborish', 'mailto:' . $model->email, [
                            'class' => 'btn btn-md btn-info d-flex align-items-center'
                        ]) ?>
                        <?= Html::a('<i class="ti ti-phone me-1"></i>Qo\'ng\'iroq qilish', 'tel:' . $model->phone, [
                            'class' => 'btn btn-md btn-success d-flex align-items-center'
                        ]) ?>
                        <?= Html::a('<i class="ti ti-trash me-1"></i>O\'chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-danger d-flex align-items-center',
                            'data' => [
                                'confirm' => 'Rostdan ham bu arizani o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>