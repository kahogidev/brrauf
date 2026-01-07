<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $contact common\models\Contact */

$lang = Yii::$app->language;
$address1 = $lang == 'uz' ? $contact->address1_uz : $contact->address1_ru;
$address2 = $lang == 'uz' ? $contact->address2_uz : $contact->address2_ru;
$workingHours = $lang == 'uz' ? $contact->working_hours_uz : $contact->working_hours_ru;
?>

    <!-- Main Footer -->
    <footer class="main-footer footer-style-one">
        <!-- Widgets Section -->
        <div class="widgets-section">
            <div class="auto-container">
                <div class="row">
                    <!-- Footer Column - Logo & Description -->
                    <div class="footer-column col-lg-3 col-sm-6">
                        <div class="footer-widget about-widget wow fadeInLeft">
                            <div class="widget-content">
                                <div class="logo">
                                    <a href="<?= Url::to(['/']) ?>">
                                        <img src="<?= Url::to('@web/images/logo-2.png') ?>" alt="BR Mebel" style="max-width: 200px;">
                                    </a>
                                </div>
                                <div class="text">
                                    <?= $lang == 'uz'
                                        ? 'Biz yuqori sifatli mebel ishlab chiqaramiz va professional xizmatlarni taqdim etamiz.'
                                        : 'Мы производим высококачественную мебель и предоставляем профессиональные услуги.'
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Column - Services -->
                    <div class="footer-column col-lg-3 col-sm-6 mb-0 ps-xl-5">
                        <div class="footer-widget links-widget ps-xl-5 wow fadeInLeft" data-wow-delay="200ms">
                            <h4 class="widget-title"><?= $lang == 'uz' ? 'Xizmatlar' : 'Услуги' ?></h4>
                            <div class="widget-content">
                                <ul class="user-links">
                                    <li><a href="<?= Url::to(['/site/products']) ?>"><?= $lang == 'uz' ? 'Mahsulotlar' : 'Продукция' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/portfolio']) ?>"><?= $lang == 'uz' ? 'Portfolio' : 'Портфолио' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/production']) ?>"><?= $lang == 'uz' ? 'Ishlab chiqarish' : 'Производство' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/promotions']) ?>"><?= $lang == 'uz' ? 'Aksiyalar' : 'Акции' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/news']) ?>"><?= $lang == 'uz' ? 'Yangiliklar' : 'Новости' ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Column - Company -->
                    <div class="footer-column col-lg-3 col-sm-6 mb-0 ps-xl-4">
                        <div class="footer-widget links-widget ps-xl-4 wow fadeInLeft" data-wow-delay="200ms">
                            <h4 class="widget-title"><?= $lang == 'uz' ? 'Kompaniya' : 'Компания' ?></h4>
                            <div class="widget-content">
                                <ul class="user-links">
                                    <li><a href="<?= Url::to(['/']) ?>"><?= $lang == 'uz' ? 'Bosh sahifa' : 'Главная' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/about']) ?>"><?= $lang == 'uz' ? 'Biz haqimizda' : 'О нас' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/company-history']) ?>"><?= $lang == 'uz' ? 'Tariximiz' : 'История' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/vacancy']) ?>"><?= $lang == 'uz' ? 'Vakansiyalar' : 'Вакансии' ?></a></li>
                                    <li><a href="<?= Url::to(['/site/contact']) ?>"><?= $lang == 'uz' ? 'Aloqa' : 'Контакты' ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Column - Newsletter -->
                    <div class="footer-column col-lg-3 col-sm-6">
                        <div class="footer-widget news-widget wow fadeInLeft" data-wow-delay="400ms">
                            <h4 class="widget-title"><?= $lang == 'uz' ? 'Yangiliklar' : 'Новости' ?></h4>
                            <div class="text">
                                <?= $lang == 'uz'
                                    ? 'Eng so\'nggi yangiliklar va aksiyalardan xabardor bo\'ling'
                                    : 'Будьте в курсе последних новостей и акций'
                                ?>
                            </div>
                            <div class="subscribe-form-three">
                                <form method="post" action="<?= Url::to(['/site/subscribe']) ?>">
                                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                    <div class="form-group">
                                        <input type="email"
                                               name="email"
                                               class="email"
                                               placeholder="<?= $lang == 'uz' ? 'Email manzil' : 'Email адрес' ?>"
                                               required="">
                                        <button type="submit" class="theme-btn btn-style-one">
                                            <span class="btn-title"><i class="fa fa-paper-plane"></i></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Column - Contact Info 1 -->
                    <div class="footer-column col-lg-3 col-sm-6 offset-lg-3 ps-xl-5">
                        <div class="footer-widget info-widget ps-xl-5 wow fadeInLeft" data-wow-delay="300ms">
                            <h4 class="widget-title"><?= $lang == 'uz' ? 'Asosiy manzil' : 'Основной адрес' ?></h4>
                            <div class="widget-content">
                                <div class="contact-list">
                                    <div class="inner">
                                        <?php if ($address1): ?>
                                            <div class="list-info">
                                                <span><?= Html::encode($address1) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($contact->phone1): ?>
                                            <div class="list-info">
                                                <a href="tel:<?= $contact->phone1 ?>"><?= $contact->phone1 ?></a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($contact->email): ?>
                                            <div class="list-info">

                                                <a href="mailto:<?= $contact->email ?>"><?= $contact->email ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Column - Contact Info 2 -->
                    <?php if ($address2 || $contact->phone2): ?>
                        <div class="footer-column col-lg-3 col-sm-6 ps-xl-4">
                            <div class="footer-widget info-widget ps-xl-4 wow fadeInLeft" data-wow-delay="300ms">
                                <h4 class="widget-title"><?= $lang == 'uz' ? 'Qo\'shimcha manzil' : 'Дополнительный адрес' ?></h4>
                                <div class="widget-content">
                                    <div class="contact-list">
                                        <div class="inner">
                                            <?php if ($address2): ?>
                                                <div class="list-info">

                                                    <span><?= Html::encode($address2) ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($contact->phone2): ?>
                                                <div class="list-info">

                                                    <a href="tel:<?= $contact->phone2 ?>"><?= $contact->phone2 ?></a>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($workingHours): ?>
                                                <div class="list-info">

                                                    <span><?= Html::encode($workingHours) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Footer Column - Social Media -->
                    <div class="footer-column col-lg-3 col-sm-6">
                        <div class="footer-widget widget-social wow fadeInLeft" data-wow-delay="300ms">
                            <h4 class="widget-title"><?= $lang == 'uz' ? 'Ijtimoiy tarmoqlar' : 'Социальные сети' ?></h4>
                            <div class="widget-content">
                                <ul class="social-icon">
                                    <?php if ($contact->facebook): ?>
                                        <li>
                                            <a href="<?= Html::encode($contact->facebook) ?>" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($contact->instagram): ?>
                                        <li>
                                            <a href="<?= Html::encode($contact->instagram) ?>" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($contact->linkedin): ?>
                                        <li>
                                            <a href="<?= Html::encode($contact->linkedin) ?>" target="_blank" title="LinkedIn">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($contact->telegram): ?>
                                        <li>
                                            <a href="<?= Html::encode($contact->telegram) ?>" target="_blank" title="Telegram">
                                                <i class="fab fa-telegram"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($contact->youtube): ?>
                                        <li>
                                            <a href="<?= Html::encode($contact->youtube) ?>" target="_blank" title="YouTube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="copyright-text">
                        © <?= date('Y') ?> <span>BR Mebel</span>.
                        <?= $lang == 'uz' ? 'Barcha huquqlar himoyalangan' : 'Все права защищены' ?>
                    </div>
                    <ul class="footer-nav">
                        <li>
                            <a href="<?= Url::to(['/site/privacy']) ?>">
                                <?= $lang == 'uz' ? 'Maxfiylik siyosati' : 'Политика конфиденциальности' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/site/terms']) ?>">
                                <?= $lang == 'uz' ? 'Foydalanish shartlari' : 'Условия использования' ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

<?php
// Footer uchun CSS
$this->registerCss("
    /* Contact List Info Fix */
    .contact-list .list-info {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        line-height: 1.6;
    }
    
    .contact-list .list-info i {
        flex-shrink: 0;
        margin-right: 10px;
        margin-top: 3px;
        font-size: 16px;
        color: var(--theme-color-one, #d4a574);
    }
    
    .contact-list .list-info span,
    .contact-list .list-info a {
        flex: 1;
        word-break: break-word;
    }
    
    .contact-list .list-info a {
        color: inherit;
        transition: all 0.3s;
    }
    
    .contact-list .list-info a:hover {
        color: var(--theme-color-one, #d4a574);
    }
");
?>