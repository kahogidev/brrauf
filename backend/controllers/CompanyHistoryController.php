<?php

namespace backend\controllers;

use Yii;
use common\models\CompanyHistory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CompanyHistoryController CRUD controlleri
 */
class CompanyHistoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
            'query' => CompanyHistory::find()->orderBy(['year' => SORT_DESC, 'sort_order' => SORT_ASC]),
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
        $model = new CompanyHistory();

        if ($model->load(Yii::$app->request->post())) {

            // Video linklar saqlash
            $videoLinks = Yii::$app->request->post('videoLinks', []);
            $model->saveVideoLinks($videoLinks);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Avval modelni saqlash
                if ($model->save()) {
                    // Keyin rasmlarni yuklash
                    $uploadResult = $model->uploadImages();

                    // Agar rasmlar yuklangan bo'lsa, modelni qayta saqlash
                    if ($uploadResult) {
                        $model->save(false); // false - validatsiyasiz
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Tarix muvaffaqiyatli saqlandi.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Tarixni saqlashda xatolik yuz berdi. Xatolarni tekshiring.');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Xatolik yuz berdi: ' . $e->getMessage());
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

            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Avval modelni saqlash
                if ($model->save()) {
                    // Keyin rasmlarni yuklash
                    $uploadResult = $model->uploadImages();

                    // Agar rasmlar yuklangan bo'lsa, modelni qayta saqlash
                    if ($uploadResult) {
                        $model->save(false);
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Tarix muvaffaqiyatli yangilandi.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Tarixni yangilashda xatolik yuz berdi. Xatolarni tekshiring.');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Xatolik yuz berdi: ' . $e->getMessage());
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

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Tarix muvaffaqiyatli o\'chirildi.');
        } else {
            Yii::$app->session->setFlash('error', 'Tarixni o\'chirishda xatolik yuz berdi.');
        }

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
        if (($model = CompanyHistory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('So\'ralgan sahifa topilmadi.');
    }
}