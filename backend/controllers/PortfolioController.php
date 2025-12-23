<?php

namespace backend\controllers;

use Yii;
use common\models\Portfolio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PortfolioController CRUD controlleri
 */
class PortfolioController extends Controller
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
     * Barcha portfolio yozuvlarini ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Portfolio::find()
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
     * Bitta portfolio yozuvini ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi portfolio yaratish
     */
    public function actionCreate()
    {
        $model = new Portfolio();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Logo yuklash
            $model->uploadLogo();

            // Rasmlarni yuklash
            $model->uploadImages();

            // Video linklar saqlash
            $videoLinks = Yii::$app->request->post('video_links', []);
            $model->saveVideoLinks($videoLinks);

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Portfolio muvaffaqiyatli saqlandi.');
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
     * Portfolio yozuvini yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Yangi logo yuklash
            $model->uploadLogo();

            // Yangi rasmlarni yuklash
            $model->uploadImages();

            // Video linklar saqlash
            $videoLinks = Yii::$app->request->post('video_links', []);
            $model->saveVideoLinks($videoLinks);

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Portfolio muvaffaqiyatli yangilandi.');
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
     * Portfolio yozuvini o'chirish
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Portfolio muvaffaqiyatli o\'chirildi.');
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
     * Modelni topish
     */
    protected function findModel($id)
    {
        if (($model = Portfolio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}