<?php
use common\helpers\UploadHelper;
use common\helpers\YouTubeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ProductionVolume */
/* @var $prevProduction common\models\ProductionVolume */
/* @var $nextProduction common\models\ProductionVolume */
/* @var $allProductions common\models\ProductionVolume[] */

$currentLang = Yii::$app->language;
$title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
$description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
$period = $currentLang === 'ru' ? $model->period_ru : $model->period_uz;
$unit = $currentLang === 'ru' ? $model->unit_ru : $model->unit_uz;

$images = $model->getImagesArray();
$videos = $model->getVideosArray();
$mainImage = !empty($images) ? '/' . $images[0] : '/images/resource/service-details.jpg';

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => ($currentLang === 'ru' ? 'Производство' : 'Ishlab chiqarish'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
?>

    <!-- Page Banner -->
    <section class="page-banner">
        <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1 class="title"><?= Html::encode($title) ?></h1>

            </div>
        </div>
    </section>

    <!-- Production Details -->
    <section class="blog-details">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__left">

                        <!-- YouTube Videos (yuqorida) -->
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

                        <!-- Main Image -->
                        <div class="blog-details__img">
                            <img src="<?= $mainImage ?>" alt="<?= Html::encode($title) ?>">

                            <div class="blog-details__date">
                                <span class="day"><?= Yii::$app->formatter->asDate($model->created_at, 'php:d') ?></span>
                                <span class="month"><?= Yii::$app->formatter->asDate($model->created_at, 'php:M') ?></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="blog-details__content">
                            <ul class="list-unstyled blog-details__meta">
                                <li>
                                    <a href="#"><i class="fas fa-calendar"></i> <?= Yii::$app->formatter->asDate($model->created_at, 'php:d F, Y') ?></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-chart-bar"></i> <?= number_format($model->volume, 0, '.', ' ') ?> <?= Html::encode($unit) ?></a>
                                </li>
                                <?php if (!empty($images)): ?>
                                    <li>
                                        <a href="#"><i class="fas fa-images"></i> <?= count($images) ?> <?= $currentLang === 'ru' ? 'фото' : 'rasm' ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($videos)): ?>
                                    <li>
                                        <a href="#"><i class="fas fa-video"></i> <?= count($videos) ?> video</a>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <h3 class="blog-details__title text-white"><?= Html::encode($title) ?></h3>

                            <?php if ($description): ?>
                                <div class="blog-details__text-2">
                                    <?= nl2br(Html::encode($description)) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Gallery Images -->
                            <?php if (!empty($images) && count($images) > 1): ?>
                                <h4 class="text-white mt-5 mb-3">
                                    <?= $currentLang === 'ru' ? 'Галерея производства' : 'Ishlab chiqarish galereyasi' ?>
                                </h4>
                                <div class="row">
                                    <?php foreach (array_slice($images, 1) as $image): ?>
                                        <div class="col-md-6 mb-4">
                                            <a href="/<?= $image ?>" data-fancybox="gallery">
                                                <img src="/<?= $image ?>"
                                                     alt="<?= Html::encode($title) ?>"
                                                     class="img-fluid rounded"
                                                     style="height: 250px; object-fit: cover; width: 100%;">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tags & Social Share -->
                        <div class="blog-details__bottom mt-4">
                            <p class="blog-details__tags">
                                <span><?= $currentLang === 'ru' ? 'Теги' : 'Teglar' ?></span>
                                <a href="#"><?= $currentLang === 'ru' ? 'Производство' : 'Ishlab chiqarish' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?></a>
                            </p>

                            <?php
                            $contact = \common\models\Contact::getSettings();
                            if ($contact && ($contact->facebook || $contact->instagram || $contact->telegram || $contact->youtube)):
                                ?>
                                <div class="blog-details__social-list">
                                    <?php if ($contact->facebook): ?>
                                        <a href="<?= Html::encode($contact->facebook) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <?php endif; ?>
                                    <?php if ($contact->instagram): ?>
                                        <a href="<?= Html::encode($contact->instagram) ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                                    <?php endif; ?>
                                    <?php if ($contact->telegram): ?>
                                        <a href="<?= Html::encode($contact->telegram) ?>" target="_blank"><i class="fab fa-telegram"></i></a>
                                    <?php endif; ?>
                                    <?php if ($contact->youtube): ?>
                                        <a href="<?= Html::encode($contact->youtube) ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Navigation -->
                        <div class="nav-links mt-4">
                            <?php if ($prevProduction): ?>
                                <?php $prevTitle = $currentLang === 'ru' ? $prevProduction->title_ru : $prevProduction->title_uz; ?>
                                <div class="prev">
                                    <a href="<?= Url::to(['production', 'id' => $prevProduction->id]) ?>" rel="prev">
                                        <?= Html::encode($prevTitle) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($nextProduction): ?>
                                <?php $nextTitle = $currentLang === 'ru' ? $nextProduction->title_ru : $nextProduction->title_uz; ?>
                                <div class="next">
                                    <a href="<?= Url::to(['production', 'id' => $nextProduction->id]) ?>" rel="next">
                                        <?= Html::encode($nextTitle) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">

                        <!-- Production Details Box -->
                        <div class="sidebar__single project-details__details-box mb-4">
                            <h3 class="sidebar__title text-white mb-3">
                                <?= $currentLang === 'ru' ? 'Детали производства' : 'Ishlab chiqarish tafsilotlari' ?>
                            </h3>
                            <ul class="list-unstyled project-details__details-list">
                                <li>
                                    <p class="project-details__client">
                                        <?= $currentLang === 'ru' ? 'Объем производства' : 'Ishlab chiqarish hajmi' ?>
                                    </p>
                                    <h4 class="project-details__name">
                                        <?= number_format($model->volume, 0, '.', ' ') ?> <?= Html::encode($unit) ?>
                                    </h4>
                                </li>

                                <?php if ($period): ?>
                                    <li>
                                        <p class="project-details__client">
                                            <?= $currentLang === 'ru' ? 'Период' : 'Davr' ?>
                                        </p>
                                        <h4 class="project-details__name">
                                            <?= Html::encode($period) ?>
                                        </h4>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <p class="project-details__client">
                                        <?= $currentLang === 'ru' ? 'Дата' : 'Sana' ?>
                                    </p>
                                    <h4 class="project-details__name">
                                        <?= Yii::$app->formatter->asDate($model->created_at, 'php:d F, Y') ?>
                                    </h4>
                                </li>

                                <?php if ($contact): ?>
                                    <li>
                                        <p class="project-details__client">
                                            <?= $currentLang === 'ru' ? 'Контакты' : 'Aloqa' ?>
                                        </p>
                                        <h4 class="project-details__name">
                                            <a href="tel:<?= $contact->phone1 ?>" class="text-white">
                                                <?= Html::encode($contact->phone1) ?>
                                            </a>
                                        </h4>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Latest Productions -->
                        <?php if ($allProductions && count($allProductions) > 1): ?>
                            <div class="sidebar__single sidebar__post">
                                <h3 class="sidebar__title text-white">
                                    <?= $currentLang === 'ru' ? 'Другие показатели' : 'Boshqa ko\'rsatkichlar' ?>
                                </h3>
                                <ul class="sidebar__post-list list-unstyled">
                                    <?php foreach ($allProductions as $production): ?>
                                        <?php if ($production->id != $model->id): ?>
                                            <?php
                                            $prodTitle = $currentLang === 'ru' ? $production->title_ru : $production->title_uz;
                                            $prodImages = $production->getImagesArray();
                                            ?>
                                            <li>
                                                <div class="sidebar__post-image">
                                                    <?php if (!empty($prodImages)): ?>
                                                        <img src="/<?= $prodImages[0] ?>" alt="<?= Html::encode($prodTitle) ?>">
                                                    <?php else: ?>
                                                        <img src="/images/resource/news1-1.jpg" alt="<?= Html::encode($prodTitle) ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="sidebar__post-content">
                                                    <h3>
                                                    <span class="sidebar__post-content-meta">
                                                        <i class="fas fa-chart-bar"></i>
                                                        <?= number_format($production->volume, 0, '.', ' ') ?> <?= $currentLang === 'ru' ? $production->unit_ru : $production->unit_uz ?>
                                                    </span>
                                                        <a href="<?= Url::to(['production', 'id' => $production->id]) ?>">
                                                            <?= Html::encode($prodTitle) ?>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Statistics Card -->

                        <!-- Tags -->
                        <div class="sidebar__single sidebar__tags">
                            <h3 class="sidebar__title text-white"><?= $currentLang === 'ru' ? 'Теги' : 'Teglar' ?></h3>
                            <div class="sidebar__tags-list">
                                <a href="#"><?= $currentLang === 'ru' ? 'Производство' : 'Ishlab chiqarish' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Статистика' : 'Statistika' ?></a>
                                <a href="#">BR Mebel</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Pagination (qo'shimcha) -->
            <div class="row mt-5">
                <div class="col-xl-12">
                    <div class="project-details__pagination-box">
                        <ul class="project-details__pagination list-unstyled clearfix">
                            <?php if ($prevProduction): ?>
                                <li class="next">
                                    <div class="icon">
                                        <a href="<?= Url::to(['production', 'id' => $prevProduction->id]) ?>" aria-label="Previous">
                                            <i class="lnr lnr-icon-arrow-left"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <?= $currentLang === 'ru' ? 'Предыдущий' : 'Oldingi' ?>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="next disabled">
                                    <div class="icon">
                                        <span><i class="lnr lnr-icon-arrow-left"></i></span>
                                    </div>
                                    <div class="content">
                                        <?= $currentLang === 'ru' ? 'Предыдущий' : 'Oldingi' ?>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <?php foreach (array_slice($allProductions, 0, 4) as $production): ?>
                                <li class="count">
                                    <a href="<?= Url::to(['production', 'id' => $production->id]) ?>"
                                       class="<?= $production->id == $model->id ? 'active' : '' ?>">
                                    </a>
                                </li>
                            <?php endforeach; ?>

                            <?php if ($nextProduction): ?>
                                <li class="previous">
                                    <div class="content">
                                        <?= $currentLang === 'ru' ? 'Следующий' : 'Keyingi' ?>
                                    </div>
                                    <div class="icon">
                                        <a href="<?= Url::to(['production', 'id' => $nextProduction->id]) ?>" aria-label="Next">
                                            <i class="lnr lnr-icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="previous disabled">
                                    <div class="content">
                                        <?= $currentLang === 'ru' ? 'Следующий' : 'Keyingi' ?>
                                    </div>
                                    <div class="icon">
                                        <span><i class="lnr lnr-icon-arrow-right"></i></span>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
// Fancybox
$this->registerCssFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerJs("
    Fancybox.bind('[data-fancybox]', {
        Toolbar: {
            display: {
                left: ['infobar'],
                middle: [],
                right: ['close'],
            },
        },
    });
");

$this->registerCss("
    .project-details__pagination .count a.active {
        background: var(--theme-color-one, #4CAF50);
    }
");
?>