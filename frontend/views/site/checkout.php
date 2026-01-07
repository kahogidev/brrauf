<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = Yii::$app->language == 'uz' ? 'Buyurtma berish' : 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => Yii::$app->language == 'uz' ? 'Savat' : 'Корзина', 'url' => ['cart']];
$this->params['breadcrumbs'][] = $this->title;

// CSS
$this->registerCss(<<<CSS
    .order-item-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border: 1px solid #2d3748;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: transform 0.3s;
    }
    .order-item-card:hover {
        transform: translateY(-2px);
        border-color: #4fd1c7;
    }
    .order-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #4a5568;
    }
    .form-control {
        background-color: #2d3748;
        border: 1px solid #4a5568;
        color: #fff;
        padding: 12px 15px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .form-control:focus {
        background-color: #374151;
        border-color: #4fd1c7;
        box-shadow: 0 0 0 3px rgba(79, 209, 199, 0.1);
        color: #fff;
    }
    .form-control::placeholder {
        color: #a0aec0;
    }
    .help-block {
        color: #f56565;
        font-size: 13px;
        margin-top: 5px;
    }
    .submit-btn {
        background: linear-gradient(135deg, #4fd1c7 0%, #319795 100%);
        border: none;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        color: white;
        width: 100%;
        transition: all 0.3s;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 209, 199, 0.3);
    }
    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .total-box {
        background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%);
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }
CSS
);
?>

    <section class="page-banner">
        <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
        <div class="auto-container">
            <div class="content-box">
                <h1 class="title"><?= $this->title ?></h1>
                <ul class="bread-crumb">
                    <li><?= Html::a(Yii::$app->language == 'uz' ? 'Bosh sahifa' : 'Главная', ['/']) ?></li>
                    <li><?= Html::a(Yii::$app->language == 'uz' ? 'Savat' : 'Корзина', ['cart']) ?></li>
                    <li><?= $this->title ?></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="checkout-section pt-100 pb-100">
        <div class="container">
            <div class="row g-4">
                <!-- Order Summary -->
                <div class="col-lg-6">
                    <div class="card bg-dark border-0 shadow-lg p-4 h-100">
                        <h3 class="text-white mb-4">
                            <i class="fa fa-shopping-cart me-2"></i>
                            <?= Yii::$app->language == 'uz' ? 'Buyurtma tarkibi' : 'Состав заказа' ?>
                        </h3>

                        <div id="order-summary" class="mb-4">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted mt-3"><?= Yii::$app->language == 'uz' ? 'Savat yuklanmoqda...' : 'Загрузка корзины...' ?></p>
                            </div>
                        </div>

                        <div class="total-box">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-white mb-0">
                                    <?= Yii::$app->language == 'uz' ? 'Jami summa:' : 'Итого:' ?>
                                </h4>
                                <h2 class="text-white mb-0" id="total-amount">0 <?= Yii::$app->language == 'uz' ? 'so\'m' : 'сум' ?></h2>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="<?= Url::to(['cart']) ?>" class="btn btn-outline-light w-100">
                                <i class="fa fa-arrow-left me-2"></i>
                                <?= Yii::$app->language == 'uz' ? 'Savatga qaytish' : 'Вернуться в корзину' ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Customer Form -->
                <div class="col-lg-6">
                    <div class="card bg-dark border-0 shadow-lg p-4 h-100">
                        <h3 class="text-white mb-4">
                            <i class="fa fa-user me-2"></i>
                            <?= Yii::$app->language == 'uz' ? 'Mijoz ma\'lumotlari' : 'Данные клиента' ?>
                        </h3>

                        <?php $form = ActiveForm::begin([
                            'id' => 'checkout-form',
                            'options' => ['class' => 'needs-validation'],
                            'enableClientValidation' => false,
                            'enableAjaxValidation' => false,
                        ]); ?>

                        <input type="hidden" name="cart_data" id="cart-data-input" value="">

                        <div class="mb-3">
                            <?= $form->field($model, 'customer_name', [
                                'template' => '{label}{input}{error}',
                                'options' => ['class' => 'form-group']
                            ])->textInput([
                                'class' => 'form-control',
                                'placeholder' => Yii::$app->language == 'uz' ? 'To\'liq ismingiz' : 'Ваше полное имя',
                                'required' => true,
                                'maxlength' => true
                            ])->label(Yii::$app->language == 'uz' ? 'Ismingiz' : 'Имя') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'customer_phone', [
                                'template' => '{label}{input}{error}',
                                'options' => ['class' => 'form-group']
                            ])->textInput([
                                'class' => 'form-control',
                                'placeholder' => '+998 XX XXX XX XX',
                                'required' => true,
                                'type' => 'tel'
                            ])->label(Yii::$app->language == 'uz' ? 'Telefon raqam' : 'Номер телефона') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'customer_city', [
                                'template' => '{label}{input}{error}',
                                'options' => ['class' => 'form-group']
                            ])->textInput([
                                'class' => 'form-control',
                                'placeholder' => Yii::$app->language == 'uz' ? 'Shahar' : 'Город',
                                'required' => true
                            ])->label(Yii::$app->language == 'uz' ? 'Shahar' : 'Город') ?>
                        </div>

                        <div class="mb-3">
                            <?= $form->field($model, 'customer_address', [
                                'template' => '{label}{input}{error}',
                                'options' => ['class' => 'form-group']
                            ])->textarea([
                                'rows' => 3,
                                'class' => 'form-control',
                                'placeholder' => Yii::$app->language == 'uz' ? 'To\'liq manzil (ixtiyoriy)' : 'Полный адрес (необязательно)'
                            ])->label(Yii::$app->language == 'uz' ? 'Manzil' : 'Адрес') ?>
                        </div>

                        <div class="mb-4">
                            <?= $form->field($model, 'notes', [
                                'template' => '{label}{input}{error}',
                                'options' => ['class' => 'form-group']
                            ])->textarea([
                                'rows' => 3,
                                'class' => 'form-control',
                                'placeholder' => Yii::$app->language == 'uz' ? 'Qo\'shimcha izohlar' : 'Дополнительные примечания'
                            ])->label(Yii::$app->language == 'uz' ? 'Qo\'shimcha izoh' : 'Дополнительно') ?>
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            <?= Yii::$app->language == 'uz'
                                ? 'Buyurtmangizni qabul qilganimizdan so\'ng, tez orada siz bilan bog\'lanamiz.'
                                : 'После принятия вашего заказа мы свяжемся с вами в ближайшее время.' ?>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="submit-btn" id="submit-order-btn">
                                <i class="fa fa-check-circle me-2"></i>
                                <?= Yii::$app->language == 'uz' ? 'BUYURTMA BERISH' : 'ОФОРМИТЬ ЗАКАЗ' ?>
                            </button>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$checkoutUrl = Url::to(['checkout']);
$cartUrl = Url::to(['cart']);
$homeUrl = Url::to(['/']);

$js = <<<JS
$(document).ready(function() {
    console.log('Checkout page loaded');
    
    // Load cart summary
    loadCartSummary();
    
    // Form submit handler
    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Form submitted');
        
        // Get cart data
        const cart = getCartFromStorage();
        
        if (!cart || cart.length === 0) {
            showError('Savat bo\'sh!');
            return false;
        }
        
        // Validate form
        if (!validateForm()) {
            return false;
        }
        
        // Update hidden input
        $('#cart-data-input').val(JSON.stringify(cart));
        
        // Prepare form data
        const formData = new FormData(this);
        
        // Show loading
        const submitBtn = $('#submit-order-btn');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin me-2"></i>Jo\'natilmoqda...');
        submitBtn.prop('disabled', true);
        
        // AJAX request
        $.ajax({
            url: '{$checkoutUrl}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                
                if (response.success) {
                    // Success
                    localStorage.removeItem('cart');
                    updateCartCount();
                    
                    // Redirect to success page
                    if (response.redirectUrl) {
                        window.location.href = response.redirectUrl;
                    } else {
                        window.location.href = '{$homeUrl}';
                    }
                } else {
                    // Error
                    showError(response.message || 'Xatolik yuz berdi!');
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', {xhr, status, error});
                console.error('Response text:', xhr.responseText);
                
                let errorMessage = 'Server xatosi!';
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch(e) {
                    console.error('Error parsing response:', e);
                }
                
                showError(errorMessage);
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }
        });
        
        return false;
    });
});

function loadCartSummary() {
    const cart = getCartFromStorage();
    console.log('Cart for summary:', cart);
    
    if (!cart || cart.length === 0) {
        $('#order-summary').html(`
            <div class="text-center py-5">
                <i class="fa fa-shopping-cart mb-3" style="font-size: 60px; color: #6b7280;"></i>
                <h5 class="text-muted">Savat bo'sh</h5>
                <p class="text-muted">Buyurtma berish uchun mahsulot qo'shing</p>
                <a href="{$cartUrl}" class="btn btn-primary mt-3">Savatga o'tish</a>
            </div>
        `);
        $('#total-amount').text('0 so\'m');
        return;
    }
    
    let html = '';
    let total = 0;
    
    cart.forEach((item, index) => {
        const price = parseFloat(item.price) || 0;
        const quantity = parseInt(item.quantity) || 1;
        const subtotal = price * quantity;
        total += subtotal;
        
        html += `
            <div class="order-item-card">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="\${item.image || '/images/resource/products/default.jpg'}"
                             alt="\${item.name || ''}"
                             class="order-item-img"
                             onerror="this.src='/images/resource/products/default.jpg'">
                    </div>
                    <div class="col">
                        <h6 class="text-white mb-1">\${item.name || 'Noma\'lum mahsulot'}</h6>
                        \${item.sku ? `<small class="text-muted d-block">SKU: \${item.sku}</small>` : ''}
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-muted">
                                \${formatNumber(price)} so'm × \${quantity}
                            </span>
                            <span class="text-white fw-bold">
                                \${formatNumber(subtotal)} so'm
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    $('#order-summary').html(html);
    $('#total-amount').text(formatNumber(total) + ' so\'m');
}

function getCartFromStorage() {
    try {
        const cart = localStorage.getItem('cart');
        return cart ? JSON.parse(cart) : [];
    } catch (e) {
        console.error('Error reading cart:', e);
        return [];
    }
}

function formatNumber(num) {
    if (!num && num !== 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

function validateForm() {
    const name = $('#order-customer_name').val().trim();
    const phone = $('#order-customer_phone').val().trim();
    const city = $('#order-customer_city').val().trim();
    
    if (!name) {
        showError('Ismingizni kiriting!');
        return false;
    }
    
    if (!phone) {
        showError('Telefon raqamingizni kiriting!');
        return false;
    }
    
    if (!city) {
        showError('Shaharingizni kiriting!');
        return false;
    }
    
    return true;
}

function showError(message) {
    $('.alert-danger').remove();
    
    const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            \${message}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('#checkout-form').prepend(alertHtml);
    
    setTimeout(() => {
        $('.alert-danger').fadeOut(300, function() {
            $(this).remove();
        });
    }, 5000);
    
    // Scroll to top
    $('html, body').animate({scrollTop: $('#checkout-form').offset().top - 100}, 300);
}

function updateCartCount() {
    const cart = getCartFromStorage();
    const count = cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
    
    $('.cart-count').each(function() {
        $(this).text(count);
        if (count > 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}
JS;

$this->registerJs($js);
?>