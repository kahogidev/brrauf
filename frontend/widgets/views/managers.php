<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\Manager[] */

$currentLang = Yii::$app->language;
?>

<!-- Service Section Three -->
<section class="service-section-three">
    <div class="auto-container">
        <div class="sec-title wow fadeInUp">
            <div class="row">
                <div class="col-lg-6">
                    <span class="sub-title">
                        <?= $currentLang === 'ru' ? 'НАША КОМАНДА' : 'BIZNING JAMOA' ?>
                    </span>
                    <h2>
                        <?= $currentLang === 'ru' ? 'Наши опытные менеджеры' : 'Bizning tajribali menejerlarimiz' ?>
                    </h2>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="text">
                        <?= $currentLang === 'ru'
                            ? 'Наша команда профессионалов готова предоставить вам лучший сервис и качественную консультацию.'
                            : 'Bizning professional jamoamiz sizga eng yaxshi xizmat va sifatli maslahat berishga tayyor.'
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-outer">
            <!-- Manager Carousel -->
            <div class="swiper service-three-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($models as $model): ?>
                        <?php
                        $position = $currentLang === 'ru' ? $model->position_ru : $model->position_uz;
                        $bio = $currentLang === 'ru' ? $model->bio_ru : $model->bio_uz;
                        $photo = $model->photo ? '/' . $model->photo : '/images/resource/service2-1.jpg';
                        ?>

                        <div class="swiper-slide">
                            <!-- service-block -->
                            <div class="service-block-three">
                                <div class="inner-box">
                                    <figure class="image">
                                        <img style="width: 370px; height: 460px; object-fit: cover" src="<?= $photo ?>" alt="<?= Html::encode($model->full_name) ?>">
                                    </figure>
                                    <div class="content-box">
                                        <h4 class="title">
                                            <a href="<?= Url::to(['/site/manager', 'id' => $model->id]) ?>">
                                                <?= Html::encode($model->full_name) ?>
                                            </a>
                                        </h4>
                                        <p class="position"><?= Html::encode($position) ?></p>
                                        <?php if ($bio): ?>
                                            <p class="text">
                                                <?= Html::encode(mb_substr($bio, 0, 100)) . '...' ?>
                                            </p>
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