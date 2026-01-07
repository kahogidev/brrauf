<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $promotions common\models\Promotion[] */

$currentLang = Yii::$app->language;
$this->title = $currentLang === 'ru' ? 'Акции' : 'Aksiyalar';
$this->params['breadcrumbs'][] = $this->title;

$currentFilter = Yii::$app->request->get('filter');
?>

<section class="featured-products">
    <div class="auto-container">
        <div class="sec-title text-center wow fadeInUp mb-5">
            <span class="sub-title">
                <?= $currentLang === 'ru' ? 'СПЕЦИАЛЬНЫЕ ПРЕДЛОЖЕНИЯ' : 'MAXSUS TAKLIFLAR' ?>
            </span>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>

        <div class="row clearfix">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="shop-sidebar">
                    <!-- Filter Widget -->
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h5 class="widget-title text-white">
                                <?= $currentLang === 'ru' ? 'Фильтр' : 'Filter' ?>
                            </h5>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                <li class="<?= !$currentFilter ? 'active' : '' ?>">
                                    <a href="<?= Url::to(['site/promotions']) ?>">
                                        <?= $currentLang === 'ru' ? 'Все акции' : 'Barcha aksiyalar' ?>
                                    </a>
                                </li>
                                <li class="<?= $currentFilter === 'active' ? 'active' : '' ?>">
                                    <a href="<?= Url::to(['site/promotions', 'filter' => 'active']) ?>">
                                        <?= $currentLang === 'ru' ? 'Активные' : 'Faol aksiyalar' ?>
                                    </a>
                                </li>
                                <li class="<?= $currentFilter === 'upcoming' ? 'active' : '' ?>">
                                    <a href="<?= Url::to(['site/promotions', 'filter' => 'upcoming']) ?>">
                                        <?= $currentLang === 'ru' ? 'Предстоящие' : 'Kelgusi aksiyalar' ?>
                                    </a>
                                </li>
                                <li class="<?= $currentFilter === 'expired' ? 'active' : '' ?>">
                                    <a href="<?= Url::to(['site/promotions', 'filter' => 'expired']) ?>">
                                        <?= $currentLang === 'ru' ? 'Завершенные' : 'Tugagan aksiyalar' ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                <div class="row">
                    <?php if (!empty($promotions)): ?>
                        <?php foreach ($promotions as $promotion): ?>
                            <?php
                            $title = $currentLang === 'ru' ? $promotion->title_ru : $promotion->title_uz;
                            $description = $currentLang === 'ru' ? $promotion->description_ru : $promotion->description_uz;
                            $image = $promotion->image ? '/' . $promotion->image : '/images/resource/products/default.jpg';
                            $isActive = $promotion->isActive();
                            $productsCount = count($promotion->products);
                            ?>

                            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="promotion-block">
                                    <div class="inner-box" style="border: 2px solid <?= $isActive ? '#4CAF50' : '#ccc' ?>; border-radius: 10px; overflow: hidden;">
                                        <div class="image" style="position: relative;">
                                            <a href="<?= Url::to(['site/promotion', 'id' => $promotion->id]) ?>">
                                                <img src="<?= $image ?>" alt="<?= Html::encode($title) ?>" style="width: 100%; height: 300px; object-fit: cover;"/>
                                            </a>
                                            <div class="discount-badge" style="position: absolute; top: 20px; right: 20px; background: #ff4757; color: white; padding: 10px 20px; border-radius: 50px; font-weight: bold; font-size: 18px;">
                                                -<?= $promotion->discount_percent ?>%
                                            </div>
                                            <?php if ($isActive): ?>
                                                <div class="status-badge" style="position: absolute; top: 20px; left: 20px; background: #4CAF50; color: white; padding: 5px 15px; border-radius: 5px; font-size: 12px;">
                                                    <?= $currentLang === 'ru' ? 'АКТИВНО' : 'FAOL' ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="content" style="padding: 20px;">
                                            <h4>
                                                <a href="<?= Url::to(['site/promotion', 'id' => $promotion->id]) ?>">
                                                    <?= Html::encode($title) ?>
                                                </a>
                                            </h4>

                                            <?php if ($description): ?>
                                                <p class="text-muted" style="font-size: 14px;">
                                                    <?= Html::encode(mb_substr($description, 0, 100)) ?>...
                                                </p>
                                            <?php endif; ?>

                                            <div class="promotion-info mt-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="text-muted" style="font-size: 13px;">
                                                        <i class="fas fa-calendar"></i>
                                                        <?= Yii::$app->formatter->asDate($promotion->start_date, 'php:d.m.Y') ?>
                                                        -
                                                        <?= Yii::$app->formatter->asDate($promotion->end_date, 'php:d.m.Y') ?>
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted" style="font-size: 13px;">
                                                        <i class="fas fa-box"></i>
                                                        <?= $productsCount ?> <?= $currentLang === 'ru' ? 'товаров' : 'mahsulot' ?>
                                                    </span>
                                                    <a href="<?= Url::to(['site/promotion', 'id' => $promotion->id]) ?>" class="theme-btn btn-style-one btn-sm">
                                                        <span class="btn-title">
                                                            <?= $currentLang === 'ru' ? 'Подробнее' : 'Batafsil' ?>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center" style="padding: 50px 0;">
                            <h4><?= $currentLang === 'ru' ? 'Акции не найдены' : 'Aksiyalar topilmadi' ?></h4>
                            <p><?= $currentLang === 'ru' ? 'В данный момент нет активных акций.' : 'Hozirda faol aksiyalar yo\'q.' ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .category-list li.active a {
        color: #4CAF50;
        font-weight: 600;
    }
    .promotion-block .inner-box {
        transition: all 0.3s ease;
    }
    .promotion-block .inner-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
</style>