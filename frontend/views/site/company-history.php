<?php

use common\helpers\UploadHelper;
use common\helpers\YouTubeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$currentLang = Yii::$app->language;
$this->title = $currentLang === 'ru' ? 'История компании' : 'Kompaniya tarixi';
$this->params['breadcrumbs'][] = $this->title;
?>

    <!-- Page Banner Section -->
    <section class="page-banner">
        <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1 class="title"><?= Html::encode($this->title) ?></h1>
                <ul class="bread-crumb">
                    <li><?= Html::a($currentLang === 'ru' ? 'Главная' : 'Bosh sahifa', ['/']) ?></li>
                    <li><?= Html::encode($this->title) ?></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- History Details Section -->
    <section class="blog-details">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-xl-12 col-lg-7">
                    <?php if ($dataProvider->getModels()): ?>
                        <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                            <?php
                            $title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
                            $description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
                            $images = $model->getImagesArray();
                            $videos = $model->getVideosArray();
                            ?>

                            <div class="blog-details__left mb-5" id="year-<?= $model->id ?>">
                                <?php if (!empty($videos)): ?>
                                    <div class="video-section p-0 mb-4">
                                        <h4 class="text-white mb-3">
                                            <i class="fas fa-video"></i>
                                            <?= $currentLang === 'ru' ? 'Видеоматериалы' : 'Video materiallar' ?>
                                        </h4>

                                        <?php foreach ($videos as $videoIndex => $video): ?>
                                            <?php
                                            $videoId = YouTubeHelper::getVideoId($video);
                                            $embedUrl = YouTubeHelper::getEmbedUrl($video);
                                            ?>

                                            <?php if ($videoId): ?>
                                                <div class="mb-4">
                                                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px;">
                                                        <iframe
                                                                src="<?= $embedUrl ?>"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; border-radius: 10px;"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <!-- Image -->
                                <div class="blog-details__img">
                                    <?php if (!empty($images) && isset($images[0])): ?>
                                        <img src="<?= UploadHelper::getImageUrl($images[0]) ?>" alt="<?= Html::encode($title) ?>">
                                    <?php else: ?>
                                        <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                            <h1 style="color: white; font-size: 96px; font-weight: bold;"><?= $model->year ?></h1>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Year Badge -->
                                    <div class="blog-details__date">
                                        <span class="day"><?= substr($model->year, -2) ?></span>
                                        <span class="month"><?= substr($model->year, 0, 2) ?></span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="blog-details__content">
                                    <ul class="list-unstyled blog-details__meta">
                                        <li>
                                            <a href="#"><i class="fas fa-calendar"></i> <?= $model->year ?></a>
                                        </li>
                                        <?php if (!empty($images)): ?>
                                            <li>
                                                <a href="#"><i class="fas fa-images"></i> <?= count($images) ?> <?= $currentLang === 'ru' ? 'фото' : 'rasm' ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (!empty($videos)): ?>
                                            <li>
                                                <a href="#"><i class="fas fa-video"></i> <?= count($videos) ?> <?= $currentLang === 'ru' ? 'видео' : 'video' ?></a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>

                                    <h3 class="blog-details__title text-white"><?= Html::encode($title) ?></h3>
                                    <p class="blog-details__text-2"><?= nl2br(Html::encode($description)) ?></p>

                                    <!-- Additional Images -->
                                    <?php if (!empty($images) && count($images) > 1): ?>
                                        <div class="row mt-4 mb-4">
                                            <?php for ($i = 1; $i < min(4, count($images)); $i++): ?>
                                                <div class="col-md-4 mb-3">
                                                    <a href="<?= UploadHelper::getImageUrl($images[$i]) ?>" data-fancybox="gallery-<?= $model->id ?>">
                                                        <img src="<?= UploadHelper::getImageUrl($images[$i]) ?>"
                                                             alt="<?= Html::encode($title) ?>"
                                                             class="img-fluid rounded"
                                                             style="height: 200px; object-fit: cover; width: 100%;">
                                                    </a>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- YouTube Videos -->
                                    <!-- YouTube Videos - ODDIY VERSIYA -->

                                </div>

                                <?php if ($index < count($dataProvider->getModels()) - 1): ?>
                                    <!-- Divider -->
                                    <div class="blog-details__bottom mt-4 mb-4" style="border-bottom: 2px solid #333; padding-bottom: 20px;"></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- No Data -->
                        <div class="text-center py-5">
                            <i class="fas fa-history" style="font-size: 80px; color: #666; margin-bottom: 20px;"></i>
                            <h3 class="text-white"><?= $currentLang === 'ru' ? 'История компании скоро появится' : 'Kompaniya tarixi tez orada' ?></h3>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar ... -->
                <div class="col-xl-4 col-lg-5">
                    <!-- Sidebar kodlari ... -->
                </div>
            </div>
        </div>
    </section>

<?php
// Fancybox faqat rasmlar uchun
$this->registerCssFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerJs("
    // Fancybox faqat rasmlar uchun
    Fancybox.bind('[data-fancybox^=\"gallery-\"]', {
        Toolbar: {
            display: {
                left: ['infobar'],
                middle: [],
                right: ['close'],
            },
        },
    });
    
    // Modal ochilganda video to'xtatish
    $('.modal').on('hidden.bs.modal', function () {
        var iframe = $(this).find('iframe');
        var src = iframe.attr('src');
        iframe.attr('src', src);
    });
    
    // Smooth scroll
    $('a[href^=\"#year-\"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        if ($(target).length) {
            $('html, body').animate({
                scrollTop: $(target).offset().top - 100
            }, 800);
        }
    });
");

$this->registerCss("
    .video-thumb {
        transition: transform 0.3s;
    }
    .video-thumb:hover {
        transform: scale(1.05);
    }
    .play-now {
        pointer-events: none;
    }
");
?>