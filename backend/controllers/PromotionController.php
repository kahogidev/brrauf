<?php

namespace backend\controllers;

use Yii;
use common\models\Promotion;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PromotionController CRUD controlleri
 */
class PromotionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'toggle-status' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Barcha aksiyalarni ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Promotion::find()
                ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Bitta aksiyani ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi aksiya yaratish
     */
    public function actionCreate()
    {
        $model = new Promotion();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Rasmni yuklash
            $model->uploadImage();

            if ($model->save(false)) {
                // Mahsulotlarni saqlash
                $productIds = Yii::$app->request->post('Promotion')['product_ids'] ?? [];
                if (!empty($productIds)) {
                    $model->saveProducts($productIds);
                }

                Yii::$app->session->setFlash('success', 'Aksiya muvaffaqiyatli saqlandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni saqlashda xatolik yuz berdi.');
            }
        }

        // Barcha mahsulotlarni olish
        $products = ArrayHelper::map(
            Product::find()->where(['status' => 1])->orderBy(['name_uz' => SORT_ASC])->all(),
            'id',
            'name_uz'
        );

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Aksiyani yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Yangi rasm yuklash (agar yuklangan bo'lsa)
            $model->uploadImage();

            if ($model->save(false)) {
                // Mahsulotlarni yangilash
                $productIds = Yii::$app->request->post('Promotion')['product_ids'] ?? [];
                $model->saveProducts($productIds);

                Yii::$app->session->setFlash('success', 'Aksiya muvaffaqiyatli yangilandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni yangilashda xatolik yuz berdi.');
            }
        }

        // Barcha mahsulotlarni olish
        $products = ArrayHelper::map(
            Product::find()->where(['status' => 1])->orderBy(['name_uz' => SORT_ASC])->all(),
            'id',
            'name_uz'
        );

        return $this->render('update', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Aksiyani o'chirish
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Aksiya muvaffaqiyatli o\'chirildi.');
        } else {
            Yii::$app->session->setFlash('error', 'Aksiyani o\'chirishda xatolik yuz berdi.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Aksiya statusini o'zgartirish (AJAX)
     */
    public function actionToggleStatus($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $model->status = $model->status == 1 ? 0 : 1;

        if ($model->save(false)) {
            return [
                'success' => true,
                'status' => $model->status,
                'message' => 'Status muvaffaqiyatli o\'zgartirildi.'
            ];
        }

        return ['success' => false, 'message' => 'Statusni o\'zgartirishda xatolik yuz berdi.'];
    }

    /**
     * Modelni topish
     */
    protected function findModel($id)
    {
        if (($model = Promotion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan aksiya topilmadi.');
    }
}