<?php

use yii\helpers\Url;

?>
<!-- Banner Section -->
<section class="banner-section-six">

    <div class="banner-slider banner-slider-home7">

        <!-- banner-slide -->
        <div class="banner-slide">
            <div class="inner-slide">
                <div class="anim-icons">
                    <img class="image-1" src="images/icons/shape-house8.png" alt="">
                </div>
                <div class="auto-container">
                    <div class="outer-box">
                        <div class="row">
                            <!-- Content Column -->
                            <div class="content-column col-lg-7 col-md-6">
                                <div class="inner-column">
                                    <h1 class="title wow fadeInUp" data-wow-delay="300ms"><?=Yii::t('app', 'slogan1')?></h1>
                                    <div class="btn-box wow fadeInUp" data-wow-delay="800ms">
                                        <a href="<?= Url::to(['/site/contact']) ?>" class="theme-btn btn-style-two"><span class="btn-title"><?=Yii::t('app', 'more1')?></span></a>
                                        <div class="video-box">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Image Column -->
                            <div class="image-column col-lg-5 col-md-6">
                                <div class="inner-column wow fadeInRight" data-wow-delay="200ms">
                                    <figure class="image-1"><img src="images/banner/banner.jpg" alt=""></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>