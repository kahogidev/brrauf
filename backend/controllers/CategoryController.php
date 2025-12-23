<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController CRUD controlleri
 */
class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Barcha kategoriyalarni ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Bitta kategoriyani ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi kategoriya yaratish
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                // Rasmni yuklash
                $model->uploadImage();
                $model->save(false);

                Yii::$app->session->setFlash('success', 'Kategoriya muvaffaqiyatli saqlandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni saqlashda xatolik yuz berdi.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Kategoriyani yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // Rasmni yuklash
            $model->uploadImage();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Kategoriya muvaffaqiyatli yangilandi.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma\'lumotni yangilashda xatolik yuz berdi.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Kategoriyani o'chirish
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Kategoriyaga bog'liq mahsulotlar bormi tekshirish
        if ($model->products) {
            Yii::$app->session->setFlash('error', 'Bu kategoriyaga mahsulotlar bog\'liq. Avval mahsulotlarni o\'chiring.');
            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Kategoriya muvaffaqiyatli o\'chirildi.');
        return $this->redirect(['index']);
    }

    /**
     * Modelni topish
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}