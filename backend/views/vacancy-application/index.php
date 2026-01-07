<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\VacancyApplication;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $vacancy common\models\Vacancy */

$this->title = 'Vakansiya arizalari';
?>

<div class="content">
    <div class="row">
        <div class="col-lg-12">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-1"><?= Html::encode($this->title) ?></h4>
                    <?php if (isset($vacancy)): ?>
                        <p class="text-muted mb-0">
                            Vakansiya: <strong><?= Html::encode($vacancy->title_uz) ?></strong>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if (isset($vacancy)): ?>
                    <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Vakansiyaga qaytish', ['/vacancy/view', 'id' => $vacancy->id], ['class' => 'btn btn-outline-primary']) ?>
                <?php endif; ?>
            </div>

            <!-- Statistika -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Jami arizalar</h6>
                                    <h4 class="mb-0"><?= $dataProvider->totalCount ?></h4>
                                </div>
                                <div class="avatar avatar-md bg-primary-subtle text-primary">
                                    <i class="ti ti-file-text fs-20"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Yangi</h6>
                                    <h4 class="mb-0">
                                        <?= VacancyApplication::find()->where(['status' => VacancyApplication::STATUS_NEW])->count() ?>
                                    </h4>
                                </div>
                                <div class="avatar avatar-md bg-info-subtle text-info">
                                    <i class="ti ti-bell fs-20"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Qabul qilingan</h6>
                                    <h4 class="mb-0">
                                        <?= VacancyApplication::find()->where(['status' => VacancyApplication::STATUS_ACCEPTED])->count() ?>
                                    </h4>
                                </div>
                                <div class="avatar avatar-md bg-success-subtle text-success">
                                    <i class="ti ti-check fs-20"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Rad etilgan</h6>
                                    <h4 class="mb-0">
                                        <?= VacancyApplication::find()->where(['status' => VacancyApplication::STATUS_REJECTED])->count() ?>
                                    </h4>
                                </div>
                                <div class="avatar avatar-md bg-danger-subtle text-danger">
                                    <i class="ti ti-x fs-20"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Arizalar ro'yxati</h4>
                </div>
                <div class="card-body">

                    <?php Pjax::begin(); ?>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>To'liq ism</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Vakansiya</th>
                                <th>Resume</th>
                                <th>Status</th>
                                <th>Yuborilgan sana</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($dataProvider->getModels()): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr class="<?= $model->status == VacancyApplication::STATUS_NEW ? 'table-active' : '' ?>">
                                        <th scope="row"><?= $dataProvider->pagination->offset + $index + 1 ?></th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary-subtle text-primary me-2">
                                                    <span><?= strtoupper(substr($model->full_name, 0, 1)) ?></span>
                                                </div>
                                                <h6 class="mb-0 fs-14 fw-semibold">
                                                    <?= Html::encode($model->full_name) ?>
                                                </h6>
                                            </div>
                                        </td>
                                        <td><?= Html::encode($model->email) ?></td>
                                        <td><?= Html::encode($model->phone) ?></td>
                                        <td>
                                            <span class="text-dark">
                                                <?= Html::encode($model->vacancy->title_uz) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($model->resume_file): ?>
                                                <a href="/<?= $model->resume_file ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-download"></i> Yuklash
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Yo'q</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $model->getStatusBadgeClass() ?>">
                                                <?= $model->getStatusName() ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                                        </td>
                                        <td>
                                            <?= Html::a('<i class="ti ti-eye"></i>', ['view', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'Ko\'rish',
                                            ]) ?>
                                            <?= Html::a('<i class="ti ti-trash"></i>', ['delete', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'O\'chirish',
                                                'data' => [
                                                    'confirm' => 'Rostdan ham bu arizani o\'chirmoqchimisiz?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        Ma'lumot topilmadi
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?= \yii\widgets\LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination justify-content-center mt-3'],
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'active',
                        'disabledPageCssClass' => 'disabled',
                        'prevPageLabel' => '<i class="ti ti-chevron-left"></i>',
                        'nextPageLabel' => '<i class="ti ti-chevron-right"></i>',
                    ]) ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>