<?php

namespace backend\controllers;

use Yii;
use common\models\AboutCompany;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AboutCompanyController CRUD controlleri
 */
class AboutCompanyController extends Controller
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
     * Barcha yozuvlarni ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AboutCompany::find()->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Bitta yozuvni ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi yozuv yaratish
     */
    public function actionCreate()
    {
        $model = new AboutCompany();

        if ($model->load(Yii::$app->request->post())) {

            // Video linklar saqlash
            $videoLinks = Yii::$app->request->post('videoLinks', []);
            $model->saveVideoLinks($videoLinks);

            // Avval modelni saqlash (rasmlar o'chirish uchun ID kerak)
            if ($model->save()) {
                // Rasmlarni yuklash
                $model->uploadImages();
                $model->save(false); // Rasmlar bilan qayta saqlash (validatsiyasiz)

                Yii::$app->session->setFlash('success', 'Ma\'lumot muvaffaqiyatli saqlandi.');
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
     * Mavjud yozuvni yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // Video linklar saqlash
            $videoLinks = Yii::$app->request->post('videoLinks', []);
            $model->saveVideoLinks($videoLinks);

            // Yangi rasmlarni yuklash
            $model->uploadImages();

            if ($model->save(false)) { // Validatsiyasiz saqlash (rasmlar uchun)
                Yii::$app->session->setFlash('success', 'Ma\'lumot muvaffaqiyatli yangilandi.');
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
     * Yozuvni o'chirish
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Rasmlarni o'chirish
        foreach ($model->getImagesArray() as $imagePath) {
            $fullPath = Yii::getAlias('@webroot/' . $imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Ma\'lumot muvaffaqiyatli o\'chirildi.');
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
        if (($model = AboutCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}