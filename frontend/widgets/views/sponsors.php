<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models common\models\Partner[] */
?>

<!-- Client-section two -->
<section class="client-section-two">
    <div class="auto-container">
        <div class="outer-box">
            <div class="client-slider wow fadeInUp">
                <?php foreach ($models as $model): ?>
                    <?php
                    $logo = $model->logo ? '/' . $model->logo : '/images/resource/client1-1.png';
                    $brandName = Yii::$app->language === 'ru' ? $model->brand_name_ru : $model->brand_name_uz;
                    ?>

                    <!-- client-block -->
                    <div class="client-block-two">
                        <div class="inner-box">
                            <figure class="image">
                                <?php if ($model->website): ?>
                                    <a href="<?= Html::encode($model->website) ?>" target="_blank" rel="nofollow">
                                        <img src="<?= $logo ?>" alt="<?= Html::encode($brandName) ?>">
                                    </a>
                                <?php else: ?>
                                    <img src="<?= $logo ?>" alt="<?= Html::encode($brandName) ?>">
                                <?php endif; ?>
                            </figure>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- End Client section -->