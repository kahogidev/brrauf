<?php

use common\helpers\UploadHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AboutCompany */

$currentLang = Yii::$app->language;
$title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
$description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
$content = $currentLang === 'ru' ? $model->content_ru : $model->content_uz;

$images = $model->getImagesArray();
$videos = $model->getVideosArray();

// Backend rasmlar uchun to'g'ri URL
function getBackendImageUrl($imagePath) {
    // OSPanel uchun to'g'ri yo'l
    return '/backend/web/' . $imagePath;
}
?>

<!-- About Section Five -->
<section class="about-section-five">
    <div class="auto-container">
        <div class="row">
            <!-- Content Column -->
            <div class="content-column col-lg-6 wow fadeInRight" data-wow-delay="600ms">
                <div class="inner-column">
                    <div class="sec-title">
                        <span class="sub-title"><?= Html::encode($title) ?></span>
                        <h2><?= Html::encode($title) ?></h2>
                        <div class="text"><?= Html::encode($description) ?></div>
                    </div>
                    <div class="btn-box">
                        <a href="<?= Url::to(['/site/about']) ?>" class="theme-btn btn-style-one">
                            <span class="btn-title">
                                <?= $currentLang === 'ru' ? 'УЗНАТЬ БОЛЬШЕ' : 'BATAFSIL' ?>
                            </span>
                        </a>
                    </div>

                    <?php if (!empty($videos)): ?>
                        <figure class="image-1 overlay-anim wow fadeInLeft">
                            <?php if (!empty($images) && isset($images[0])): ?>

                                <img src="<?= UploadHelper::getImageUrl($images[0]) ?>" alt="<?= Html::encode($title) ?>">
                            <?php else: ?>
                                <img src="/images/resource/about2-1.jpg" alt="<?= Html::encode($title) ?>">
                            <?php endif; ?>

                            <a href="<?= Html::encode($videos[0]) ?>" class="play-now" data-fancybox="gallery" data-caption="">
                                <i class="icon fa-sharp fa-solid fa-play"></i>
                                <span class="ripple"></span>
                            </a>
                        </figure>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Image Column -->
            <div class="image-column col-lg-6">
                <div class="inner-column wow fadeInLeft">
                    <span class="stroke-title"><?= Html::encode($title) ?></span>

                    <?php if (!empty($images) && isset($images[1])): ?>
                        <figure class="image-1 overlay-anim wow reveal-left">
                            <img src="<?= UploadHelper::getImageUrl($images[1]) ?>" alt="<?= Html::encode($title) ?>">
                        </figure>
                    <?php else: ?>
                        <figure class="image-1 overlay-anim wow reveal-left">
                            <img src="<?= UploadHelper::getImageUrl($images[1]) ?>" alt="<?= Html::encode($title) ?>">
                        </figure>
                    <?php endif; ?>

                    <div class="text"><div class="text"><?= $content ?></div></div>
                </div>
            </div>
        </div>
    </div>
</section>