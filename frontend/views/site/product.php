<?php
use frontend\assets\ProductAsset;
ProductAsset::register($this);
?>

<section class="featured-products">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="shop-sidebar">
                    <div class="sidebar-search">
                        <form action="<?= \yii\helpers\Url::to(['site/product']) ?>" method="get" class="search-form">
                            <div class="form-group">
                                <input type="search" name="q" placeholder="<?= Yii::$app->language == 'ru' ? 'Поиск...' : 'Qidirish...' ?>" value="<?= Yii::$app->request->get('q') ?>">
                                <button type="submit"><i class="lnr lnr-icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h5 class="widget-title text-white">
                                <?= Yii::$app->language == 'ru' ? 'Категории' : 'Kategoriyalar' ?>
                            </h5>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                <?php
                                use common\models\Category;
                                $categories = Category::find()
                                    ->where(['status' => 1])
                                    ->orderBy(['sort_order' => SORT_ASC])
                                    ->all();
                                ?>

                                <li class="<?= !Yii::$app->request->get('category') ? 'active' : '' ?>">
                                    <a href="<?= \yii\helpers\Url::to(['site/product']) ?>">
                                        <?= Yii::$app->language == 'ru' ? 'Все' : 'Barchasi' ?>
                                    </a>
                                </li>

                                <?php foreach ($categories as $category): ?>
                                    <li class="<?= Yii::$app->request->get('category') == $category->slug ? 'active' : '' ?>">
                                        <a href="<?= \yii\helpers\Url::to(['site/product', 'category' => $category->slug]) ?>">
                                            <?= Yii::$app->language == 'uz' ? $category->name_uz : $category->name_ru ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Popular Products Widget -->
                    <div class="sidebar-widget post-widget">
                        <div class="widget-title">
                            <h5 class="widget-title text-white">
                                <?= Yii::$app->language == 'ru' ? 'Популярные товары' : 'Mashhur mahsulotlar' ?>
                            </h5>
                        </div>
                        <div class="post-inner">
                            <?php
                            use common\models\Product;
                            $popularProducts = Product::find()
                                ->where(['status' => 1])
                                ->orderBy(['id' => SORT_DESC])
                                ->limit(3)
                                ->all();
                            ?>

                            <?php foreach ($popularProducts as $product): ?>
                                <?php
                                $images = $product->getImagesArray();
                                $firstImage = !empty($images) ? '/' . $images[0] : '/images/resource/products/thumb-default.jpg';
                                $productName = Yii::$app->language == 'uz' ? $product->name_uz : $product->name_ru;
                                ?>
                                <div class="post">
                                    <figure class="post-thumb">
                                        <a href="<?= \yii\helpers\Url::to(['site/product', 'slug' => $product->slug]) ?>">
                                            <img src="<?= $firstImage ?>" alt="<?= \yii\helpers\Html::encode($productName) ?>">
                                        </a>
                                    </figure>
                                    <a href="<?= \yii\helpers\Url::to(['site/product', 'slug' => $product->slug]) ?>">
                                        <?= \yii\helpers\Html::encode($productName) ?>
                                    </a>
                                    <span class="text-muted small">
                                        <?= Yii::$app->language == 'uz' ? $product->category->name_uz : $product->category->name_ru ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                <div class="mixitup-gallery mt-5 mt-lg-0">
                    <div class="filters clearfix">
                        <ul class="filter-tabs filter-btns clearfix">
                            <?php
                            use common\models\ProductItem;

                            $categorySlug = Yii::$app->request->get('category');
                            $searchQuery = Yii::$app->request->get('q');

                            $itemQuery = ProductItem::find()
                                ->joinWith(['product', 'product.category'])
                                ->where(['product_items.status' => 1, 'products.status' => 1]);

                            if ($categorySlug) {
                                $category = Category::findOne(['slug' => $categorySlug, 'status' => 1]);
                                if ($category) {
                                    $itemQuery->andWhere(['products.category_id' => $category->id]);
                                }
                            }

                            if ($searchQuery) {
                                $itemQuery->andWhere(['or',
                                    ['like', 'product_items.name_uz', $searchQuery],
                                    ['like', 'product_items.name_ru', $searchQuery],
                                    ['like', 'products.name_uz', $searchQuery],
                                    ['like', 'products.name_ru', $searchQuery],
                                ]);
                            }

                            $allItems = $itemQuery->all();

                            $itemsByCategory = [];
                            foreach ($allItems as $item) {
                                $catName = Yii::$app->language == 'uz' ? $item->product->category->name_uz : $item->product->category->name_ru;
                                if (!isset($itemsByCategory[$catName])) {
                                    $itemsByCategory[$catName] = [];
                                }
                                $itemsByCategory[$catName][] = $item;
                            }
                            ?>

                            <li class="active filter" data-role="button" data-filter="all">
                                <?= Yii::$app->language == 'ru' ? 'Все' : 'Barchasi' ?>
                            </li>
                            <?php foreach ($itemsByCategory as $catName => $items): ?>
                                <li class="filter" data-role="button" data-filter=".<?= strtolower(str_replace(' ', '-', $catName)) ?>">
                                    <?= $catName ?> (<?= count($items) ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="filter-list row">
                        <?php foreach ($allItems as $item): ?>
                            <?php
                            $images = $item->getImagesArray();
                            $firstImage = !empty($images) ? '/' . $images[0] : '/images/resource/products/default.jpg';
                            $itemName = Yii::$app->language == 'uz' ? $item->name_uz : $item->name_ru;
                            $productName = Yii::$app->language == 'uz' ? $item->product->name_uz : $item->product->name_ru;
                            $categoryClass = strtolower(str_replace(' ', '-', Yii::$app->language == 'uz' ? $item->product->category->name_uz : $item->product->category->name_ru));
                            ?>

                            <div class="product-block all mix <?= $categoryClass ?> col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        <a href="<?= \yii\helpers\Url::to(['site/product-item', 'id' => $item->id]) ?>">
                                            <img src="<?= $firstImage ?>" alt="<?= \yii\helpers\Html::encode($itemName) ?>"/>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="category-info">
                                            <?= Yii::$app->language == 'uz' ? $item->product->category->name_uz : $item->product->category->name_ru ?>
                                        </div>

                                        <h4>
                                            <a href="<?= \yii\helpers\Url::to(['site/product-item', 'id' => $item->id]) ?>">
                                                <?= \yii\helpers\Html::encode($itemName) ?>
                                            </a>
                                        </h4>

                                        <div class="product-variant-info">
                                            <small class="text-muted"><?= \yii\helpers\Html::encode($productName) ?></small>
                                        </div>

                                        <?php if ($item->sku): ?>
                                            <div class="sku-info">
                                                <small class="text-muted">SKU: <?= \yii\helpers\Html::encode($item->sku) ?></small>
                                            </div>
                                        <?php endif; ?>

                                        <span class="price"><?= number_format($item->price, 0, '.', ' ') ?>
                                            <?= Yii::$app->language == 'ru' ? 'сум' : 'so\'m' ?>
                                        </span>

                                        <span class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </div>
                                    <div class="icon-box">
                                        <a href="javascript:void(0);" class="ui-btn like-btn" data-id="<?= $item->id ?>" title="<?= Yii::$app->language == 'uz' ? 'Sevimlilar' : 'В избранное' ?>">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="ui-btn add-to-cart-btn"
                                           data-id="<?= $item->id ?>"
                                           data-name="<?= \yii\helpers\Html::encode($itemName) ?>"
                                           data-price="<?= $item->price ?>"
                                           data-image="<?= $firstImage ?>"
                                           data-sku="<?= $item->sku ?>"
                                           title="<?= Yii::$app->language == 'uz' ? 'Savatga qo\'shish' : 'В корзину' ?>">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (empty($allItems)): ?>
                        <div class="row">
                            <div class="col-12 text-center" style="padding: 50px 0;">
                                <h4><?= Yii::$app->language == 'ru' ? 'Товары не найдены' : 'Mahsulotlar topilmadi' ?></h4>
                                <p><?= Yii::$app->language == 'ru' ? 'В этой категории пока нет товаров.' : 'Bu kategoriyada hozircha mahsulotlar yo\'q.' ?></p>
                                <a href="<?= \yii\helpers\Url::to(['site/product']) ?>" class="theme-btn btn-style-one">
                                    <span class="btn-title"><?= Yii::$app->language == 'ru' ? 'Все товары' : 'Barcha mahsulotlar' ?></span>
                                </a>
                            </div>
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
    .product-block .category-info {
        display: inline-block;
        padding: 3px 8px;
        background: #f0f0f0;
        border-radius: 3px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .product-variant-info {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    .sku-info {
        font-size: 11px;
        color: #999;
        margin-bottom: 8px;
    }
    .ui-btn {
        transition: all 0.3s ease;
    }
    .ui-btn:hover {
        transform: scale(1.1);
    }
    .ui-btn.active {
        background-color: #4CAF50 !important;
    }
</style>

<script>
    console.log('jQuery loaded:', typeof jQuery !== 'undefined');
    console.log('$ loaded:', typeof $ !== 'undefined');

    // Agar jQuery yuklanmagan bo'lsa
    if (typeof jQuery === 'undefined') {
        console.error('jQuery yuklanmagan! Iltimos yuklab oling.');
    }
</script>

<!-- FIXED VERSION: Cart JavaScript (jQuery bilan va siz) -->
<script>
    // jQuery tayyor bo'lishini kutish
    (function($) {
        'use strict';

        $(document).ready(function() {
            console.log('Cart script loaded');

            // Initialize
            updateCartCount();
            loadWishlist();
        });

        // Add to cart - BUTTON click bilan
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Add to cart clicked');

            const $btn = $(this);
            const itemId = parseInt($btn.data('id'));
            const itemName = $btn.data('name');
            const itemPrice = parseFloat($btn.data('price'));
            const itemImage = $btn.data('image');
            const itemSku = $btn.data('sku') || '';

            console.log('Item:', {itemId, itemName, itemPrice, itemImage, itemSku});

            if (!itemId || !itemName || !itemPrice) {
                alert('Xatolik: Mahsulot ma\'lumotlari to\'liq emas!');
                return false;
            }

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id === itemId);

            if (existingItem) {
                existingItem.quantity++;
                console.log('Quantity increased:', existingItem.quantity);
            } else {
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    image: itemImage,
                    sku: itemSku,
                    quantity: 1
                });
                console.log('New item added to cart');
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            console.log('Cart saved:', cart);

            updateCartCount();

            // Visual feedback
            $btn.addClass('active');
            setTimeout(function() {
                $btn.removeClass('active');
            }, 300);

            showCartModal(itemName);

            return false;
        });

        // Add to cart detail (with quantity)
        $(document).on('click', '.add-to-cart-detail', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(this);
            const itemId = parseInt($btn.data('id'));
            const itemName = $btn.data('name');
            const itemPrice = parseFloat($btn.data('price'));
            const itemImage = $btn.data('image');
            const itemSku = $btn.data('sku') || '';
            const quantity = parseInt($('#quantity').val()) || 1;

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id === itemId);

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    image: itemImage,
                    sku: itemSku,
                    quantity: quantity
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            showCartModal(itemName);

            return false;
        });

        // Add to cart related products
        $(document).on('click', '.add-to-cart-btn-related', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(this);
            const itemId = parseInt($btn.data('id'));
            const itemName = $btn.data('name');
            const itemPrice = parseFloat($btn.data('price'));
            const itemImage = $btn.data('image');
            const itemSku = $btn.data('sku') || '';

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id === itemId);

            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    image: itemImage,
                    sku: itemSku,
                    quantity: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();

            $btn.addClass('active');
            setTimeout(function() {
                $btn.removeClass('active');
            }, 300);

            showCartModal(itemName);

            return false;
        });

        // Wishlist
        $(document).on('click', '.like-btn, .like-btn-detail', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(this);
            const itemId = parseInt($btn.data('id'));

            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const index = wishlist.indexOf(itemId);

            if (index > -1) {
                wishlist.splice(index, 1);
                $btn.removeClass('active');
                $btn.find('i').css('color', '');
            } else {
                wishlist.push(itemId);
                $btn.addClass('active');
                $btn.find('i').css('color', '#ff4757');
            }

            localStorage.setItem('wishlist', JSON.stringify(wishlist));

            return false;
        });

        // Update cart count
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);

            console.log('Cart count:', count);

            $('.cart-count').text(count);

            if (count > 0) {
                $('.cart-count').show();
            } else {
                $('.cart-count').hide();
            }
        }

        // Load wishlist
        function loadWishlist() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            wishlist.forEach(function(itemId) {
                $(`.like-btn[data-id="${itemId}"], .like-btn-detail[data-id="${itemId}"]`)
                    .addClass('active')
                    .find('i')
                    .css('color', '#ff4757');
            });
        }

        // Show cart modal
        function showCartModal(itemName) {
            const lang = $('html').attr('lang') || 'uz';
            const messages = {
                uz: {
                    title: 'Savatga qo\'shildi!',
                    message: itemName + ' savatga qo\'shildi',
                    viewCart: 'Savatni ko\'rish',
                    continueShopping: 'Xarid davom ettirish'
                },
                ru: {
                    title: 'Добавлено в корзину!',
                    message: itemName + ' добавлен в корзину',
                    viewCart: 'Перейти в корзину',
                    continueShopping: 'Продолжить покупки'
                }
            };

            const msg = messages[lang] || messages['uz'];
            const cartUrl = '<?= \yii\helpers\Url::to(["site/cart"]) ?>';

            const modalHtml = `
            <div class="cart-modal-overlay" id="cartModal">
                <div class="cart-modal">
                    <div class="cart-modal-header">
                        <i class="fa fa-check-circle" style="color: #4CAF50; font-size: 48px;"></i>
                        <h3 style="margin: 15px 0 10px; color: #333;">${msg.title}</h3>
                        <p style="color: #666;">${msg.message}</p>
                    </div>
                    <div class="cart-modal-buttons">
                        <a href="${cartUrl}" class="theme-btn btn-style-one">
                            <span class="btn-title">${msg.viewCart}</span>
                        </a>
                        <button type="button" class="theme-btn btn-style-two close-modal">
                            <span class="btn-title">${msg.continueShopping}</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

            $('#cartModal').remove();
            $('body').append(modalHtml);

            $('.close-modal').on('click', function() {
                $('#cartModal').fadeOut(300, function() {
                    $(this).remove();
                });
            });

            $('.cart-modal-overlay').on('click', function(e) {
                if (e.target === this) {
                    $(this).fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });

            setTimeout(function() {
                $('#cartModal').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Global functions
        window.updateCartCount = updateCartCount;
        window.showCartModal = showCartModal;

    })(jQuery);
</script>

<!-- Modal CSS -->
<style>
    .cart-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        animation: fadeIn 0.3s;
    }

    .cart-modal {
        background: white;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
        max-width: 500px;
        animation: slideUp 0.3s;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    }

    .cart-modal-header {
        margin-bottom: 30px;
    }

    .cart-modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cart-modal-buttons .theme-btn {
        margin: 0;
    }

    .ui-btn.active {
        background-color: #4CAF50 !important;
        transform: scale(1.1);
    }

    .ui-btn {
        transition: all 0.3s ease;
    }

    .ui-btn:hover {
        transform: scale(1.1);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>