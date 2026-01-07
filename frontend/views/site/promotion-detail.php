<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Promotion */
/* @var $products common\models\Product[] */

$currentLang = Yii::$app->language;
$title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
$description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
$image = $model->image ? '/' . $model->image : '/images/resource/products/default.jpg';

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => ($currentLang === 'ru' ? 'Акции' : 'Aksiyalar'), 'url' => ['promotions']];
$this->params['breadcrumbs'][] = $title;
?>

<section class="promotion-details py-5">
    <div class="container">
        <!-- Promotion Header -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="promotion-image">
                    <img src="<?= $image ?>" alt="<?= Html::encode($title) ?>" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="promotion-info">
                    <span class="badge bg-danger mb-3" style="font-size: 24px; padding: 10px 20px;">
                        -<?= $model->discount_percent ?>% <?= $currentLang === 'ru' ? 'СКИДКА' : 'CHEGIRMA' ?>
                    </span>
                    <h2 class="text-white"><?= Html::encode($title) ?></h2>

                    <?php if ($description): ?>
                        <p class="lead"><?= nl2br(Html::encode($description)) ?></p>
                    <?php endif; ?>

                    <div class="promotion-dates mt-4">
                        <h5 class="text-white">
                            <?= $currentLang === 'ru' ? 'Период акции:' : 'Aksiya muddati:' ?>
                        </h5>
                        <p>
                            <i class="fas fa-calendar text-primary"></i>
                            <strong><?= Yii::$app->formatter->asDate($model->start_date, 'php:d F, Y') ?></strong>
                            —
                            <strong><?= Yii::$app->formatter->asDate($model->end_date, 'php:d F, Y') ?></strong>
                        </p>

                        <?php if ($model->isActive()): ?>
                            <span class="badge bg-success">
                                <?= $currentLang === 'ru' ? 'АКЦИЯ АКТИВНА' : 'AKSIYA FAOL' ?>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary">
                                <?= $currentLang === 'ru' ? 'АКЦИЯ ЗАВЕРШЕНА' : 'AKSIYA TUGAGAN' ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products in Promotion -->
        <div class="row">
            <div class="col-12">
                <h3 class="text-white mb-4">
                    <?= $currentLang === 'ru' ? 'Товары по акции' : 'Aksiyada qatnashayotgan mahsulotlar' ?>
                </h3>
            </div>

            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                    $productImages = $product->getImagesArray();
                    $productImage = !empty($productImages) ? '/' . $productImages[0] : '/images/resource/products/default.jpg';
                    $productName = $currentLang === 'ru' ? $product->name_ru : $product->name_uz;
                    $productItems = $product->activeProductItems;
                    ?>

                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product-block">
                            <div class="inner-box">
                                <div class="image" style="position: relative;">
                                    <a href="<?= Url::to(['site/product', 'slug' => $product->slug]) ?>">
                                        <img src="<?= $productImage ?>" alt="<?= Html::encode($productName) ?>"/>
                                    </a>
                                    <div class="discount-badge" style="position: absolute; top: 10px; right: 10px; background: #ff4757; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                                        -<?= $model->discount_percent ?>%
                                    </div>
                                </div>
                                <div class="content">
                                    <h4>
                                        <a href="<?= Url::to(['site/product', 'slug' => $product->slug]) ?>">
                                            <?= Html::encode($productName) ?>
                                        </a>
                                    </h4>

                                    <?php if (!empty($productItems)): ?>
                                        <div class="price-info">
                                            <?php
                                            $minPrice = min(array_map(function($item) { return $item->price; }, $productItems));
                                            $discountedPrice = $minPrice * (1 - $model->discount_percent / 100);
                                            ?>
                                            <span class="old-price" style="text-decoration: line-through; color: #999;">
                                                <?= number_format($minPrice, 0, '.', ' ') ?>
                                                <?= $currentLang === 'ru' ? 'сум' : 'so\'m' ?>
                                            </span>
                                            <br>
                                            <span class="price" style="color: #ff4757; font-weight: bold; font-size: 18px;">
                                                <?= number_format($discountedPrice, 0, '.', ' ') ?>
                                                <?= $currentLang === 'ru' ? 'сум' : 'so\'m' ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p><?= $currentLang === 'ru' ? 'Нет товаров в этой акции' : 'Bu aksiyada mahsulotlar yo\'q' ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>