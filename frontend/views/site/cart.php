<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->language == 'uz' ? 'Savat' : 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="page-banner">
    <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1 class="title"><?= $this->title ?></h1>
            <ul class="bread-crumb">
                <li><?= Html::a(Yii::$app->language == 'uz' ? 'Bosh sahifa' : 'Главная', ['/']) ?></li>
                <li><?= $this->title ?></li>
            </ul>
        </div>
    </div>
</section>

<section>
    <div class="container pb-100">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Empty cart message -->
                    <div id="empty-cart" class="text-center py-5" style="display: none;">
                        <i class="fa fa-shopping-cart" style="font-size: 80px; color: #ccc;"></i>
                        <h3 class="text-white mt-4">
                            <?= Yii::$app->language == 'uz' ? 'Savatingiz bo\'sh' : 'Ваша корзина пуста' ?>
                        </h3>
                        <p class="text-muted">
                            <?= Yii::$app->language == 'uz' ? 'Mahsulotlar qo\'shishni boshlang' : 'Начните добавлять товары' ?>
                        </p>
                        <a href="<?= Url::to(['product']) ?>" class="theme-btn btn-style-one mt-3">
                            <span class="btn-title">
                                <?= Yii::$app->language == 'uz' ? 'Mahsulotlarga o\'tish' : 'Перейти к товарам' ?>
                            </span>
                        </a>
                    </div>

                    <!-- Cart table -->
                    <div id="cart-content" class="table-responsive">
                        <table class="table table-dark table-striped table-bordered tbl-shopping-cart">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="text-white"><?= Yii::$app->language == 'uz' ? 'Rasm' : 'Фото' ?></th>
                                <th class="text-white"><?= Yii::$app->language == 'uz' ? 'Mahsulot' : 'Товар' ?></th>
                                <th class="text-white"><?= Yii::$app->language == 'uz' ? 'Narxi' : 'Цена' ?></th>
                                <th class="text-white"><?= Yii::$app->language == 'uz' ? 'Miqdor' : 'Количество' ?></th>
                                <th class="text-white"><?= Yii::$app->language == 'uz' ? 'Jami' : 'Итого' ?></th>
                            </tr>
                            </thead>
                            <tbody id="cart-items">
                            <!-- Cart items will be inserted here by JavaScript -->
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-white"><strong><?= Yii::$app->language == 'uz' ? 'JAMI:' : 'ВСЕГО:' ?></strong></td>
                                <td><strong><span id="cart-total">0</span> <?= Yii::$app->language == 'uz' ? 'so\'m' : 'сум' ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-end">
                                    <a href="<?= Url::to(['product']) ?>" class="theme-btn btn-style-two me-2">
                                            <span class="btn-title">
                                                <?= Yii::$app->language == 'uz' ? 'Xarid davom ettirish' : 'Продолжить покупки' ?>
                                            </span>
                                    </a>
                                    <button type="button" class="theme-btn btn-style-one" id="proceed-checkout">
                                            <span class="btn-title">
                                                <?= Yii::$app->language == 'uz' ? 'Buyurtma berish' : 'Оформить заказ' ?>
                                            </span>
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .product-thumbnail img {
        max-width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }
    .product-remove .remove {
        color: #ff4757;
        font-size: 24px;
        text-decoration: none;
        cursor: pointer;
    }
    .product-remove .remove:hover {
        color: #ff6b81;
    }
    .quantity-box {
        display: inline-flex;
        align-items: center;
        border: 1px solid #444;
        border-radius: 5px;
    }
    .quantity-box button {
        background: #333;
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        cursor: pointer;
    }
    .quantity-box button:hover {
        background: #444;
    }
    .quantity-box input {
        width: 60px;
        text-align: center;
        border: none;
        background: #222;
        color: white;
        height: 35px;
    }
</style>

<!-- Cart sahifasi oxiriga qo'shing -->
<script>
    // ENGANDA YECHIM - Ishlamay qolsa
    document.addEventListener('DOMContentLoaded', function() {
        console.log('SIMPLE CART LOADER');

        // localStorage'dan cart'ni olish
        const cartJson = localStorage.getItem('cart');
        console.log('Cart JSON:', cartJson);

        if (!cartJson || cartJson === '[]' || cartJson === 'null') {
            // Savat bo'sh
            document.getElementById('empty-cart').style.display = 'block';
            document.getElementById('cart-content').style.display = 'none';
            return;
        }

        try {
            const cart = JSON.parse(cartJson);
            console.log('Parsed cart:', cart);

            // HTML yaratish
            let html = '';
            let total = 0;

            cart.forEach((item, index) => {
                const qty = item.quantity || 1;
                const price = item.price || 0;
                const subtotal = qty * price;
                total += subtotal;

                html += `
                <tr>
                    <td><button onclick="if(confirm('O\\'chirilsinmi?')){let c=JSON.parse(localStorage.cart||'[]');c.splice(${index},1);localStorage.cart=JSON.stringify(c);location.reload()}">×</button></td>
                    <td><img src="${item.image||''}" width="60"></td>
                    <td>${item.name||''}</td>
                    <td>${(price||0).toString().replace(/\B(?=(\d{3})+(?!\d))/g,' ')} sum</td>
                    <td>
                        <button onclick="let c=JSON.parse(localStorage.cart||'[]');c[${index}].quantity=Math.max(1,(c[${index}].quantity||1)-1);localStorage.cart=JSON.stringify(c);location.reload()">-</button>
                        ${qty}
                        <button onclick="let c=JSON.parse(localStorage.cart||'[]');c[${index}].quantity=(c[${index}].quantity||1)+1;localStorage.cart=JSON.stringify(c);location.reload()">+</button>
                    </td>
                    <td>${subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g,' ')} sum</td>
                </tr>
            `;
            });

            // HTML'ni joylash
            document.getElementById('cart-items').innerHTML = html;
            document.getElementById('cart-total').textContent = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g,' ');

            // Elementlarni ko'rsatish
            document.getElementById('empty-cart').style.display = 'none';
            document.getElementById('cart-content').style.display = 'block';

        } catch (e) {
            console.error('Error loading cart:', e);
            document.getElementById('empty-cart').style.display = 'block';
            document.getElementById('cart-content').style.display = 'none';
        }
    });
</script>

<!-- TEST PANEL (faqat rivojlantirish uchun) -->
<div style="position: fixed; bottom: 10px; right: 10px; z-index: 9999; background: #333; padding: 10px; border-radius: 5px; color: white;">
    <div style="font-size: 12px; margin-bottom: 5px;">Cart Debug Panel</div>
    <button onclick="debugCart()" style="background: #2196F3; color: white; border: none; padding: 5px 10px; margin: 2px; border-radius: 3px; cursor: pointer; font-size: 12px;">Debug Cart</button>
    <button onclick="clearAndReload()" style="background: #f44336; color: white; border: none; padding: 5px 10px; margin: 2px; border-radius: 3px; cursor: pointer; font-size: 12px;">Clear Cart</button>
    <button onclick="location.reload()" style="background: #4CAF50; color: white; border: none; padding: 5px 10px; margin: 2px; border-radius: 3px; cursor: pointer; font-size: 12px;">Reload Page</button>
</div>