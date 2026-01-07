<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $contact common\models\Contact */

$lang = Yii::$app->language;
$address = $lang == 'uz' ? 'address1_uz' : 'address1_ru';
?>

<!-- Main Header-->
<header class="main-header header-style-two style-two style-dark">
    <div class="header-top">
        <div class="auto-container">
            <div class="inner-box">
                <!-- top-left -->
                <div class="top-left">
                    <span>
                        <i class="icon fa-solid fa-phone"></i>
                        <a href="tel:<?= $contact->phone1 ?>"><?= $contact->phone1 ?></a>
                    </span>
                    <span>
                        <i class="icon fa-sharp fa-solid fa-location-dot"></i>
                        <?= $contact->$address ?>
                    </span>
                </div>



                <!-- Top-right -->
                <div class="top-right">
                    <div class="info-link">
                        <li class="nav-space nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-color navbar-text-color"
                               href="#"
                               id="navbarDropdownLanguage"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false"
                               style="padding: 8px 15px;">
                                <i class="fa fa-globe" style="font-size: 18px;"></i>
                                <span class="ms-1" style="font-size: 12px; text-transform: uppercase;">
            <?= substr(Yii::$app->language, 0, 2) ?>
        </span>
                            </a>
                            <div class="dropdown-menu drop-down-content">
                                <ul style="color:black" class="list-unstyled drop-down-pages">
                                    <?= \frontend\widgets\LanguageSwitcher::widget() ?>
                                </ul>
                            </div>
                        </li>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="auto-container">
        <!-- Main box -->
        <div class="main-box px-sm-0">
            <div class="logo-box">
                <div class="logo">
                    <a href="<?= Url::to(['/']) ?>">
                        <img  src="<?= Url::to('@web/images/logo.png') ?>" style="width: 200px" alt="" title="BR Mebel">
                    </a>
                </div>
            </div>

            <!--Nav Box-->
            <div class="nav-outer">
                <nav class="nav main-menu">
                    <ul class="navigation">
                        <li>
                            <a href="<?= Url::to(['/']) ?>"><?= $lang == 'uz' ? 'Bosh sahifa' : 'Главная' ?></a>
                        </li>

                        <li class="dropdown">
                            <a href="#"><?= $lang == 'uz' ? 'Kompaniya' : 'Компания' ?></a>
                            <ul>
                                <li>
                                    <a href="<?= Url::to(['/site/about']) ?>">
                                        <?= $lang == 'uz' ? 'Biz haqimizda' : 'О нас' ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/site/partners']) ?>"><?= $lang == 'uz' ? 'Hamkorlarimiz' : 'Сотрудники ' ?></a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/site/vacancy']) ?>">
                                        <?= $lang == 'uz' ? 'Vakansiyalar' : 'Вакансии' ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['/site/contact']) ?>"><?= $lang == 'uz' ? 'Aloqa' : 'Контакты' ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/site/portfolio']) ?>"><?= $lang == 'uz' ? 'Portfolio' : 'Портфолио' ?></a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/site/product']) ?>"><?= $lang == 'uz' ? 'Mahsulotlar' : 'Продукция' ?></a>
                        </li>

                        <li>
                            <a href="<?= Url::to(['/site/promotions']) ?>"><?= $lang == 'uz' ? 'Aksiyalar' : 'Акции ' ?></a>
                        </li>


                    </ul>
                </nav>
                <!-- Main Menu End-->
            </div>

            <div class="outer-box">
                <div class="ui-btn-outer">
                    <a href="<?= Url::to(['/cart']) ?>" class="ui-btn cart-btn">
                        <i class="lnr-icon-shopping-cart"></i>
                    </a>
                </div>
                <div class="mobile-nav-toggler"><i class="icon lnr-icon-bars"></i></div>
            </div>
        </div>

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <nav class="menu-box">
                <div class="upper-box">
                    <div class="nav-logo">
                        <a href="<?= Url::to(['/']) ?>">
                            <img style="width: 150px!important; object-fit: cover" src="<?= Url::to('@web/images/logo-2.png') ?>" alt="">
                        </a>
                    </div>
                    <div class="close-btn"><i class="icon fa fa-times"></i></div>
                </div>

                <ul class="navigation clearfix">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </ul>

                <ul class="contact-list-one">
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <i class="icon lnr-icon-phone-handset"></i>
                            <span class="title"><?= $lang == 'uz' ? 'Hozir qo\'ng\'iroq qiling' : 'Позвоните сейчас' ?></span>
                            <a href="tel:<?= $contact->phone1 ?>"><?= $contact->phone1 ?></a>
                        </div>
                    </li>

                    <?php if ($contact->phone2): ?>
                        <li>
                            <div class="contact-info-box">
                                <i class="icon lnr-icon-phone-handset"></i>
                                <span class="title"><?= $lang == 'uz' ? 'Ikkinchi telefon' : 'Второй телефон' ?></span>
                                <a href="tel:<?= $contact->phone2 ?>"><?= $contact->phone2 ?></a>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <span class="icon lnr-icon-envelope1"></span>
                            <span class="title"><?= $lang == 'uz' ? 'Email yuborish' : 'Отправить Email' ?></span>
                            <a href="mailto:<?= $contact->email ?>"><?= $contact->email ?></a>
                        </div>
                    </li>

                    <?php if ($contact->working_hours_uz || $contact->working_hours_ru): ?>
                        <li>
                            <!-- Contact Info Box -->
                            <div class="contact-info-box">
                                <span class="icon lnr-icon-clock"></span>
                                <span class="title"><?= $lang == 'uz' ? 'Ish vaqti' : 'Рабочее время' ?></span>
                                <?= $lang == 'uz' ? $contact->working_hours_uz : $contact->working_hours_ru ?>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="social-links">
                    <?php if ($contact->facebook): ?>
                        <li><a href="<?= $contact->facebook ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <?php endif; ?>

                    <?php if ($contact->instagram): ?>
                        <li><a href="<?= $contact->instagram ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <?php endif; ?>

                    <?php if ($contact->linkedin): ?>
                        <li><a href="<?= $contact->linkedin ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <?php endif; ?>

                    <?php if ($contact->youtube): ?>
                        <li><a href="<?= $contact->youtube ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                    <?php endif; ?>

                    <?php if ($contact->telegram): ?>
                        <li><a href="<?= $contact->telegram ?>" target="_blank"><i class="fab fa-telegram"></i></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div><!-- End Mobile Menu -->

        <!-- Header Search -->
        <div class="search-popup">
            <span class="search-back-drop"></span>
            <button class="close-search"><span class="fa fa-times"></span></button>
            <div class="search-inner">
                <form method="get" action="<?= Url::to(['/site/search']) ?>">
                    <div class="form-group">
                        <input type="search" name="q" value="" placeholder="<?= $lang == 'uz' ? 'Qidirish...' : 'Поиск...' ?>" required="">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Header Search -->

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="inner-container">
                    <!--Logo-->
                    <div class="logo">
                        <a href="<?= Url::to(['/']) ?>">
                            <img style="width: 150px; object-fit: cover" src="<?= Url::to('@web/images/logo-2.png') ?>" alt="">
                        </a>
                    </div>
                    <!--Right Col-->
                    <div class="nav-outer">
                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <div class="navbar-collapse show collapse clearfix">
                                <ul class="navigation clearfix">
                                    <!--Keep This Empty / Menu will come through Javascript-->
                                </ul>
                            </div>
                        </nav><!-- Main Menu End-->
                        <!--Mobile Navigation Toggler-->
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    </div>
                </div>
            </div>
        </div><!-- End Sticky Menu -->
    </div>
</header>