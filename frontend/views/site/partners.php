<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\Partner[] */

$currentLang = Yii::$app->language;
$this->title = $currentLang === 'ru' ? 'Наши партнеры' : 'Bizning hamkorlarimiz';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="feature-section">
    <div class="sec-title text-center wow fadeInUp">
        <span class="sub-title">
            <?= $currentLang === 'ru' ? 'Наши партнеры' : 'Bizning hamkorlarimiz' ?>
        </span>
        <h2>
            <?= $currentLang === 'ru' ? 'Надежные бренды' : 'Ishonchli brendlar' ?>
        </h2>
    </div>
    <div class="auto-container">
        <?php if (!empty($models)): ?>
            <?php foreach ($models as $index => $model): ?>
                <?php
                $brandName = $currentLang === 'ru' ? $model->brand_name_ru : $model->brand_name_uz;
                $description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
                $logo = $model->logo ? '/' . $model->logo : '/images/resource/feature1-1.jpg';
                $isEven = $index % 2 === 0;
                ?>

                <?php if ($isEven): ?>
                    <!-- Left Image, Right Content -->
                    <div class="row feature-row g-0">
                        <div class="image-column col-lg-4">
                            <div class="inner-column">
                                <div class="image-box">
                                    <figure class="image overlay-anim wow reveal-right">
                                        <img src="<?= $logo ?>" alt="<?= Html::encode($brandName) ?>" style="object-fit: contain; background: #fff; padding: 30px;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="content-column col-lg-8">
                            <div class="inner-column">
                                <div class="content-box">
                                    <div class="sec-title">
                                        <span class="sub-title">
                                            <?= $currentLang === 'ru' ? 'ПАРТНЕР' : 'HAMKOR' ?>
                                        </span>
                                        <h2><?= Html::encode($brandName) ?></h2>
                                        <?php if ($description): ?>
                                            <div class="text"><?= nl2br(Html::encode($description)) ?></div>
                                        <?php else: ?>
                                            <div class="text">
                                                <?= $currentLang === 'ru'
                                                    ? 'Официальный партнер компании. Мы сотрудничаем с ведущими брендами мебельной индустрии для предоставления качественной продукции нашим клиентам.'
                                                    : 'Kompaniyaning rasmiy hamkori. Biz mijozlarimizga sifatli mahsulotlarni taqdim etish uchun mebel sanoatining yetakchi brendlari bilan hamkorlik qilamiz.'
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($model->website): ?>
                                        <a href="<?= Html::encode($model->website) ?>" target="_blank" rel="nofollow" class="theme-btn btn-style-three read-more">
                                            <?= $currentLang === 'ru' ? 'Посетить сайт' : 'Saytga o\'tish' ?>
                                        </a>
                                    <?php endif; ?>
                                    <figure class="image-2"><img src="/images/resource/icon3.png" alt=""></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Left Content, Right Image -->
                    <div class="row feature-row right-align g-0">
                        <div class="content-column col-lg-8">
                            <div class="inner-column">
                                <div class="content-box">
                                    <div class="sec-title">
                                        <span class="sub-title">
                                            <?= $currentLang === 'ru' ? 'ПАРТНЕР' : 'HAMKOR' ?>
                                        </span>
                                        <h2><?= Html::encode($brandName) ?></h2>
                                        <?php if ($description): ?>
                                            <div class="text"><?= nl2br(Html::encode($description)) ?></div>
                                        <?php else: ?>
                                            <div class="text">
                                                <?= $currentLang === 'ru'
                                                    ? 'Официальный партнер компании. Мы сотрудничаем с ведущими брендами мебельной индустрии для предоставления качественной продукции нашим клиентам.'
                                                    : 'Kompaniyaning rasmiy hamkori. Biz mijozlarimizga sifatli mahsulotlarni taqdim etish uchun mebel sanoatining yetakchi brendlari bilan hamkorlik qilamiz.'
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($model->website): ?>
                                        <a href="<?= Html::encode($model->website) ?>" target="_blank" rel="nofollow" class="theme-btn btn-style-three read-more">
                                            <?= $currentLang === 'ru' ? 'Посетить сайт' : 'Saytga o\'tish' ?>
                                        </a>
                                    <?php endif; ?>
                                    <figure class="image-2"><img src="/images/resource/icon1.png" alt=""></figure>
                                </div>
                            </div>
                        </div>
                        <div class="image-column col-lg-4">
                            <div class="inner-column">
                                <div class="image-box">
                                    <figure class="image overlay-anim wow reveal-left">
                                        <img src="<?= $logo ?>" alt="<?= Html::encode($brandName) ?>" style="object-fit: contain; background: #fff; padding: 30px;">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row">
                <div class="col-12 text-center py-5">
                    <h4><?= $currentLang === 'ru' ? 'Партнеры не найдены' : 'Hamkorlar topilmadi' ?></h4>
                    <p><?= $currentLang === 'ru' ? 'В данный момент список партнеров пуст.' : 'Hozircha hamkorlar ro\'yxati bo\'sh.' ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>