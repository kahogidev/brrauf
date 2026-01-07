<?php
use common\helpers\UploadHelper;
use common\helpers\YouTubeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $latestNews common\models\News[] */
/* @var $prevNews common\models\News */
/* @var $nextNews common\models\News */

$currentLang = Yii::$app->language;
$title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
$description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
$content = $currentLang === 'ru' ? $model->content_ru : $model->content_uz;

$images = $model->getImagesArray();
$videos = $model->getVideosArray(); // Video qo'shish
$mainImage = !empty($images) ? '/' . $images[0] : '/images/resource/news-details.jpg';

$publishDate = $model->published_date ?: date('Y-m-d', $model->created_at);

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => ($currentLang === 'ru' ? 'Новости' : 'Yangiliklar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
?>

    <!-- Page Banner -->
    <section class="page-banner">
        <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1 class="title"><?= Html::encode($title) ?></h1>
                <ul class="bread-crumb">
                    <li><?= Html::a($currentLang === 'ru' ? 'Главная' : 'Bosh sahifa', ['/']) ?></li>
                    <li><?= Html::a($currentLang === 'ru' ? 'Новости' : 'Yangiliklar', ['/site/index']) ?></li>
                    <li><?= Html::encode($title) ?></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="blog-details">
        <div class="container">
            <div class="row">
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
                                <span class="day"><?= date('d', strtotime($publishDate)) ?></span>
                                <span class="month"><?= date('M', strtotime($publishDate)) ?></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="blog-details__content">
                            <ul class="list-unstyled blog-details__meta">
                                <li>
                                    <a href="#"><i class="fas fa-user-circle"></i> Admin</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-calendar"></i>
                                        <?= Yii::$app->formatter->asDate($publishDate, 'php:d F, Y') ?>
                                    </a>
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
                                <p class="blog-details__text-2"><strong><?= Html::encode($description) ?></strong></p>
                            <?php endif; ?>

                            <?php if ($content): ?>
                                <div class="blog-details__text-2">
                                    <?= $content ?>
                                </div>
                            <?php endif; ?>

                            <!-- Additional Images -->
                            <?php if (!empty($images) && count($images) > 1): ?>
                                <div class="row mt-4 mb-4">
                                    <?php foreach (array_slice($images, 1) as $image): ?>
                                        <div class="col-md-6 mb-3">
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
                        <div class="blog-details__bottom">
                            <p class="blog-details__tags">
                                <span><?= $currentLang === 'ru' ? 'Теги' : 'Teglar' ?></span>
                                <a href="#"><?= $currentLang === 'ru' ? 'Новости' : 'Yangiliklar' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?></a>
                            </p>

                            <?php
                            $contact = \common\models\Contact::getSettings();
                            if ($contact && ($contact->facebook || $contact->instagram || $contact->telegram || $contact->youtube)):
                                ?>
                                <div class="blog-details__social-list">
                                    <?php if ($contact->facebook): ?>
                                        <a href="<?= Html::encode($contact->facebook) ?>" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($contact->instagram): ?>
                                        <a href="<?= Html::encode($contact->instagram) ?>" target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($contact->telegram): ?>
                                        <a href="<?= Html::encode($contact->telegram) ?>" target="_blank">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($contact->youtube): ?>
                                        <a href="<?= Html::encode($contact->youtube) ?>" target="_blank">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <!-- Default Social Share -->
                                <div class="blog-details__social-list">
                                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(Url::to(['news', 'slug' => $model->slug], true)) ?>&text=<?= urlencode($title) ?>" target="_blank">
                                        <i class="fab fa-x-twitter"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Url::to(['news', 'slug' => $model->slug], true)) ?>" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode(Url::to(['news', 'slug' => $model->slug], true)) ?>&media=<?= urlencode($mainImage) ?>&description=<?= urlencode($title) ?>" target="_blank">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(Url::to(['news', 'slug' => $model->slug], true)) ?>" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Navigation -->
                        <div class="nav-links">
                            <?php if ($prevNews): ?>
                                <div class="prev">
                                    <a href="<?= Url::to(['news', 'slug' => $prevNews->slug]) ?>" rel="prev">
                                        <?= Html::encode($currentLang === 'ru' ? $prevNews->title_ru : $prevNews->title_uz) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($nextNews): ?>
                                <div class="next">
                                    <a href="<?= Url::to(['news', 'slug' => $nextNews->slug]) ?>" rel="next">
                                        <?= Html::encode($currentLang === 'ru' ? $nextNews->title_ru : $nextNews->title_uz) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">

                        <!-- Search -->
                        <div class="sidebar__single sidebar__search">
                            <form action="<?= Url::to(['site/index']) ?>" method="get" class="sidebar__search-form">
                                <input type="search" name="q" placeholder="<?= $currentLang === 'ru' ? 'Поиск...' : 'Qidirish...' ?>">
                                <button type="submit"><i class="lnr-icon-search"></i></button>
                            </form>
                        </div>

                        <!-- Latest News -->
                        <?php if (!empty($latestNews)): ?>
                            <div class="sidebar__single sidebar__post">
                                <h3 class="sidebar__title text-white">
                                    <?= $currentLang === 'ru' ? 'Последние новости' : 'So\'nggi yangiliklar' ?>
                                </h3>
                                <ul class="sidebar__post-list list-unstyled">
                                    <?php foreach ($latestNews as $news): ?>
                                        <?php
                                        $newsImages = $news->getImagesArray();
                                        $newsImage = !empty($newsImages) ? '/' . $newsImages[0] : '/images/resource/news1-1.jpg';
                                        $newsTitle = $currentLang === 'ru' ? $news->title_ru : $news->title_uz;
                                        ?>
                                        <li>
                                            <div class="sidebar__post-image">
                                                <img src="<?= $newsImage ?>" alt="<?= Html::encode($newsTitle) ?>">
                                            </div>
                                            <div class="sidebar__post-content">
                                                <h3>
                                                <span class="sidebar__post-content-meta">
                                                    <i class="fas fa-calendar"></i>
                                                    <?= Yii::$app->formatter->asDate($news->created_at, 'php:d.m.Y') ?>
                                                </span>
                                                    <a href="<?= Url::to(['news', 'slug' => $news->slug]) ?>">
                                                        <?= Html::encode($newsTitle) ?>
                                                    </a>
                                                </h3>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Categories (optional) -->
                        <div class="sidebar__single sidebar__category">
                            <h3 class="sidebar__title text-white">
                                <?= $currentLang === 'ru' ? 'Категории' : 'Kategoriyalar' ?>
                            </h3>
                            <ul class="sidebar__category-list list-unstyled">
                                <li>
                                    <a href="#">
                                        <?= $currentLang === 'ru' ? 'Новинки' : 'Yangiliklar' ?>
                                        <span class="icon-right-arrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <?= $currentLang === 'ru' ? 'Акции' : 'Aksiyalar' ?>
                                        <span class="icon-right-arrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <?= $currentLang === 'ru' ? 'События' : 'Voqealar' ?>
                                        <span class="icon-right-arrow"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tags -->
                        <div class="sidebar__single sidebar__tags">
                            <h3 class="sidebar__title text-white">
                                <?= $currentLang === 'ru' ? 'Теги' : 'Teglar' ?>
                            </h3>
                            <div class="sidebar__tags-list">
                                <a href="#"><?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Интерьер' : 'Interer' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Дизайн' : 'Dizayn' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Новости' : 'Yangiliklar' ?></a>
                                <a href="#"><?= $currentLang === 'ru' ? 'Акции' : 'Aksiyalar' ?></a>
                                <a href="#">BR Mebel</a>
                            </div>
                        </div>

                        <!-- Newsletter (optional) -->
                        <div class="sidebar__single" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 10px;">
                            <h3 class="text-white mb-3">
                                <i class="fas fa-envelope"></i>
                                <?= $currentLang === 'ru' ? 'Подписаться' : 'Obuna bo\'lish' ?>
                            </h3>
                            <p class="text-white mb-3">
                                <?= $currentLang === 'ru' ? 'Получайте последние новости' : 'Eng so\'nggi yangiliklarni oling' ?>
                            </p>
                            <form>
                                <div class="mb-2">
                                    <input type="email"
                                           class="form-control"
                                           placeholder="Email"
                                           style="border-radius: 5px; padding: 10px;">
                                </div>
                                <button type="submit" class="theme-btn btn-style-one w-100">
                                <span class="btn-title">
                                    <?= $currentLang === 'ru' ? 'Подписаться' : 'Obuna bo\'lish' ?>
                                </span>
                                </button>
                            </form>
                        </div>

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
?>