(function($) {
    'use strict';

    console.log('Product Cart script loaded');
    console.log('jQuery version:', $.fn.jquery);

    $(document).ready(function() {
        console.log('Document ready');
        updateCartCount();
        loadWishlist();

        // MixItUp plugin ishlatilsa
        if ($.fn.mixItup) {
            $('.filter-list').mixItUp();
        }
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
        const cartUrl = '/site/cart'; // URL'ni o'zgartiring

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