<?php

namespace backend\controllers;

use Yii;
use common\models\Partner;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartnerController CRUD controlleri
 */
class PartnerController extends Controller
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
     * Barcha partner yozuvlarini ko'rsatish
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Partner::find()
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
     * Bitta partner yozuvini ko'rish
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Yangi partner yaratish
     */
    public function actionCreate()
    {
        $model = new Partner();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Logo yuklash
            $model->uploadLogo();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Hamkor muvaffaqiyatli saqlandi.');
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
     * Partner yozuvini yangilash
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Yangi logo yuklash
            $model->uploadLogo();

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Hamkor muvaffaqiyatli yangilandi.');
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
     * Partner yozuvini o'chirish
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Hamkor muvaffaqiyatli o\'chirildi.');
        return $this->redirect(['index']);
    }

    /**
     * Modelni topish
     */
    protected function findModel($id)
    {
        if (($model = Partner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}