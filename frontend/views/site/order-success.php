<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $order common\models\Order */

$this->title = Yii::$app->language == 'uz' ? 'Buyurtma qabul qilindi' : 'Заказ принят';
?>

<section class="page-banner">
    <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1 class="title"><?= $this->title ?></h1>
        </div>
    </div>
</section>

<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <div class="success-icon mb-4">
                        <i class="fa fa-check-circle" style="font-size: 100px; color: #4CAF50;"></i>
                    </div>

                    <h2 class="text-white mb-3">
                        <?= Yii::$app->language == 'uz' ? 'Buyurtmangiz qabul qilindi!' : 'Ваш заказ принят!' ?>
                    </h2>

                    <p class="text-muted mb-4">
                        <?= Yii::$app->language == 'uz'
                            ? 'Tez orada operatorlarimiz siz bilan bog\'lanadi va buyurtmangizni tasdiqlaydi.'
                            : 'В ближайшее время наши операторы свяжутся с вами и подтвердят ваш заказ.'
                        ?>
                    </p>

                    <div class="order-info p-4 mb-4" style="background: #2a2a2a; border-radius: 10px; border: 2px solid var(--theme-color-one);">
                        <h4 class="text-white mb-3">
                            <?= Yii::$app->language == 'uz' ? 'Buyurtma ma\'lumotlari' : 'Информация о заказе' ?>
                        </h4>

                        <div class="row text-start">
                            <div class="col-md-6 mb-3">
                                <strong class="text-white">
                                    <?= Yii::$app->language == 'uz' ? 'Buyurtma raqami:' : 'Номер заказа:' ?>
                                </strong>
                                <p class="text-muted mb-0">#<?= Html::encode($order->order_number) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong class="text-white">
                                    <?= Yii::$app->language == 'uz' ? 'Sana:' : 'Дата:' ?>
                                </strong>
                                <p class="text-muted mb-0"><?= Yii::$app->formatter->asDatetime($order->created_at) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong class="text-white">
                                    <?= Yii::$app->language == 'uz' ? 'Mijoz:' : 'Клиент:' ?>
                                </strong>
                                <p class="text-muted mb-0"><?= Html::encode($order->customer_name) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong class="text-white">
                                    <?= Yii::$app->language == 'uz' ? 'Telefon:' : 'Телефон:' ?>
                                </strong>
                                <p class="text-muted mb-0"><?= Html::encode($order->customer_phone) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong class="text-white">
                                    <?= Yii::$app->language == 'uz' ? 'Shahar:' : 'Город:' ?>
                                </strong>
                                <p class="text-muted mb-0"><?= Html::encode($order->customer_city) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong class="text-white">
                                    <?= Yii::$app->language == 'uz' ? 'Jami summa:' : 'Общая сумма:' ?>
                                </strong>
                                <p class="text-muted mb-0">
                                    <strong style="color: var(--theme-color-one); font-size: 20px;">
                                        <?= number_format($order->total_amount, 0, '.', ' ') ?>
                                        <?= Yii::$app->language == 'uz' ? 'so\'m' : 'сум' ?>
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="order-items text-start p-4 mb-4" style="background: #1a1a1a; border-radius: 10px;">
                        <h4 class="text-white mb-3">
                            <?= Yii::$app->language == 'uz' ? 'Buyurtma tarkibi' : 'Состав заказа' ?>
                        </h4>

                        <?php foreach ($order->orderItems as $item): ?>
                            <div class="order-item mb-3 p-3" style="background: #2a2a2a; border-radius: 5px;">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <strong class="text-white"><?= Html::encode($item->product_name) ?></strong>
                                        <?php if ($item->product_sku): ?>
                                            <br><small class="text-muted">SKU: <?= Html::encode($item->product_sku) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="text-muted">
                                            <?= number_format($item->price, 0, '.', ' ') ?>
                                            <?= Yii::$app->language == 'uz' ? 'so\'m' : 'сум' ?> × <?= $item->quantity ?>
                                        </div>
                                        <strong class="text-white">
                                            <?= number_format($item->subtotal, 0, '.', ' ') ?>
                                            <?= Yii::$app->language == 'uz' ? 'so\'m' : 'сум' ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="action-buttons">
                        <a href="<?= Url::to(['/']) ?>" class="theme-btn btn-style-one me-2">
                            <span class="btn-title">
                                <?= Yii::$app->language == 'uz' ? 'Bosh sahifa' : 'Главная' ?>
                            </span>
                        </a>
                        <a href="<?= Url::to(['product']) ?>" class="theme-btn btn-style-two">
                            <span class="btn-title">
                                <?= Yii::$app->language == 'uz' ? 'Xarid davom ettirish' : 'Продолжить покупки' ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        // Clear cart
        localStorage.removeItem('cart');
        updateCartCount();
    });

    function updateCartCount() {
        $('.cart-count').text(0).hide();
    }
</script>