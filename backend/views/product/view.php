<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name_uz;
?>

<div class="content pb-0">

    <div class="row">
        <div class="col-lg-10 mx-auto">

            <h6 class="mb-3 fs-14">
                <?= Html::a('<i class="ti ti-arrow-left me-1"></i>Ortga', ['index'], ['class' => '']) ?>
            </h6>

            <div class="card">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex align-items-center justify-content-between border-1 border-bottom pb-3 mb-3">
                        <div>
                            <h4 class="mb-1"><?= Html::encode($model->name_uz) ?></h4>
                            <div class="d-flex align-items-center gap-2">
                                <?php if ($model->category): ?>
                                    <span class="badge bg-primary-subtle text-primary-emphasis">
                                        <?= Html::encode($model->category->name_uz) ?>
                                    </span>
                                <?php endif; ?>
                                <code class="text-muted"><?= Html::encode($model->slug) ?></code>
                            </div>
                        </div>
                        <div>
                            <?php if ($model->status == 1): ?>
                                <span class="badge bg-success-subtle text-success-emphasis">Faol</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger-emphasis">Nofaol</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Ma'lumotlar -->
                    <div class="row pb-3 border-1 border-bottom mb-4">
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">O'zbekcha</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Nomi:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->name_uz) ?></p>
                            </div>
                            <?php if ($model->description_uz): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Tavsif:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_uz)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="mb-3 fs-16 fw-bold">Русский</h5>
                            <div class="mb-3">
                                <p class="text-body mb-1">Название:</p>
                                <p class="text-dark fw-semibold"><?= Html::encode($model->name_ru) ?></p>
                            </div>
                            <?php if ($model->description_ru): ?>
                                <div class="mb-3">
                                    <p class="text-body mb-1">Описание:</p>
                                    <p class="text-dark"><?= nl2br(Html::encode($model->description_ru)) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Rasmlar -->
                    <?php if (!empty($model->getImagesArray())): ?>
                        <div class="mb-4">
                            <h6 class="mb-3 fs-16 fw-bold">Rasmlar</h6>
                            <div class="row">
                                <?php foreach ($model->getImagesArray() as $image): ?>
                                    <div class="col-md-3 mb-3">
                                        <div class="border rounded p-2">
                                            <img src="/<?= $image ?>" class="img-fluid rounded" alt="Rasm">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Mahsulot variantlari -->
                    <?php if (!empty($model->productItems)): ?>
                        <div class="mb-4">
                            <h6 class="mb-3 fs-16 fw-bold">Mahsulot variantlari (<?= count($model->productItems) ?> ta)</h6>
                            <div class="table-responsive">
                                <table class="table table-nowrap border">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nomi</th>
                                        <th>SKU</th>
                                        <th>Narx</th>
                                        <th>Status</th>
                                        <th>Harakat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($model->productItems as $index => $item): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= Html::encode($item->name_uz) ?></td>
                                            <td><code><?= Html::encode($item->sku) ?></code></td>
                                            <td><strong><?= $item->getFormattedPrice() ?></strong></td>
                                            <td>
                                                <?= $item->status == 1 ? '<span class="badge badge-outline-success">Faol</span>' : '<span class="badge badge-outline-danger">Nofaol</span>' ?>
                                            </td>
                                            <td>
                                                <?= Html::a('Ko\'rish', ['/product-item/view', 'id' => $item->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Qo'shimcha ma'lumotlar -->
                    <div class="row pb-3 mb-3 border-1 border-bottom">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Tartiblash:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= $model->sort_order ?></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Yaratilgan:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></h6>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Status:</h6>
                                <h6 class="fs-14 fw-semibold text-dark">
                                    <?= $model->status == 1 ? 'Faol' : 'Nofaol' ?>
                                </h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fs-14 fw-medium text-body">Yangilangan:</h6>
                                <h6 class="fs-14 fw-semibold text-dark"><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Tugmalar -->
                    <div class="text-center d-flex align-items-center justify-content-center gap-2">
                        <?= Html::a('<i class="ti ti-pencil me-1"></i>Tahrirlash', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-primary d-flex align-items-center'
                        ]) ?>
                        <?= Html::a('<i class="ti ti-trash me-1"></i>O\'chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-md btn-danger d-flex align-items-center',
                            'data' => [
                                'confirm' => 'Rostdan ham bu mahsulotni o\'chirmoqchimisiz?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>