<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$currentLang = Yii::$app->language;
$address1 = $currentLang === 'ru' ? $model->address1_ru : $model->address1_uz;
$address2 = $currentLang === 'ru' ? $model->address2_ru : $model->address2_uz;
$workingHours = $currentLang === 'ru' ? $model->working_hours_ru : $model->working_hours_uz;

// Google Maps URL
$mapUrl = 'https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q='
    . urlencode($address1)
    . '&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed';

// Agar latitude va longitude bo'lsa
if ($model->map_latitude && $model->map_longitude) {
    $mapUrl = "https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={$model->map_latitude},{$model->map_longitude}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed";
}
?>

<!--Contact Details Start-->
<section class="contact-details">
    <div class="container pt-110 pb-70">
        <div class="row">
            <div class="col-xl-7 col-lg-6">
                <div class="sec-title">
                    <span class="sub-title before-none">
                        <?= $currentLang === 'ru' ? 'Напишите нам' : 'Bizga yozing' ?>
                    </span>
                    <h2>
                        <?= $currentLang === 'ru' ? 'Свяжитесь с нами' : 'Biz bilan bog\'laning' ?>
                    </h2>
                </div>

                <!-- Contact Form -->
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'action' => Url::to(['/site/contact']),
                    'options' => ['class' => 'dark-style'],
                ]); ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <input name="name" class="form-control" type="text"
                                   placeholder="<?= $currentLang === 'ru' ? 'Ваше имя' : 'Ismingiz' ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <input name="email" class="form-control" type="email"
                                   placeholder="<?= $currentLang === 'ru' ? 'Email' : 'Email' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <input name="subject" class="form-control" type="text"
                                   placeholder="<?= $currentLang === 'ru' ? 'Тема' : 'Mavzu' ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <input name="phone" class="form-control" type="text"
                                   placeholder="<?= $currentLang === 'ru' ? 'Телефон' : 'Telefon' ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                        <textarea name="message" class="form-control" rows="7"
                                  placeholder="<?= $currentLang === 'ru' ? 'Ваше сообщение' : 'Xabaringiz' ?>" required></textarea>
                </div>
                <div class="mb-5">
                    <button type="submit" class="theme-btn btn-style-one">
                            <span class="btn-title">
                                <?= $currentLang === 'ru' ? 'Отправить' : 'Yuborish' ?>
                            </span>
                    </button>
                    <button type="reset" class="theme-btn btn-style-one bg-theme-color5">
                            <span class="btn-title">
                                <?= $currentLang === 'ru' ? 'Очистить' : 'Tozalash' ?>
                            </span>
                    </button>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="col-xl-5 col-lg-6">
                <div class="contact-details__right">
                    <div class="sec-title">
                        <span class="sub-title before-none">
                            <?= $currentLang === 'ru' ? 'Нужна помощь?' : 'Yordam kerakmi?' ?>
                        </span>
                        <h2>
                            <?= $currentLang === 'ru' ? 'Свяжитесь с нами' : 'Biz bilan bog\'laning' ?>
                        </h2>
                        <div class="text">
                            <?= $currentLang === 'ru'
                                ? 'Мы всегда готовы ответить на ваши вопросы и помочь с выбором мебели для вашего дома или офиса.'
                                : 'Biz har doim savollaringizga javob berishga va uyingiz yoki ofisingiz uchun mebel tanlashda yordam berishga tayyormiz.'
                            ?>
                        </div>
                    </div>
                    <ul class="list-unstyled contact-details__info">
                        <?php if ($model->phone1): ?>
                            <li>
                                <div class="icon">
                                    <span class="lnr-icon-phone-plus"></span>
                                </div>
                                <div class="text">
                                    <h6 class="mb-2">
                                        <?= $currentLang === 'ru' ? 'Есть вопросы?' : 'Savolingiz bormi?' ?>
                                    </h6>
                                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $model->phone1) ?>">
                                        <?= Html::encode($model->phone1) ?>
                                    </a>
                                    <?php if ($model->phone2): ?>
                                        <br>
                                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $model->phone2) ?>">
                                            <?= Html::encode($model->phone2) ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if ($model->email): ?>
                            <li>
                                <div class="icon">
                                    <span class="lnr-icon-envelope1"></span>
                                </div>
                                <div class="text">
                                    <h6 class="mb-2">
                                        <?= $currentLang === 'ru' ? 'Email' : 'Email' ?>
                                    </h6>
                                    <a href="mailto:<?= Html::encode($model->email) ?>">
                                        <?= Html::encode($model->email) ?>
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if ($address1): ?>
                            <li>
                                <div class="icon">
                                    <span class="lnr-icon-location"></span>
                                </div>
                                <div class="text">
                                    <h6 class="mb-2">
                                        <?= $currentLang === 'ru' ? 'Наш адрес' : 'Bizning manzil' ?>
                                    </h6>
                                    <span><?= Html::encode($address1) ?></span>
                                    <?php if ($address2): ?>
                                        <br><span><?= Html::encode($address2) ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if ($workingHours): ?>
                            <li>
                                <div class="icon">
                                    <span class="lnr-icon-clock"></span>
                                </div>
                                <div class="text">
                                    <h6 class="mb-2">
                                        <?= $currentLang === 'ru' ? 'Время работы' : 'Ish vaqti' ?>
                                    </h6>
                                    <span><?= Html::encode($workingHours) ?></span>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Social Media Links -->
                    <?php if ($model->instagram || $model->facebook || $model->linkedin || $model->youtube || $model->telegram): ?>
                        <div class="social-links mt-4">
                            <h6 class="mb-3">
                                <?= $currentLang === 'ru' ? 'Мы в социальных сетях' : 'Ijtimoiy tarmoqlarda' ?>
                            </h6>
                            <div class="d-flex gap-3">
                                <?php if ($model->instagram): ?>
                                    <a href="<?= Html::encode($model->instagram) ?>" target="_blank" class="social-icon">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($model->facebook): ?>
                                    <a href="<?= Html::encode($model->facebook) ?>" target="_blank" class="social-icon">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($model->telegram): ?>
                                    <a href="<?= Html::encode($model->telegram) ?>" target="_blank" class="social-icon">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($model->youtube): ?>
                                    <a href="<?= Html::encode($model->youtube) ?>" target="_blank" class="social-icon">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($model->linkedin): ?>
                                    <a href="<?= Html::encode($model->linkedin) ?>" target="_blank" class="social-icon">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact Details End-->

<!-- Map Section-->
<section class="map-section">
    <iframe class="map w-100" src="<?= $mapUrl ?>" style="height: 450px; border: 0;"></iframe>
</section>