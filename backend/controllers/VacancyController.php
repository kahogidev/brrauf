<?php

namespace backend\controllers;

use Yii;
use common\models\Vacancy;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

class VacancyController extends Controller
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacancy::find()->orderBy(['sort_order' => SORT_ASC, 'created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Vacancy();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // Transaction ichida saqlash
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // Avval modelni saqlash (validatsiya bilan)
                    if ($model->save()) {
                        // Keyin rasmni yuklash (agar bor bo'lsa)
                        $uploadResult = $model->uploadImage();

                        // Agar rasm yuklangan bo'lsa, modelni qayta saqlash
                        if ($uploadResult) {
                            $model->save(false); // false - validatsiyasiz
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Vakansiya muvaffaqiyatli qo\'shildi.');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Vakansiya saqlanmadi. Xatolarni tekshiring.');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Xatolik yuz berdi: ' . $e->getMessage());
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Avval modelni saqlash
                if ($model->save()) {
                    // Keyin rasmni yuklash
                    $uploadResult = $model->uploadImage();

                    // Agar rasm yuklangan bo'lsa, modelni qayta saqlash
                    if ($uploadResult) {
                        $model->save(false);
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Vakansiya muvaffaqiyatli yangilandi.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Vakansiya saqlanmadi. Xatolarni tekshiring.');
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Vakansiya muvaffaqiyatli o\'chirildi.');
        } else {
            Yii::$app->session->setFlash('error', 'Vakansiya o\'chirilmadi. Iltimos, qaytadan urinib ko\'ring.');
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);

        if ($model->image) {
            $imagePath = Yii::getAlias('@frontend/web/' . $model->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $model->image = null;

            if ($model->save(false)) {
                return [
                    'success' => true,
                    'message' => 'Rasm muvaffaqiyatli o\'chirildi.'
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Rasm o\'chirilmadi.'
        ];
    }

    protected function findModel($id)
    {
        if (($model = Vacancy::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Vakansiya topilmadi.');
    }
}