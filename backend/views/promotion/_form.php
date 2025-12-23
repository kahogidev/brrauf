<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Promotion */
/* @var $products array */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="row">
        <div class="col-lg-10 mx-auto">

            <div class="mb-3">
                <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Ortga', ['index'], ['class' => 'd-inline-flex align-items-center fw-medium']) ?>
            </div>

            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="mb-4"><?= $model->isNewRecord ? 'Yangi aksiya qo\'shish' : 'Aksiyani tahrirlash' ?></h4>

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <!-- Sarlavhalar -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sarlavha (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sarlavha (Ruscha)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Tavsiflar -->
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

                    <!-- Chegirma va Sanalar -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Chegirma (%)<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'discount_percent')->textInput([
                                    'type' => 'number',
                                    'class' => 'form-control',
                                    'min' => 0,
                                    'max' => 100,
                                    'step' => '0.01'
                                ])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Boshlanish sanasi<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'start_date')->input('date', ['class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tugash sanasi<span class="text-danger ms-1">*</span></label>
                                <?= $form->field($model, 'end_date')->input('date', ['class' => 'form-control'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Mahsulotlar -->
                    <div class="mb-3">
                        <label class="form-label">Mahsulotlar<span class="text-danger ms-1">*</span></label>
                        <?= $form->field($model, 'product_ids')->dropDownList($products, [
                            'multiple' => true,
                            'class' => 'form-select',
                            'size' => 8,
                        ])->label(false) ?>
                        <small class="text-muted">Ko'p mahsulotlarni tanlash uchun Ctrl yoki Shift tugmasini bosing</small>
                    </div>

                    <!-- Rasm yuklash -->
                    <div class="mb-3">
                        <label class="form-label">Rasm</label>

                        <?php if (!$model->isNewRecord && $model->image): ?>
                            <div class="mb-3 existing-image">
                                <label class="form-label d-block">Mavjud rasm:</label>
                                <div class="border rounded p-3 d-inline-block position-relative">
                                    <img src="/<?= $model->image ?>" alt="Rasm" style="max-height: 150px; max-width: 250px;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 8px; right: 8px;" id="delete-image">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                                <p class="text-muted fs-13 mt-2 mb-0">Yangi rasm yuklasangiz, eski rasm o'chiriladi</p>
                            </div>
                        <?php endif; ?>

                        <div class="file-upload drag-file w-100 d-flex bg-light border shadow align-items-center justify-content-center flex-column p-3">
                            <span class="upload-img d-block mb-1"><i class="ti ti-photo text-primary fs-16"></i></span>
                            <p class="mb-0 fs-14 text-dark">Rasm tashlang yoki <a href="javascript:void(0);" class="text-decoration-underline text-primary">tanlang</a></p>
                            <?= $form->field($model, 'imageFile')->fileInput([
                                'accept' => 'image/*',
                                'class' => 'form-control mt-2',
                                'id' => 'image-upload-input'
                            ])->label(false) ?>
                            <p class="fs-13 mb-0">Qo'llab-quvvatlanadigan formatlar: PNG, JPG, JPEG, GIF, WEBP | Maksimal hajmi: 5 MB</p>
                        </div>

                        <!-- Rasm preview -->
                        <div id="image-preview" class="mt-3" style="display: none;">
                            <label class="form-label">Yangi tanlangan rasm:</label>
                            <div class="border rounded p-3 d-inline-block">
                                <img id="preview-image" src="" alt="Preview" style="max-height: 150px; max-width: 250px;">
                            </div>
                            <div class="mt-2">
                                <small class="text-muted d-block" id="image-name"></small>
                                <small class="text-muted" id="image-size"></small>
                            </div>
                        </div>
                    </div>

                    <!-- Status va Tartiblash -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <input type="radio" name="Promotion[status]" value="1" id="status-active" <?= ($model->isNewRecord || $model->status == 1) ? 'checked' : '' ?>>
                                        <label for="status-active" class="ms-1">Faol</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="Promotion[status]" value="0" id="status-inactive" <?= (!$model->isNewRecord && $model->status == 0) ? 'checked' : '' ?>>
                                        <label for="status-inactive" class="ms-1">Nofaol</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-0">
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

<?php
$this->registerJs("
    // Rasm preview funksiyasi
    $('#image-upload-input').on('change', function(e) {
        var file = e.target.files[0];
        
        if (file) {
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#image-name').text(file.name);
                    $('#image-size').text('(' + (file.size / 1024 / 1024).toFixed(2) + ' MB)');
                    $('#image-preview').show();
                };
                
                reader.readAsDataURL(file);
            } else {
                alert('Iltimos, rasm formatidagi fayl tanlang!');
                $(this).val('');
                $('#image-preview').hide();
            }
        } else {
            $('#image-preview').hide();
        }
    });
    
    // Mavjud rasmni o'chirish
    $('#delete-image').click(function() {
        if (confirm('Rostdan ham rasmni o\\'chirmoqchimisiz?')) {
            $('.existing-image').fadeOut(300, function() {
                $(this).remove();
            });
        }
    });
");
?>