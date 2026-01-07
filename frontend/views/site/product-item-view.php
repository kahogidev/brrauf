<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ProductItem */
/* @var $relatedItems common\models\ProductItem[] */

$currentLang = Yii::$app->language;
$itemName = $currentLang === 'ru' ? $model->name_ru : $model->name_uz;
$productName = $currentLang === 'ru' ? $model->product->name_ru : $model->product->name_uz;
$description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
$categoryName = $currentLang === 'ru' ? $model->product->category->name_ru : $model->product->category->name_uz;

$images = $model->getImagesArray();
$firstImage = !empty($images) ? '/' . $images[0] : '/images/resource/products/product-details.jpg';

$this->title = $itemName;
$this->params['breadcrumbs'][] = ['label' => ($currentLang === 'ru' ? 'Товары' : 'Mahsulotlar'), 'url' => ['product']];
$this->params['breadcrumbs'][] = ['label' => $categoryName, 'url' => ['product', 'category' => $model->product->category->slug]];
$this->params['breadcrumbs'][] = $itemName;
?>

<section class="product-details">
    <div class="container pb-70">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="bxslider">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $index => $image): ?>
                            <div class="slider-content">
                                <figure class="image-box">
                                    <a href="/<?= $image ?>" class="lightbox-image" data-fancybox="gallery">
                                        <img src="/<?= $image ?>" alt="<?= Html::encode($itemName) ?>">
                                    </a>
                                </figure>
                                <div class="slider-pager">
                                    <ul class="thumb-box">
                                        <?php foreach ($images as $thumbIndex => $thumb): ?>
                                            <li>
                                                <a class="<?= $thumbIndex === 0 ? 'active' : '' ?>" data-slide-index="<?= $thumbIndex ?>" href="#">
                                                    <figure><img src="/<?= $thumb ?>" alt=""></figure>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="slider-content">
                            <figure class="image-box">
                                <img src="<?= $firstImage ?>" alt="<?= Html::encode($itemName) ?>">
                            </figure>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6 product-info">
                <div class="product-details__top">
                    <h3 class="product-details__title text-white">
                        <?= Html::encode($itemName) ?>
                        <span><?= number_format($model->price, 0, '.', ' ') ?> <?= $currentLang === 'ru' ? 'сум' : 'so\'m' ?></span>
                    </h3>
                </div>

                <div class="product-details__reveiw">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>

                <div class="product-details__content">
                    <?php if ($description): ?>
                        <p class="product-details__content-text1"><?= nl2br(Html::encode($description)) ?></p>
                    <?php endif; ?>

                    <p class="product-details__content-text2">
                        <strong class="text-white"><?= $currentLang === 'ru' ? 'Продукт:' : 'Mahsulot:' ?></strong>
                        <?= Html::encode($productName) ?>
                        <br>
                        <strong class="text-white"><?= $currentLang === 'ru' ? 'Категория:' : 'Kategoriya:' ?></strong>
                        <?= Html::encode($categoryName) ?>
                        <?php if ($model->sku): ?>
                            <br>
                            <strong class="text-white">SKU:</strong> <?= Html::encode($model->sku) ?>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="product-details__quantity">
                    <h3 class="product-details__quantity-title text-white">
                        <?= $currentLang === 'ru' ? 'Выберите количество' : 'Miqdorni tanlang' ?>
                    </h3>
                    <div class="quantity-box">
                        <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                        <input type="number" id="quantity" value="1" min="1" />
                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                    </div>
                </div>

                <div class="product-details__buttons">
                    <div class="product-details__buttons-1">
                        <a href="javascript:void(0);" class="theme-btn btn-style-one add-to-cart-detail"
                           data-id="<?= $model->id ?>"
                           data-name="<?= Html::encode($itemName) ?>"
                           data-price="<?= $model->price ?>"
                           data-image="<?= $firstImage ?>"
                           data-sku="<?= $model->sku ?>">
                            <span class="btn-title">
                                <?= $currentLang === 'ru' ? 'В корзину' : 'Savatga qo\'shish' ?>
                            </span>
                        </a>
                    </div>
                    <div class="product-details__buttons-2">
                        <a href="javascript:void(0);" class="theme-btn btn-style-one like-btn-detail" data-id="<?= $model->id ?>">
                            <span class="btn-title">
                                <?= $currentLang === 'ru' ? 'В избранное' : 'Sevimlilar' ?>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="product-details__social">
                    <div class="title mt-10">
                        <h3 class="text-white mb-2">
                            <?= $currentLang === 'ru' ? 'Поделиться с друзьями' : 'Do\'stlar bilan ulashish' ?>
                        </h3>
                    </div>
                    <ul class="social-icon-two d-flex align-items-center gap-3 ms-4 product-share">
                        <li>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(Url::to(['product-item', 'id' => $model->id], true)) ?>&text=<?= urlencode($itemName) ?>" target="_blank">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Url::to(['product-item', 'id' => $model->id], true)) ?>" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode(Url::to(['product-item', 'id' => $model->id], true)) ?>&media=<?= urlencode($firstImage) ?>&description=<?= urlencode($itemName) ?>" target="_blank">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="navigator.clipboard.writeText(window.location.href).then(function() { alert('<?= $currentLang === 'ru' ? 'Ссылка скопирована!' : 'Link nusxalandi!' ?>'); }); return false;">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if (!empty($relatedItems)): ?>
            <!-- Related Products -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-white mb-4">
                        <?= $currentLang === 'ru' ? 'Похожие товары' : 'O\'xshash mahsulotlar' ?>
                    </h3>
                </div>

                <?php foreach ($relatedItems as $item): ?>
                    <?php
                    $relatedImages = $item->getImagesArray();
                    $relatedImage = !empty($relatedImages) ? '/' . $relatedImages[0] : '/images/resource/products/default.jpg';
                    $relatedName = $currentLang === 'ru' ? $item->name_ru : $item->name_uz;
                    ?>

                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product-block">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="<?= Url::to(['product-item', 'id' => $item->id]) ?>">
                                        <img src="<?= $relatedImage ?>" alt="<?= Html::encode($relatedName) ?>"/>
                                    </a>
                                </div>
                                <div class="content">
                                    <h4>
                                        <a href="<?= Url::to(['product-item', 'id' => $item->id]) ?>">
                                            <?= Html::encode($relatedName) ?>
                                        </a>
                                    </h4>
                                    <span class="price">
                                        <?= number_format($item->price, 0, '.', ' ') ?>
                                        <?= $currentLang === 'ru' ? 'сум' : 'so\'m' ?>
                                    </span>
                                </div>
                                <div class="icon-box">
                                    <a href="javascript:void(0);" class="ui-btn like-btn" data-id="<?= $item->id ?>">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="ui-btn add-to-cart-btn-related"
                                       data-id="<?= $item->id ?>"
                                       data-name="<?= Html::encode($relatedName) ?>"
                                       data-price="<?= $item->price ?>"
                                       data-image="<?= $relatedImage ?>"
                                       data-sku="<?= $item->sku ?>">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    $(document).ready(function() {
        // Initialize cart count
        updateCartCount();

        // Quantity controls
        $('.add').click(function() {
            var $input = $(this).siblings('input');
            $input.val(parseInt($input.val()) + 1);
        });

        $('.sub').click(function() {
            var $input = $(this).siblings('input');
            var val = parseInt($input.val());
            if (val > 1) {
                $input.val(val - 1);
            }
        });

        // Add to cart with quantity (main product)
        $('.add-to-cart-detail').click(function(e) {
            e.preventDefault();
            const $this = $(this);
            const itemId = $this.data('id');
            const itemName = $this.data('name');
            const itemPrice = $this.data('price');
            const itemImage = $this.data('image');
            const itemSku = $this.data('sku') || '';
            const quantity = parseInt($('#quantity').val());

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

            // Show modal
            showCartModal(itemName);
        });

        // Add to cart (related products)
        $(document).on('click', '.add-to-cart-btn-related', function(e) {
            e.preventDefault();
            const $this = $(this);
            const itemId = $this.data('id');
            const itemName = $this.data('name');
            const itemPrice = $this.data('price');
            const itemImage = $this.data('image');
            const itemSku = $this.data('sku') || '';

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

            // Visual feedback
            $this.addClass('active');
            setTimeout(function() {
                $this.removeClass('active');
            }, 300);

            showCartModal(itemName);
        });

        // Wishlist functionality
        $('.like-btn-detail, .like-btn').click(function(e) {
            e.preventDefault();
            const $this = $(this);
            const itemId = $this.data('id');

            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const index = wishlist.indexOf(itemId);

            if (index > -1) {
                wishlist.splice(index, 1);
                $this.removeClass('active');
                $this.find('i').css('color', '');
            } else {
                wishlist.push(itemId);
                $this.addClass('active');
                $this.find('i').css('color', '#ff4757');
            }

            localStorage.setItem('wishlist', JSON.stringify(wishlist));
        });

        // Check wishlist status on load
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const itemId = <?= $model->id ?>;
        if (wishlist.includes(itemId)) {
            $('.like-btn-detail').addClass('active');
        }

        wishlist.forEach(function(id) {
            $(`.like-btn[data-id="${id}"]`).addClass('active').find('i').css('color', '#ff4757');
        });
    });

    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const count = cart.reduce((sum, item) => sum + item.quantity, 0);
        $('.cart-count').text(count);
        if (count > 0) {
            $('.cart-count').show();
        } else {
            $('.cart-count').hide();
        }
    }

    function showCartModal(itemName) {
        const lang = '<?= $currentLang ?>';
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

        // Create modal HTML
        const modalHtml = `
        <div class="cart-modal-overlay" id="cartModal">
            <div class="cart-modal">
                <div class="cart-modal-header">
                    <i class="fa fa-check-circle" style="color: #4CAF50; font-size: 48px;"></i>
                    <h3 style="margin: 15px 0 10px;">${msg.title}</h3>
                    <p style="color: #666;">${msg.message}</p>
                </div>
                <div class="cart-modal-buttons">
                    <a href="<?= Url::to(['cart']) ?>" class="theme-btn btn-style-one">
                        <span class="btn-title">${msg.viewCart}</span>
                    </a>
                    <button class="theme-btn btn-style-two close-modal">
                        <span class="btn-title">${msg.continueShopping}</span>
                    </button>
                </div>
            </div>
        </div>
    `;

        // Remove existing modal
        $('#cartModal').remove();

        // Append new modal
        $('body').append(modalHtml);

        // Close modal handlers
        $('.close-modal').click(function() {
            $('#cartModal').fadeOut(300, function() {
                $(this).remove();
            });
        });

        $('.cart-modal-overlay').click(function(e) {
            if (e.target === this) {
                $(this).fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });

        // Auto close
        setTimeout(function() {
            $('#cartModal').fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
</script>

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
        z-index: 9999;
        animation: fadeIn 0.3s;
    }

    .cart-modal {
        background: white;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
        max-width: 500px;
        animation: slideUp 0.3s;
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
</style>