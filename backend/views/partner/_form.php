<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Partner */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="content">

        <h4 class="mb-4"><?= $model->isNewRecord ? 'Yangi qo\'shish' : 'Tahrirlash' ?></h4>

        <div class="row">
            <div class="col-lg-10 mx-auto">

                <div class="mb-3">
                    <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Ortga', ['index'], ['class' => 'd-inline-flex align-items-center fw-medium']) ?>
                </div>

                <div class="card mb-0">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                        <div class="mb-3">
                            <label class="form-label">Brend nomi (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'brand_name_uz')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Brend nomi (Ruscha)<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'brand_name_ru')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Qisqa ma'lumot (O'zbekcha)</label>
                            <?= $form->field($model, 'description_uz')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Qisqa ma'lumot (Ruscha)</label>
                            <?= $form->field($model, 'description_ru')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Veb-sayt</label>
                            <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'https://example.com'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo</label>

                            <?php if (!$model->isNewRecord && $model->logo): ?>
                                <div class="mb-3 existing-logo">
                                    <label class="form-label d-block">Mavjud logo:</label>
                                    <div class="border rounded p-3 d-inline-block position-relative">
                                        <img src="/<?= $model->logo ?>" alt="Logo" style="max-height: 150px; max-width: 250px;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 8px; right: 8px;" id="delete-logo">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                    <p class="text-muted fs-13 mt-2 mb-0">Yangi logo yuklasangiz, eski logo o'chiriladi</p>
                                </div>
                            <?php endif; ?>

                            <div class="file-upload drag-file w-100 d-flex bg-light border shadow align-items-center justify-content-center flex-column p-3">
                                <span class="upload-img d-block mb-1"><i class="ti ti-photo text-primary fs-16"></i></span>
                                <p class="mb-0 fs-14 text-dark">Logo tashlang yoki <a href="javascript:void(0);" class="text-decoration-underline text-primary">tanlang</a></p>
                                <?= $form->field($model, 'logoFile')->fileInput([
                                    'accept' => 'image/*',
                                    'class' => 'form-control mt-2',
                                    'id' => 'logo-upload-input'
                                ])->label(false) ?>
                                <p class="fs-13 mb-0">Qo'llab-quvvatlanadigan formatlar: PNG, JPG, JPEG, GIF, WEBP, SVG | Maksimal hajmi: 5 MB</p>
                            </div>

                            <!-- Logo preview -->
                            <div id="logo-preview" class="mt-3" style="display: none;">
                                <label class="form-label">Yangi tanlangan logo:</label>
                                <div class="border rounded p-3 d-inline-block">
                                    <img id="preview-image" src="" alt="Preview" style="max-height: 150px; max-width: 250px;">
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted d-block" id="logo-name"></small>
                                    <small class="text-muted" id="logo-size"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <input type="radio" name="Partner[status]" value="1" id="status-active" <?= ($model->isNewRecord || $model->status == 1) ? 'checked' : '' ?>>
                                            <label for="status-active" class="ms-1">Faol</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="Partner[status]" value="0" id="status-inactive" <?= (!$model->isNewRecord && $model->status == 0) ? 'checked' : '' ?>>
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

    </div>

<?php
$this->registerJs("
    // Logo preview funksiyasi
    $('#logo-upload-input').on('change', function(e) {
        var file = e.target.files[0];
        
        if (file) {
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#logo-name').text(file.name);
                    $('#logo-size').text('(' + (file.size / 1024 / 1024).toFixed(2) + ' MB)');
                    $('#logo-preview').show();
                };
                
                reader.readAsDataURL(file);
            } else {
                alert('Iltimos, rasm formatidagi fayl tanlang!');
                $(this).val('');
                $('#logo-preview').hide();
            }
        } else {
            $('#logo-preview').hide();
        }
    });
    
    // Mavjud logoni o'chirish
    $('#delete-logo').click(function() {
        if (confirm('Rostdan ham logoni o\\'chirmoqchimisiz?')) {
            $('.existing-logo').fadeOut(300, function() {
                $(this).remove();
            });
        }
    });
");
?>