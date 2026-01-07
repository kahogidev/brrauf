<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = 'Kontakt sozlamalari';
?>

<div class="content">
    <div class="row">
        <div class="col-lg-12">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                <?= Html::a('<i class="ti ti-eye me-1"></i>Ko\'rish', ['view'], ['class' => 'btn btn-info']) ?>
            </div>

            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <!-- Telefon raqamlar -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefon 1<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'phone1')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => '+998 90 123 45 67'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefon 2</label>
                                <?= $form->field($model, 'phone2')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => '+998 90 123 45 67'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                        <?= $form->field($model, 'email')->textInput([
                            'maxlength' => true,
                            'class' => 'form-control',
                            'placeholder' => 'info@example.com'
                        ])->label(false) ?>
                    </div>

                    <!-- Manzillar -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Manzil 1 (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'address1_uz')->textarea([
                                    'rows' => 3,
                                    'class' => 'form-control'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Manzil 1 (Ruscha)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'address1_ru')->textarea([
                                    'rows' => 3,
                                    'class' => 'form-control'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Manzil 2 (O'zbekcha)</label>
                                <?= $form->field($model, 'address2_uz')->textarea([
                                    'rows' => 3,
                                    'class' => 'form-control'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Manzil 2 (Ruscha)</label>
                                <?= $form->field($model, 'address2_ru')->textarea([
                                    'rows' => 3,
                                    'class' => 'form-control'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Ish vaqti -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ish vaqti (O'zbekcha)</label>
                                <?= $form->field($model, 'working_hours_uz')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'Dush-Juma: 9:00-18:00'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ish vaqti (Ruscha)</label>
                                <?= $form->field($model, 'working_hours_ru')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'Пн-Пт: 9:00-18:00'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Ijtimoiy tarmoqlar -->
                    <h5 class="mb-3">Ijtimoiy tarmoqlar</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-instagram text-danger me-1"></i> Instagram
                                </label>
                                <?= $form->field($model, 'instagram')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'https://instagram.com/username'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-facebook text-primary me-1"></i> Facebook
                                </label>
                                <?= $form->field($model, 'facebook')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'https://facebook.com/username'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-telegram text-info me-1"></i> Telegram
                                </label>
                                <?= $form->field($model, 'telegram')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'https://t.me/username'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-youtube text-danger me-1"></i> YouTube
                                </label>
                                <?= $form->field($model, 'youtube')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'https://youtube.com/channel/...'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-linkedin text-primary me-1"></i> LinkedIn
                                </label>
                                <?= $form->field($model, 'linkedin')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'https://linkedin.com/company/...'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Xarita koordinatalari -->
                    <h5 class="mb-3">Xarita koordinatalari</h5>
                    <p class="text-muted small mb-3">
                        Google Maps dan manzilni tanlang va koordinatalarni shu yerga kiriting.
                        <a href="https://www.google.com/maps" target="_blank" class="text-primary">Google Maps</a>
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Latitude (Kenglik)</label>
                                <?= $form->field($model, 'map_latitude')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => '41.2995'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Longitude (Uzunlik)</label>
                                <?= $form->field($model, 'map_longitude')->textInput([
                                    'maxlength' => true,
                                    'class' => 'form-control',
                                    'placeholder' => '69.2401'
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <?= Html::submitButton('<i class="ti ti-device-floppy me-1"></i>Saqlash', [
                            'class' => 'btn btn-primary'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>