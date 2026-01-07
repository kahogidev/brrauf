<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\News[] */

$currentLang = Yii::$app->language;
?>

<!-- News-Section -->
<section class="news-section style-two">
    <div class="bg bg-image" style="background-image: url(/images/icons/shape-2.png);"></div>
    <div class="auto-container">
        <div class="sec-title text-center wow fadeInUp">
            <span class="sub-title">
                <?= $currentLang === 'ru' ? 'НОВОСТИ' : 'YANGILIKLAR' ?>
            </span>
            <h2>
                <?= $currentLang === 'ru' ? 'Последние новости' : 'So\'nggi yangiliklar' ?>
            </h2>
        </div>
        <div class="row">
            <?php foreach ($models as $index => $model): ?>
                <?php
                $title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
                $description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
                $images = $model->getImagesArray();
                $firstImage = !empty($images) ? '/' . $images[0] : '/images/resource/news1-1.jpg';

                $delay = $index * 300;

                // Sanani formatlash
                $date = $model->published_date
                    ? Yii::$app->formatter->asDate($model->published_date, 'php:M d, Y')
                    : Yii::$app->formatter->asDate($model->created_at, 'php:M d, Y');
                ?>

                <!-- News Block -->
                <div class="news-block col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= $delay ?>ms">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="<?= Url::to(['/site/news', 'slug' => $model->slug]) ?>">
                                    <img src="<?= $firstImage ?>" alt="<?= Html::encode($title) ?>">
                                    <img src="<?= $firstImage ?>" alt="<?= Html::encode($title) ?>">
                                </a>
                            </figure>
                        </div>
                        <div class="content-box">
                            <ul class="post-meta">
                                <li class="categories">
                                    <a href="<?= Url::to(['/site/news', 'slug' => $model->slug]) ?>">
                                        <?= $currentLang === 'ru' ? 'Новости' : 'Yangilik' ?>
                                    </a>
                                </li>
                                <li class="date"><?= $date ?></li>
                            </ul>
                            <h4 class="title">
                                <a href="<?= Url::to(['/site/news', 'slug' => $model->slug]) ?>">
                                    <?= Html::encode($title) ?>
                                </a>
                            </h4>
                            <?php if ($description): ?>
                                <p class="text">
                                    <?= Html::encode(mb_substr($description, 0, 100)) . '...' ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End News Section -->