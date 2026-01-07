<?php
use common\helpers\UploadHelper;
use common\helpers\YouTubeHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Portfolio */
/* @var $prevModel common\models\Portfolio */
/* @var $nextModel common\models\Portfolio */

$currentLang = Yii::$app->language;
$title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
$description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
$content = $currentLang === 'ru' ? $model->content_ru : $model->content_uz;
$companyName = $currentLang === 'ru' ? $model->company_name_ru : $model->company_name_uz;

$images = $model->getImagesArray();
$videos = $model->getVideosArray();
$mainImage = !empty($images) ? '/' . $images[0] : '/images/resource/service-details.jpg';

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => ($currentLang === 'ru' ? 'Портфолио' : 'Portfolio'), 'url' => ['index']];
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
                    <li><?= Html::a($currentLang === 'ru' ? 'Портфолио' : 'Portfolio', ['/site/index']) ?></li>
                    <li><?= Html::encode($title) ?></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Project Details -->
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

                            <?php if ($model->project_date): ?>
                                <div class="blog-details__date">
                                    <span class="day"><?= Yii::$app->formatter->asDate($model->project_date, 'php:d') ?></span>
                                    <span class="month"><?= Yii::$app->formatter->asDate($model->project_date, 'php:M') ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="blog-details__content">
                            <ul class="list-unstyled blog-details__meta">
                                <?php if ($model->project_date): ?>
                                    <li>
                                        <a href="#"><i class="fas fa-calendar"></i> <?= Yii::$app->formatter->asDate($model->project_date, 'php:d F, Y') ?></a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="#"><i class="fas fa-user-circle"></i> <?= Html::encode($companyName) ?></a>
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
                                <p class="blog-details__text-2"><?= nl2br(Html::encode($description)) ?></p>
                            <?php endif; ?>

                            <?php if ($content): ?>
                                <div class="content">
                                    <?= $content ?>
                                </div>
                            <?php endif; ?>

                            <!-- Gallery Images -->
                            <?php if (!empty($images) && count($images) > 1): ?>
                                <h4 class="text-white mt-5 mb-3">
                                    <?= $currentLang === 'ru' ? 'Галерея проекта' : 'Loyiha galereyasi' ?>
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

                        <!-- Social Share -->
                        <div class="blog-details__bottom mt-4">
                            <p class="blog-details__tags">
                                <span><?= $currentLang === 'ru' ? 'Теги' : 'Teglar' ?></span>
                                <a href="#"><?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?></a>
                                <a href="#">Portfolio</a>
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
                            <?php if ($prevModel): ?>
                                <?php $prevTitle = $currentLang === 'ru' ? $prevModel->title_ru : $prevModel->title_uz; ?>
                                <div class="prev">
                                    <a href="<?= Url::to(['/site/portfolio', 'id' => $prevModel->id]) ?>" rel="prev">
                                        <?= Html::encode($prevTitle) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($nextModel): ?>
                                <?php $nextTitle = $currentLang === 'ru' ? $nextModel->title_ru : $nextModel->title_uz; ?>
                                <div class="next">
                                    <a href="<?= Url::to(['/site/portfolio', 'id' => $nextModel->id]) ?>" rel="next">
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

                        <!-- Project Details Box -->
                        <div class="sidebar__single project-details__details-box mb-4">
                            <h3 class="sidebar__title text-white mb-3">
                                <?= $currentLang === 'ru' ? 'Детали проекта' : 'Loyiha tafsilotlari' ?>
                            </h3>
                            <ul class="list-unstyled project-details__details-list">
                                <?php if ($model->project_date): ?>
                                    <li>
                                        <p class="project-details__client">
                                            <?= $currentLang === 'ru' ? 'Дата' : 'Sana' ?>
                                        </p>
                                        <h4 class="project-details__name">
                                            <?= Yii::$app->formatter->asDate($model->project_date, 'php:d F, Y') ?>
                                        </h4>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <p class="project-details__client">
                                        <?= $currentLang === 'ru' ? 'Клиент' : 'Mijoz' ?>
                                    </p>
                                    <h4 class="project-details__name">
                                        <?= Html::encode($companyName) ?>
                                    </h4>
                                </li>

                                <?php if ($model->company_logo): ?>
                                    <li>
                                        <p class="project-details__client">
                                            <?= $currentLang === 'ru' ? 'Логотип' : 'Logo' ?>
                                        </p>
                                        <div class="mt-2">
                                            <img src="<?= Url::to(['/portfolio/logo', 'path' => $model->company_logo]) ?>"
                                                 alt="<?= Html::encode($companyName) ?>"
                                                 style="max-width: 150px; max-height: 80px;">
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <p class="project-details__client">
                                        <?= $currentLang === 'ru' ? 'Категория' : 'Kategoriya' ?>
                                    </p>
                                    <h4 class="project-details__name">
                                        <?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?>
                                    </h4>
                                </li>
                            </ul>
                        </div>

                        <!-- Latest Projects -->
                        <?php
                        $latestProjects = \common\models\Portfolio::find()
                            ->where(['status' => 1])
                            ->andWhere(['!=', 'id', $model->id])
                            ->orderBy(['created_at' => SORT_DESC])
                            ->limit(3)
                            ->all();
                        ?>
                        <?php if ($latestProjects): ?>
                            <div class="sidebar__single sidebar__post">
                                <h3 class="sidebar__title text-white">
                                    <?= $currentLang === 'ru' ? 'Последние проекты' : 'So\'nggi loyihalar' ?>
                                </h3>
                                <ul class="sidebar__post-list list-unstyled">
                                    <?php foreach ($latestProjects as $project): ?>
                                        <?php
                                        $projectTitle = $currentLang === 'ru' ? $project->title_ru : $project->title_uz;
                                        $projectImages = $project->getImagesArray();
                                        ?>
                                        <li>
                                            <div class="sidebar__post-image">
                                                <?php if (!empty($projectImages)): ?>
                                                    <img src="/<?= $projectImages[0] ?>" alt="<?= Html::encode($projectTitle) ?>">
                                                <?php else: ?>
                                                    <img src="/images/resource/news1-1.jpg" alt="<?= Html::encode($projectTitle) ?>">
                                                <?php endif; ?>
                                            </div>
                                            <div class="sidebar__post-content">
                                                <h3>
                                                <span class="sidebar__post-content-meta">
                                                    <i class="fas fa-calendar"></i>
                                                    <?= Yii::$app->formatter->asDate($project->created_at, 'php:d.m.Y') ?>
                                                </span>
                                                    <a href="<?= Url::to(['/site/portfolio', 'id' => $project->id]) ?>">
                                                        <?= Html::encode($projectTitle) ?>
                                                    </a>
                                                </h3>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Tags -->
                        <div class="sidebar__single sidebar__tags">
                            <h3 class="sidebar__title text-white"><?= $currentLang === 'ru' ? 'Теги' : 'Teglar' ?></h3>
                            <div class="sidebar__tags-list">
                                <a href="#"><?= $currentLang === 'ru' ? 'Мебель' : 'Mebel' ?></a>
                                <a href="#">Portfolio</a>
                                <a href="#">Design</a>
                                <a href="#">Interior</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Pagination (qo'shimcha, agar kerak bo'lsa) -->
            <div class="row mt-5">
                <div class="col-xl-12">
                    <div class="project-details__pagination-box">
                        <ul class="project-details__pagination list-unstyled clearfix">
                            <?php if ($prevModel): ?>
                                <li class="next">
                                    <div class="icon">
                                        <a href="<?= Url::to(['/site/portfolio', 'id' => $prevModel->id]) ?>" aria-label="Previous">
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

                            <li class="count">
                                <a href="<?= Url::to(['/site/index']) ?>">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>

                            <?php if ($nextModel): ?>
                                <li class="previous">
                                    <div class="content">
                                        <?= $currentLang === 'ru' ? 'Следующий' : 'Keyingi' ?>
                                    </div>
                                    <div class="icon">
                                        <a href="<?= Url::to(['/site/portfolio', 'id' => $nextModel->id]) ?>" aria-label="Next">
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
?>