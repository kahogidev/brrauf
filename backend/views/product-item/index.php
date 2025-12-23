<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mahsulot variantlari';
?>

<div class="content">
    <div class="row">
        <div class="col-lg-12">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                <?= Html::a('<i class="ti ti-plus me-1"></i>Yangi qo\'shish', ['create'], ['class' => 'btn btn-primary']) ?>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Mahsulot variantlari ro'yxati</h4>
                </div>
                <div class="card-body">

                    <?php Pjax::begin(); ?>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Rasm</th>
                                <th>Nomi (UZ)</th>
                                <th>Mahsulot</th>
                                <th>SKU</th>
                                <th>Narx</th>
                                <th>Status</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($dataProvider->getModels()): ?>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <th scope="row"><?= $dataProvider->pagination->offset + $index + 1 ?></th>
                                        <td>
                                            <?php $images = $model->getImagesArray(); ?>
                                            <?php if (!empty($images)): ?>
                                                <div class="avatar avatar-md avatar-rounded">
                                                    <img src="/<?= $images[0] ?>" alt="img">
                                                </div>
                                            <?php else: ?>
                                                <div class="avatar avatar-md avatar-rounded bg-secondary">
                                                    <i class="ti ti-tag fs-20"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 fs-14 fw-semibold">
                                                <?= Html::encode($model->name_uz) ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <?php if ($model->product): ?>
                                                <span class="badge bg-primary-subtle text-primary-emphasis">
                                                        <?= Html::encode($model->product->name_uz) ?>
                                                    </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($model->sku): ?>
                                                <code class="text-muted"><?= Html::encode($model->sku) ?></code>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success"><?= $model->getFormattedPrice() ?></span>
                                        </td>
                                        <td>
                                            <?php if ($model->status == 1): ?>
                                                <span class="badge badge-outline-success">Faol</span>
                                            <?php else: ?>
                                                <span class="badge badge-outline-danger">Nofaol</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= Html::a('<i class="ti ti-eye"></i>', ['view', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'Ko\'rish',
                                            ]) ?>
                                            <?= Html::a('<i class="ti ti-pencil"></i>', ['update', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'Tahrirlash',
                                            ]) ?>
                                            <?= Html::a('<i class="ti ti-trash"></i>', ['delete', 'id' => $model->id], [
                                                'class' => 'link-reset fs-18 p-1',
                                                'title' => 'O\'chirish',
                                                'data' => [
                                                    'confirm' => 'Rostdan ham bu variantni o\'chirmoqchimisiz?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
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