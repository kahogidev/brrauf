<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\ProductionVolume[] */

$currentLang = Yii::$app->language;
?>

<!-- Process Section -->
<section class="process-section p-0">
    <div class="outer-box">
        <?php
        // Birinchi rasmni background uchun olish
        $firstModel = !empty($models) ? $models[0] : null;
        $firstImages = $firstModel ? $firstModel->getImagesArray() : [];
        $bgImage = !empty($firstImages) ? '/' . $firstImages[0] : '/images/background/bg-process1.jpg';
        ?>
        <div class="bg-image-box" style="background-image: url('<?= $bgImage ?>');"></div>

        <!-- Content Slider -->
        <div class="service-two-slider">
            <?php foreach ($models as $index => $model): ?>
                <?php
                $title = $currentLang === 'ru' ? $model->title_ru : $model->title_uz;
                $description = $currentLang === 'ru' ? $model->description_ru : $model->description_uz;
                $unit = $currentLang === 'ru' ? $model->unit_ru : $model->unit_uz;
                $period = $currentLang === 'ru' ? $model->period_ru : $model->period_uz;

                $images = $model->getImagesArray();
                $bgImg = !empty($images) ? '/' . $images[0] : '/images/background/bg-process' . (($index % 2) + 1) . '.jpg';

                $count = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                ?>

                <!-- process-block -->
                <div class="process-block" style="background-image: url('<?= $bgImg ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                    <div class="inner-box">
                        <div class="content">
                            <div class="count"><?= $count ?></div>
                            <h3 class="title"><?= Html::encode($title) ?></h3>
                        </div>
                        <div class="overlay-content">
                            <div class="count"><?= $count ?></div>
                            <h3 class="title">
                                <a href="<?= Url::to(['/site/production', 'id' => $model->id]) ?>">
                                    <?= Html::encode($title) ?>
                                </a>
                            </h3>
                            <div class="text">
                                <?php if ($description): ?>
                                    <?= Html::encode($description) ?>
                                <?php else: ?>
                                    <?= Html::encode($title) ?> -
                                    <?= number_format($model->volume, 0, '.', ' ') ?> <?= Html::encode($unit) ?>
                                    <?php if ($period): ?>
                                        / <?= Html::encode($period) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/site/production', 'id' => $model->id]) ?>" class="btn-more">
                        <?= $currentLang === 'ru' ? 'УЗНАТЬ БОЛЬШЕ' : 'BATAFSIL' ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<script>
    document.querySelectorAll('[data-background]').forEach(function(element) {
        var bgImage = element.getAttribute('data-background');
        element.style.backgroundImage = 'url(' + bgImage + ')';
    });
</script>