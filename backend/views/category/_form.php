<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="content">

        <h4 class="mb-4"><?= $model->isNewRecord ? 'Yangi kategoriya qo\'shish' : 'Kategoriyani tahrirlash' ?></h4>

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
                                    <label class="form-label">Nomi (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                                    <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomi (Ruscha)<span class="text-danger ms-1">*</span></label>
                                    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!$model->isNewRecord): ?>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true])->label(false) ?>
                                <small class="text-muted">Avtomatik yaratiladi</small>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Tavsif (O'zbekcha)</label>
                            <?= $form->field($model, 'description_uz')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tavsif (Ruscha)</label>
                            <?= $form->field($model, 'description_ru')->textarea(['rows' => 4, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rasm</label>
                            <div class="file-upload drag-file w-100 d-flex bg-light border shadow align-items-center justify-content-center flex-column p-3">
                                <span class="upload-img d-block mb-1"><i class="ti ti-folder-open text-primary fs-16"></i></span>
                                <p class="mb-0 fs-14 text-dark">Rasmni tashlang yoki <a href="javascript:void(0);" class="text-decoration-underline text-primary">tanlang</a></p>
                                <?= $form->field($model, 'imageFile')->fileInput([
                                    'accept' => 'image/*',
                                    'class' => 'form-control mt-2',
                                    'id' => 'image-upload-input'
                                ])->label(false) ?>
                                <p class="fs-13 mb-0">Maksimal hajmi: 5 MB</p>
                            </div>

                            <!-- Preview -->
                            <div id="new-image-preview" class="mt-3" style="display: none;">
                                <label class="form-label">Yangi tanlangan rasm:</label>
                                <div id="image-preview-container"></div>
                            </div>

                            <?php if (!$model->isNewRecord && $model->image): ?>
                                <div class="existing-image mt-3">
                                    <label class="form-label">Mavjud rasm:</label>
                                    <div class="border rounded p-3 d-inline-block">
                                        <img src="/<?= $model->image ?>" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <input type="radio" name="Category[status]" value="1" id="status-active" <?= ($model->isNewRecord || $model->status == 1) ? 'checked' : '' ?>>
                                            <label for="status-active" class="ms-1">Faol</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="Category[status]" value="0" id="status-inactive" <?= (!$model->isNewRecord && $model->status == 0) ? 'checked' : '' ?>>
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
    // Rasm preview
    $('#image-upload-input').on('change', function(e) {
        var file = e.target.files[0];
        
        if (file && file.type.match('image.*')) {
            $('#new-image-preview').show();
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var html = '<div class=\"border rounded p-3 d-inline-block position-relative\">' +
                    '<img src=\"' + e.target.result + '\" class=\"img-fluid rounded\" style=\"max-height: 200px;\">' +
                    '<div class=\"mt-2\"><small class=\"text-muted\">' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</small></div>' +
                    '<span class=\"badge bg-success position-absolute\" style=\"top: 8px; right: 8px;\">Yangi</span>' +
                    '</div>';
                $('#image-preview-container').html(html);
            };
            
            reader.readAsDataURL(file);
        } else {
            $('#new-image-preview').hide();
        }
    });
");
?>