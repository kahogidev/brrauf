<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProductController CRUD controlleri
 */
class ProductController extends Controller
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
     * Barcha mahsulotlarni ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()
                ->with('category')
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
     * Bitta mahsulotni ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi mahsulot yaratish
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                // Rasmlarni yuklash
                $model->uploadImages();
                $model->save(false);

                Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli saqlandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni saqlashda xatolik yuz berdi.');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * Mahsulotni yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // Yangi rasmlarni yuklash
            $model->uploadImages();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli yangilandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni yangilashda xatolik yuz berdi.');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * Mahsulotni o'chirish
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Mahsulotga bog'liq product items bormi tekshirish
        if ($model->productItems) {
            Yii::$app->session->setFlash('error', 'Bu mahsulotga variantlar bog\'liq. Avval variantlarni o\'chiring.');
            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli o\'chirildi.');
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
     * Kategoriyalar ro'yxatini olish
     */
    protected function getCategories()
    {
        return ArrayHelper::map(
            Category::find()->where(['status' => 1])->orderBy(['name_uz' => SORT_ASC])->all(),
            'id',
            'name_uz'
        );
    }

    /**
     * Modelni topish
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}