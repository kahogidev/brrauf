<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Vacancy;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content">

    <h4 class="mb-4"><?= $model->isNewRecord ? 'Yangi vakansiya qo\'shish' : 'Vakansiyani tahrirlash' ?></h4>

    <div class="row">
        <div class="col-lg-10 mx-auto">

            <div class="mb-3">
                <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Ortga', ['index'], ['class' => 'd-inline-flex align-items-center fw-medium']) ?>
            </div>

            <div class="card mb-0">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lavozim nomi (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lavozim nomi (Ruscha)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tavsif (O'zbekcha)</label>
                                <?= $form->field($model, 'description_uz')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tavsif (Ruscha)</label>
                                <?= $form->field($model, 'description_ru')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Talablar (O'zbekcha)</label>
                                <?= $form->field($model, 'requirements_uz')->textarea(['rows' => 5, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Talablar (Ruscha)</label>
                                <?= $form->field($model, 'requirements_ru')->textarea(['rows' => 5, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Imkoniyatlar (O'zbekcha)</label>
                                <?= $form->field($model, 'benefits_uz')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Imkoniyatlar (Ruscha)</label>
                                <?= $form->field($model, 'benefits_ru')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rasm</label>
                        <?php if (!$model->isNewRecord && $model->image): ?>
                            <div class="mb-2">
                                <img src="/<?= $model->image ?>" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <?php endif; ?>
                        <?= $form->field($model, 'imageFile')->fileInput([
                            'accept' => 'image/*',
                            'class' => 'form-control'
                        ])->label(false) ?>
                        <small class="text-muted">Ruxsat etilgan formatlar: png, jpg, jpeg, gif, webp</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Maosh (dan)</label>
                                <?= $form->field($model, 'salary_from')->textInput([
                                    'type' => 'number',
                                    'class' => 'form-control',
                                    'min' => 0,
                                    'step' => '0.01'
                                ])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Maosh (gacha)</label>
                                <?= $form->field($model, 'salary_to')->textInput([
                                    'type' => 'number',
                                    'class' => 'form-control',
                                    'min' => 0,
                                    'step' => '0.01'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ish turi</label>
                                <?= $form->field($model, 'employment_type')->dropDownList(
                                    Vacancy::getEmploymentTypes(),
                                    ['prompt' => 'Tanlang...', 'class' => 'form-select']
                                )->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Muddat</label>
                                <?= $form->field($model, 'deadline')->textInput([
                                    'type' => 'date',
                                    'class' => 'form-control'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <input type="radio" name="Vacancy[status]" value="1" id="status-active" <?= ($model->isNewRecord || $model->status == 1) ? 'checked' : '' ?>>
                                        <label for="status-active" class="ms-1">Faol</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="Vacancy[status]" value="0" id="status-inactive" <?= (!$model->isNewRecord && $model->status == 0) ? 'checked' : '' ?>>
                                        <label for="status-inactive" class="ms-1">Nofaol</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tartiblash</label>
                                <?= $form->field($model, 'sort_order')->textInput([
                                    'type' => 'number',
                                    'class' => 'form-control',
                                    'value' => $model->isNewRecord ? 0 : $model->sort_order
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <?= Html::a('Bekor qilish', ['index'], ['class' => 'btn btn-light me-3']) ?>
                        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary', 'form' => $form->id]) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>