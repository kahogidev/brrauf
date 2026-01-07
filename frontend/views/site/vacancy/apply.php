<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $vacancy common\models\Vacancy */
/* @var $model common\models\VacancyApplication */

$lang = Yii::$app->language;
$title = $lang == 'uz' ? 'title_uz' : 'title_ru';

$this->title = ($lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку') . ' - ' . $vacancy->$title;
$this->params['breadcrumbs'][] = ['label' => $lang == 'uz' ? 'Vakansiyalar' : 'Вакансии', 'url' => ['vacancy']];
$this->params['breadcrumbs'][] = ['label' => $vacancy->$title, 'url' => ['vacancy-view', 'id' => $vacancy->id]];
$this->params['breadcrumbs'][] = $lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку';
?>

    <!-- Page Banner Section -->
    <section class="page-banner">
        <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1 class="title"><?= $lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку' ?></h1>
                <ul class="bread-crumb">
                    <li><?= Html::a($lang == 'uz' ? 'Bosh sahifa' : 'Главная', ['/']) ?></li>
                    <li><?= Html::a($lang == 'uz' ? 'Vakansiyalar' : 'Вакансии', ['vacancy']) ?></li>
                    <li><?= Html::a($vacancy->$title, ['vacancy-view', 'id' => $vacancy->id]) ?></li>
                    <li><?= $lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку' ?></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Call-to-action Four -->
    <section class="call-to-action-four pt-0">
        <div class="auto-container">
            <div class="row">
                <!-- Vacancy Info Column -->
                <div class="content-colum col-lg-5 col-md-12 col-sm-12">
                    <div class="inner-column wow fadeInLeft">
                        <div class="contact-info-style1">

                            <!-- Vacancy Title -->
                            <div class="call-block-two">
                                <div class="inner-box style-two">
                                    <h3 class="call-title"><?= Html::encode($vacancy->$title) ?></h3>
                                </div>
                            </div>

                            <!-- Employment Type & Salary -->
                            <div class="call-block-two">
                                <div class="inner-box">
                                    <h4 style="color: black" class="title"><?= $lang == 'uz' ? 'Ish turi' : 'Тип работы' ?></h4>
                                    <div class="text"><?= $vacancy->getEmploymentTypeName() ?></div>
                                </div>
                            </div>

                            <div class="call-block-two">
                                <div class="inner-box">
                                    <h4 style="color: black" class="title"><?= $lang == 'uz' ? 'Maosh' : 'Зарплата' ?></h4>
                                    <div class="text"><?= $vacancy->getFormattedSalary() ?></div>
                                </div>
                            </div>

                            <!-- Deadline -->
                            <?php if ($vacancy->deadline): ?>
                                <div class="call-block-two">
                                    <div class="inner-box">
                                        <h4 style="color: black" class="title"><?= $lang == 'uz' ? 'Muddati' : 'Срок подачи' ?></h4>
                                        <div class="text"><?= Yii::$app->formatter->asDate($vacancy->deadline) ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Back Button -->
                            <div style="margin-top: 30px;">
                                <?= Html::a(
                                    '<i class="fa fa-arrow-left"></i> ' . ($lang == 'uz' ? 'Vakansiyaga qaytish' : 'Вернуться к вакансии'),
                                    ['vacancy-view', 'id' => $vacancy->id],
                                    ['class' => 'theme-btn btn-style-two']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Application Form Column -->
                <div class="col-lg-7 contact-form-two">
                    <div class="inner-column wow fadeInRight" data-wow-delay="200ms">
                        <div class="sec-title">
                            <span class="sub-title"><?= $lang == 'uz' ? 'KELING MULOQOT QILAYLIK' : 'ДАВАЙТЕ ОБЩАТЬСЯ' ?></span>
                            <h2><?= $lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку' ?></h2>
                        </div>

                        <?php $form = ActiveForm::begin([
                            'id' => 'application_form',
                            'options' => [
                                'class' => 'bk-form',
                                'enctype' => 'multipart/form-data'
                            ],
                            'fieldConfig' => [
                                'template' => '<div class="frm-field">{input}{error}</div>',
                                'errorOptions' => ['class' => 'help-block text-danger'],
                            ],
                        ]); ?>

                        <!-- Row 1: Full Name & Email -->
                        <div class="row gx-4">
                            <div class="col-lg-6">
                                <?= $form->field($model, 'full_name')->textInput([
                                    'class' => 'form-control',
                                    'placeholder' => $lang == 'uz' ? 'To\'liq ismingiz' : 'Ваше полное имя'
                                ])->label(false) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $form->field($model, 'email')->input('email', [
                                    'class' => 'form-control required email',
                                    'placeholder' => 'Email'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <!-- Row 2: Phone & Birth Date -->
                        <div class="row gx-4">
                            <div class="col-lg-6">
                                <?= $form->field($model, 'phone')->textInput([
                                    'class' => 'form-control',
                                    'placeholder' => $lang == 'uz' ? 'Telefon raqam' : 'Номер телефона'
                                ])->label(false) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $form->field($model, 'birth_date')->input('date', [
                                    'class' => 'form-control',
                                    'placeholder' => $lang == 'uz' ? 'Tug\'ilgan sana' : 'Дата рождения'
                                ])->label(false) ?>
                            </div>
                        </div>

                        <!-- Education -->
                        <?= $form->field($model, 'education')->textInput([
                            'class' => 'form-control',
                            'placeholder' => $lang == 'uz' ? 'Ma\'lumot (masalan: Oliy, TDTU)' : 'Образование (например: Высшее, ТГТУ)'
                        ])->label(false) ?>

                        <!-- Experience -->
                        <?= $form->field($model, 'experience')->textarea([
                            'rows' => 5,
                            'class' => 'form-control',
                            'placeholder' => $lang == 'uz' ? 'Ish tajribangiz haqida yozing...' : 'Напишите о вашем опыте работы...'
                        ])->label(false) ?>

                        <!-- Cover Letter -->
                        <?= $form->field($model, 'cover_letter')->textarea([
                            'rows' => 5,
                            'class' => 'form-control',
                            'placeholder' => $lang == 'uz' ? 'Nima uchun aynan siz bu lavozimga mos ekanligingizni yozing...' : 'Напишите, почему именно вы подходите на эту должность...'
                        ])->label(false) ?>

                        <!-- Resume Upload -->
                        <div class="frm-field">
                            <label class="form-label" style="color: #666; margin-bottom: 10px; display: block;">
                                <i class="fa fa-file-pdf"></i>
                                <?= $lang == 'uz' ? 'Resume (CV) yuklash' : 'Загрузить резюме (CV)' ?>
                            </label>
                            <?= $form->field($model, 'resumeFile')->fileInput([
                                'class' => 'form-control',
                                'accept' => '.pdf,.doc,.docx'
                            ])->label(false) ?>
                            <small class="text-muted">
                                <?= $lang == 'uz'
                                    ? 'PDF, DOC, DOCX formatdagi fayllar. Maksimal: 5 MB'
                                    : 'Файлы в формате PDF, DOC, DOCX. Максимум: 5 МБ'
                                ?>
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-submit">
                            <?= Html::submitButton(
                                '<span class="btn-title">' . strtoupper($lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку') . '</span>',
                                [
                                    'class' => 'theme-btn btn-style-one',
                                    'id' => 'submit-btn',
                                    'data-loading-text' => '<span class="btn-title">' . ($lang == 'uz' ? 'Yuborilmoqda...' : 'Отправка...') . '</span>'
                                ]
                            ) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
// Custom CSS
$this->registerCss("
    .help-block {
        margin-top: 5px;
        font-size: 13px;
    }
    .form-control {
        border: 1px solid #e0e0e0;
        padding: 12px 20px;
        height: auto;
    }
    .form-control:focus {
        border-color: var(--theme-color-one);
        box-shadow: none;
    }
    .frm-field {
        margin-bottom: 20px;
    }
    .contact-info-style1 .call-block-two {
        margin-bottom: 20px;
    }
    .contact-info-style1 .call-block-two .inner-box {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    .contact-info-style1 .call-block-two .inner-box.style-two {
        background: linear-gradient(135deg, var(--theme-color-one) 0%, var(--theme-color-two) 100%);
        color: white;
    }
    .contact-info-style1 .call-block-two .inner-box.style-two .call-title {
        color: white;
        margin: 0;
    }
    
    /* Loading state */
    #submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    /* File input style */
    input[type='file'].form-control {
        padding: 10px;
    }
");

// Custom JS for form handling
$this->registerJs("
    $('#application_form').on('beforeSubmit', function(e) {
        var form = $(this);
        var submitBtn = $('#submit-btn');
        var loadingText = submitBtn.data('loading-text');
        
        // Disable button and show loading
        submitBtn.prop('disabled', true).html(loadingText);
        
        // Optionally add a spinner
        submitBtn.addClass('loading');
        
        return true;
    });
    
    // Enable button if form submission fails
    $('#application_form').on('afterValidate', function(event, messages, errorAttributes) {
        if (errorAttributes.length > 0) {
            var submitBtn = $('#submit-btn');
            submitBtn.prop('disabled', false).html('<span class=\"btn-title\">" .
    strtoupper($lang == 'uz' ? 'ARIZA YUBORISH' : 'ОТПРАВИТЬ ЗАЯВКУ') .
    "</span>');
            submitBtn.removeClass('loading');
        }
    });
");
?>