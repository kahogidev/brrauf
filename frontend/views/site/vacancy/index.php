<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Vacancy;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vakansiyalar';
$this->params['breadcrumbs'][] = $this->title;

// Til
$lang = Yii::$app->language;
$title = $lang == 'uz' ? 'title_uz' : 'title_ru';
$description = $lang == 'uz' ? 'description_uz' : 'description_ru';
$requirements = $lang == 'uz' ? 'requirements_uz' : 'requirements_ru';
?>

<!-- Page Banner Section -->
<section class="page-banner">
    <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1 class="title"><?= $lang == 'uz' ? 'Vakansiyalar' : 'Вакансии' ?></h1>
            <ul class="bread-crumb">
                <li><?= Html::a($lang == 'uz' ? 'Bosh sahifa' : 'Главная', ['/']) ?></li>
                <li><?= $lang == 'uz' ? 'Vakansiyalar' : 'Вакансии' ?></li>
            </ul>
        </div>
    </div>
</section>

<!-- Vacancy Section -->
<section class="client-section" style="padding: 100px 0;">
    <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/icons/pattern-1.jpg') ?>);"></div>
    <div class="auto-container">
        <div class="sec-title text-center">
            <span class="sub-title"><?= $lang == 'uz' ? 'Bizning jamoamizga qo\'shiling' : 'Присоединяйтесь к нашей команде' ?></span>
            <h2><?= $lang == 'uz' ? 'Ochiq vakansiyalar' : 'Открытые вакансии' ?></h2>
        </div>

        <?php if ($dataProvider->getModels()): ?>
            <div class="row">
                <?php foreach ($dataProvider->getModels() as $index => $vacancy): ?>
                    <!-- Vacancy Block -->
                    <div class="client-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box wow fadeInLeft" data-wow-delay="<?= $index * 100 ?>ms">

                            <!-- Rasm -->
                            <div class="image-box">
                                <?php if ($vacancy->image): ?>
                                    <figure class="image wow fadeInUp">
                                        <img style="width: 340px; height: 230px; object-fit: cover" src="/<?= $vacancy->image ?>" alt="<?= Html::encode($vacancy->$title) ?>">
                                    </figure>
                                <?php else: ?>
                                    <figure class="image wow fadeInUp">
                                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                                            <i class="fa fa-briefcase" style="font-size: 60px; color: white;"></i>
                                        </div>
                                    </figure>
                                <?php endif; ?>

                                <!-- Badge -->
                                <?php if ($vacancy->deadline): ?>
                                    <span class="badge" style="position: absolute; top: 10px; right: 10px; background: #ff5722; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px;">
                                        <?= $lang == 'uz' ? 'Muddati' : 'Срок' ?>: <?= Yii::$app->formatter->asDate($vacancy->deadline) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Lavozim -->
                            <h4 class="title"><?= Html::encode($vacancy->$title) ?></h4>

                            <!-- Ish turi va Maosh -->
                            <div style="margin: 10px 0;">
                                <span class="badge" style="background: #4caf50; color: white; padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                    <i class="fa fa-clock"></i> <?= $vacancy->getEmploymentTypeName() ?>
                                </span>
                                <span class="badge" style="background: #2196f3; color: white; padding: 5px 10px; border-radius: 5px;">
                                    <i class="fa fa-money-bill"></i> <?= $vacancy->getFormattedSalary() ?>
                                </span>
                            </div>

                            <!-- Qisqacha tavsif -->
                            <div class="text">
                                <?php
                                $desc = $vacancy->$description;
                                if ($desc) {
                                    echo mb_substr(strip_tags($desc), 0, 120, 'UTF-8') . '...';
                                }
                                ?>
                            </div>

                            <!-- Tugma -->
                            <div style="margin-top: 20px;">
                                <?= Html::a(
                                    '<i class="fa fa-arrow-right"></i> ' . ($lang == 'uz' ? 'Batafsil' : 'Подробнее'),
                                    ['vacancy-view', 'id' => $vacancy->id],
                                    ['class' => 'theme-btn btn-style-one']
                                ) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="text-center" style="margin-top: 50px;">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'pagination'],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
                    'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
                ]) ?>
            </div>

        <?php else: ?>
            <!-- Vakansiya yo'q -->
            <div class="text-center" style="padding: 100px 0;">
                <i class="fa fa-briefcase" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
                <h3><?= $lang == 'uz' ? 'Hozircha ochiq vakansiyalar yo\'q' : 'На данный момент нет открытых вакансий' ?></h3>
                <p style="color: #777;">
                    <?= $lang == 'uz'
                        ? 'Keyinroq qayta tashrif buyuring yoki bizga rezyumeingizni yuborishingiz mumkin.'
                        : 'Посетите позже или отправьте нам свое резюме.'
                    ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>