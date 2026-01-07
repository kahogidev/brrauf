<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

$lang = Yii::$app->language;
$title = $lang == 'uz' ? 'title_uz' : 'title_ru';
$description = $lang == 'uz' ? 'description_uz' : 'description_ru';
$requirements = $lang == 'uz' ? 'requirements_uz' : 'requirements_ru';
$benefits = $lang == 'uz' ? 'benefits_uz' : 'benefits_ru';

$this->title = $model->$title;
$this->params['breadcrumbs'][] = ['label' => $lang == 'uz' ? 'Vakansiyalar' : 'Вакансии', 'url' => ['vacancy']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Page Banner Section -->
<section class="page-banner">
    <div class="bg bg-image" style="background-image: url(<?= Url::to('@web/images/background/page-banner-bg.jpg') ?>);"></div>
    <div class="auto-container">
        <div class="content-box">
            <h1 class="title"><?= Html::encode($model->$title) ?></h1>
            <ul class="bread-crumb">
                <li><?= Html::a($lang == 'uz' ? 'Bosh sahifa' : 'Главная', ['/']) ?></li>
                <li><?= Html::a($lang == 'uz' ? 'Vakansiyalar' : 'Вакансии', ['vacancy']) ?></li>
                <li><?= Html::encode($model->$title) ?></li>
            </ul>
        </div>
    </div>
</section>

<!-- Vacancy Detail Section -->
<section class="vacancy-detail-section" style="padding: 100px 0;">
    <div class="auto-container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="vacancy-detail">

                    <!-- Rasm -->
                    <?php if ($model->image): ?>
                        <div class="image-box" style="margin-bottom: 30px;">
                            <img src="/<?= $model->image ?>" alt="<?= Html::encode($model->$title) ?>" class="img-fluid" style="border-radius: 10px; width: 100%;">
                        </div>
                    <?php endif; ?>

                    <!-- Tavsif -->
                    <?php if ($model->$description): ?>
                        <div class="content-block" style="margin-bottom: 40px;">
                            <h3 style="margin-bottom: 20px; color: #2c3e50;">
                                <i class="fa fa-info-circle" style="color: #3498db;"></i>
                                <?= $lang == 'uz' ? 'Vakansiya haqida' : 'О вакансии' ?>
                            </h3>
                            <div class="text" style="line-height: 1.8; color: #555;">
                                <?= nl2br(Html::encode($model->$description)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Talablar -->
                    <?php if ($model->$requirements): ?>
                        <div class="content-block" style="margin-bottom: 40px;">
                            <h3 style="margin-bottom: 20px; color: #2c3e50;">
                                <i class="fa fa-list-check" style="color: #e74c3c;"></i>
                                <?= $lang == 'uz' ? 'Talablar' : 'Требования' ?>
                            </h3>
                            <div class="text" style="line-height: 1.8; color: #555;">
                                <?= nl2br(Html::encode($model->$requirements)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Imkoniyatlar -->
                    <?php if ($model->$benefits): ?>
                        <div class="content-block" style="margin-bottom: 40px;">
                            <h3 style="margin-bottom: 20px; color: #2c3e50;">
                                <i class="fa fa-gift" style="color: #27ae60;"></i>
                                <?= $lang == 'uz' ? 'Biz taklif qilamiz' : 'Мы предлагаем' ?>
                            </h3>
                            <div class="text" style="line-height: 1.8; color: #555;">
                                <?= nl2br(Html::encode($model->$benefits)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Apply Button -->
                    <div class="apply-button text-center" style="margin-top: 50px;">
                        <?= Html::a(
                            '<i class="fa fa-paper-plane"></i> ' . ($lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку'),
                            ['vacancy-apply', 'id' => $model->id],
                            ['class' => 'theme-btn btn-style-one', 'style' => 'font-size: 18px; padding: 15px 40px;']
                        ) ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="vacancy-sidebar">

                    <!-- Qisqa ma'lumot -->
                    <div class="widget vacancy-info" style="background: #f8f9fa; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
                        <h4 style="margin-bottom: 20px; color: #2c3e50;">
                            <?= $lang == 'uz' ? 'Vakansiya ma\'lumotlari' : 'Информация о вакансии' ?>
                        </h4>

                        <ul class="info-list" style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                <strong style="display: block; color: #555; margin-bottom: 5px;">
                                    <i class="fa fa-clock"></i> <?= $lang == 'uz' ? 'Ish turi:' : 'Тип работы:' ?>
                                </strong>
                                <span><?= $model->getEmploymentTypeName() ?></span>
                            </li>

                            <li style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                <strong style="display: block; color: #555; margin-bottom: 5px;">
                                    <i class="fa fa-money-bill"></i> <?= $lang == 'uz' ? 'Maosh:' : 'Зарплата:' ?>
                                </strong>
                                <span><?= $model->getFormattedSalary() ?></span>
                            </li>

                            <?php if ($model->deadline): ?>
                                <li style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                    <strong style="display: block; color: #555; margin-bottom: 5px;">
                                        <i class="fa fa-calendar"></i> <?= $lang == 'uz' ? 'Muddat:' : 'Срок подачи:' ?>
                                    </strong>
                                    <span><?= Yii::$app->formatter->asDate($model->deadline) ?></span>
                                </li>
                            <?php endif; ?>

                            <li>
                                <strong style="display: block; color: #555; margin-bottom: 5px;">
                                    <i class="fa fa-calendar-plus"></i> <?= $lang == 'uz' ? 'E\'lon qilingan:' : 'Опубликовано:' ?>
                                </strong>
                                <span><?= Yii::$app->formatter->asDate($model->created_at) ?></span>
                            </li>
                        </ul>

                        <div style="margin-top: 30px;">
                            <?= Html::a(
                                '<i class="fa fa-paper-plane"></i> ' . ($lang == 'uz' ? 'Ariza yuborish' : 'Отправить заявку'),
                                ['vacancy-apply', 'id' => $model->id],
                                ['class' => 'theme-btn btn-style-one w-100']
                            ) ?>
                        </div>
                    </div>

                    <!-- Boshqa vakansiyalar -->
                    <?php
                    $otherVacancies = \common\models\Vacancy::find()
                        ->where(['status' => 1])
                        ->andWhere(['!=', 'id', $model->id])
                        ->limit(3)
                        ->all();
                    ?>

                    <?php if ($otherVacancies): ?>
                        <div class="widget other-vacancies" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                            <h4 style="margin-bottom: 20px; color: #2c3e50;">
                                <?= $lang == 'uz' ? 'Boshqa vakansiyalar' : 'Другие вакансии' ?>
                            </h4>

                            <ul style="list-style: none; padding: 0;">
                                <?php foreach ($otherVacancies as $vacancy): ?>
                                    <li style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                        <?= Html::a(
                                            Html::encode($vacancy->$title),
                                            ['vacancy-view', 'id' => $vacancy->id],
                                            ['style' => 'color: #3498db; text-decoration: none; display: block; margin-bottom: 5px;']
                                        ) ?>
                                        <small style="color: #777;">
                                            <i class="fa fa-clock"></i> <?= $vacancy->getEmploymentTypeName() ?>
                                        </small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <?= Html::a(
                                ($lang == 'uz' ? 'Barcha vakansiyalar' : 'Все вакансии') . ' <i class="fa fa-arrow-right"></i>',
                                ['vacancy'],
                                ['class' => 'theme-btn btn-style-two w-100', 'style' => 'margin-top: 15px;']
                            ) ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>