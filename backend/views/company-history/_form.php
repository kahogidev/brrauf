<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyHistory */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="content">

        <h4 class="mb-4"><?= $model->isNewRecord ? 'Yangi tarix qo\'shish' : 'Tarixni tahrirlash' ?></h4>

        <div class="row">
            <div class="col-lg-10 mx-auto">

                <div class="mb-3">
                    <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Ortga', ['index'], ['class' => 'd-inline-flex align-items-center fw-medium']) ?>
                </div>

                <div class="card mb-0">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                        <div class="mb-3">
                            <label class="form-label">Yil<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'year')->textInput(['type' => 'number', 'min' => 1900, 'max' => 2100, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sarlavha (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sarlavha (Ruscha)<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tavsif (O'zbekcha)<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'description_uz')->textarea(['rows' => 5, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tavsif (Ruscha)<span class="text-danger ms-1">*</span></label>
                            <?= $form->field($model, 'description_ru')->textarea(['rows' => 5, 'class' => 'form-control'])->label(false) ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rasmlar</label>
                            <div class="file-upload drag-file w-100 d-flex bg-light border shadow align-items-center justify-content-center flex-column p-3">
                                <span class="upload-img d-block mb-1"><i class="ti ti-folder-open text-primary fs-16"></i></span>
                                <p class="mb-0 fs-14 text-dark">Rasmlarni tashlang yoki <a href="javascript:void(0);" class="text-decoration-underline text-primary">tanlang</a></p>
                                <?= $form->field($model, 'imageFiles[]')->fileInput([
                                    'multiple' => true,
                                    'accept' => 'image/*',
                                    'class' => 'form-control mt-2',
                                    'id' => 'image-upload-input'
                                ])->label(false) ?>
                                <p class="fs-13 mb-0">Maksimal hajmi: 5 MB har bir rasm | Maksimal: 10 ta rasm</p>
                            </div>

                            <!-- Yangi yuklangan rasmlar preview -->
                            <div id="new-images-preview" class="mt-3" style="display: none;">
                                <label class="form-label">Yangi tanlangan rasmlar:</label>
                                <div class="row" id="preview-container"></div>
                            </div>

                            <?php if (!$model->isNewRecord && !empty($model->getImagesArray())): ?>
                                <div class="existing-images mt-3">
                                    <label class="form-label">Mavjud rasmlar:</label>
                                    <div class="row">
                                        <?php foreach ($model->getImagesArray() as $image): ?>
                                            <div class="col-md-3 mb-3 image-item" data-image="<?= $image ?>">
                                                <div class="border rounded p-2">
                                                    <img src="/<?= $image ?>" class="img-fluid rounded mb-2" style="max-height: 150px; width: 100%; object-fit: cover;">
                                                    <button type="button" class="btn btn-danger btn-sm w-100 delete-image" data-id="<?= $model->id ?>" data-path="<?= $image ?>">
                                                        <i class="ti ti-trash"></i> O'chirish
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Video linklar (YouTube)</label>
                            <div id="video-links-container">
                                <?php
                                $videos = $model->getVideosArray();
                                if (empty($videos)) {
                                    $videos = [''];
                                }
                                foreach ($videos as $index => $video):
                                    ?>
                                    <div class="input-group mb-2 video-link-item">
                                        <input type="text" name="videoLinks[]" class="form-control" value="<?= Html::encode($video) ?>" placeholder="https://www.youtube.com/watch?v=...">
                                        <button type="button" class="btn btn-danger remove-video-link">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="add-video-link">
                                <i class="ti ti-plus"></i> Video link qo'shish
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <input type="radio" name="CompanyHistory[status]" value="1" id="status-active" <?= ($model->isNewRecord || $model->status == 1) ? 'checked' : '' ?>>
                                            <label for="status-active" class="ms-1">Faol</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="CompanyHistory[status]" value="0" id="status-inactive" <?= (!$model->isNewRecord && $model->status == 0) ? 'checked' : '' ?>>
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
    // Rasm preview funksiyasi
    $('#image-upload-input').on('change', function(e) {
        var files = e.target.files;
        var previewContainer = $('#preview-container');
        previewContainer.empty();
        
        if (files.length > 0) {
            $('#new-images-preview').show();
            
            $.each(files, function(index, file) {
                if (file.type.match('image.*')) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        var html = '<div class=\"col-md-3 mb-3 preview-image-item\">' +
                            '<div class=\"border rounded p-2 position-relative\">' +
                            '<img src=\"' + e.target.result + '\" class=\"img-fluid rounded mb-2\" style=\"max-height: 150px; width: 100%; object-fit: cover;\">' +
                            '<div class=\"text-center\">' +
                            '<small class=\"text-muted d-block text-truncate\">' + file.name + '</small>' +
                            '<small class=\"text-muted\">(' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</small>' +
                            '</div>' +
                            '<span class=\"badge bg-success position-absolute\" style=\"top: 8px; right: 8px;\">Yangi</span>' +
                            '</div>' +
                            '</div>';
                        previewContainer.append(html);
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
        } else {
            $('#new-images-preview').hide();
        }
    });

    $('#add-video-link').click(function() {
        var html = '<div class=\"input-group mb-2 video-link-item\">' +
            '<input type=\"text\" name=\"videoLinks[]\" class=\"form-control\" placeholder=\"https://www.youtube.com/watch?v=...\">' +
            '<button type=\"button\" class=\"btn btn-danger remove-video-link\"><i class=\"ti ti-x\"></i></button>' +
            '</div>';
        $('#video-links-container').append(html);
    });
    
    $(document).on('click', '.remove-video-link', function() {
        if ($('.video-link-item').length > 1) {
            $(this).closest('.video-link-item').remove();
        } else {
            $(this).closest('.video-link-item').find('input').val('');
        }
    });
    
    $('.delete-image').click(function() {
        if (!confirm('Rostdan ham bu rasmni o\\'chirmoqchimisiz?')) {
            return;
        }
        
        var btn = $(this);
        var id = btn.data('id');
        var path = btn.data('path');
        
        $.ajax({
            url: '/company-history/delete-image?id=' + id,
            type: 'POST',
            data: {
                imagePath: path,
                _csrf: yii.getCsrfToken()
            },
            success: function(response) {
                if (response.success) {
                    btn.closest('.image-item').fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Xatolik yuz berdi!');
            }
        });
    });
");
?>