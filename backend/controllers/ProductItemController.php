<?php

namespace backend\controllers;

use Yii;
use common\models\ProductItem;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProductItemController CRUD controlleri
 */
class ProductItemController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-image' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Barcha variantlarni ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductItem::find()
                ->with('product')
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
     * Bitta variantni ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi variant yaratish
     */
    public function actionCreate()
    {
        $model = new ProductItem();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                // Rasmlarni yuklash
                $model->uploadImages();
                $model->save(false);

                Yii::$app->session->setFlash('success', 'Mahsulot varianti muvaffaqiyatli saqlandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni saqlashda xatolik yuz berdi.');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $this->getProducts(),
        ]);
    }

    /**
     * Variantni yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // Yangi rasmlarni yuklash
            $model->uploadImages();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Mahsulot varianti muvaffaqiyatli yangilandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni yangilashda xatolik yuz berdi.');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'products' => $this->getProducts(),
        ]);
    }

    /**
     * Variantni o'chirish
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Mahsulot varianti muvaffaqiyatli o\'chirildi.');
        return $this->redirect(['index']);
    }

    /**
     * Rasmni o'chirish (AJAX)
     */
    public function actionDeleteImage($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $imagePath = Yii::$app->request->post('imagePath');

        if ($model->deleteImage($imagePath)) {
            return ['success' => true, 'message' => 'Rasm muvaffaqiyatli o\'chirildi.'];
        }

        return ['success' => false, 'message' => 'Rasmni o\'chirishda xatolik yuz berdi.'];
    }

    /**
     * Mahsulotlar ro'yxatini olish
     */
    protected function getProducts()
    {
        return ArrayHelper::map(
            Product::find()
                ->where(['status' => 1])
                ->orderBy(['name_uz' => SORT_ASC])
                ->all(),
            'id',
            'name_uz'
        );
    }

    /**
     * Modelni topish
     */
    protected function findModel($id)
    {
        if (($model = ProductItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}