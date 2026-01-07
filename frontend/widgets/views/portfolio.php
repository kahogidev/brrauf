<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\Portfolio[] */

$currentLang = Yii::$app->language;
?>

<!-- Service Section Three -->
<section class="service-section-three style-home14 pt-0">
    <div class="outer-box">
        <div class="sec-title text-center wow fadeInUp">

            <h2>
                <?= $currentLang === 'ru' ? 'Наши Портфолио' : 'Bizning Portfolio' ?>
            </h2>
        </div>
        <div class="carousel-outer">
            <!-- Project Carousel -->
            <div class="swiper service-three-slider-home7">
                <div class="swiper-wrapper">
                    <?php foreach ($models as $model): ?>
                        <?php
                        $title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
                        $description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
                        $images = $model->getImagesArray();
                        $firstImage = !empty($images) ? $images[0] : 'images/resource/service3-1.jpg';
                        ?>

                        <div class="swiper-slide">
                            <!-- service-block -->
                            <div class="service-block-three">
                                <div class="inner-box">
                                    <figure class="image overlay-anim">
                                        <?php if (!empty($images)): ?>
                                            <img style="width: 370px; height: 460px; object-fit: cover" src="/<?= $firstImage ?>" alt="<?= Html::encode($title) ?>">
                                        <?php else: ?>
                                            <img src="/images/resource/service3-1.jpg" alt="<?= Html::encode($title) ?>">
                                        <?php endif; ?>
                                    </figure>
                                    <div class="content-box">
                                        <h4 class="title">
                                            <a href="<?= Url::to(['/site/portfolio-view', 'id' => $model->id]) ?>">
                                                <?= Html::encode($title) ?>
                                            </a>
                                        </h4>
                                        <?php if ($description): ?>
                                            <p class="text"><?= Html::encode($description) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>