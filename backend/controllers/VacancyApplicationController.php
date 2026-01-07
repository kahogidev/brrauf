<?php

namespace backend\controllers;

use Yii;
use common\models\Vacancy;
use common\models\VacancyApplication;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * VacancyApplicationController implements the CRUD actions for VacancyApplication model.
 */
class VacancyApplicationController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                ],
            ],
        ];
    }

    /**
     * Lists all VacancyApplication models.
     * @param int|null $vacancy_id Filter by vacancy
     * @param string|null $status Filter by status
     * @return string
     */
    public function actionIndex($vacancy_id = null, $status = null)
    {
        $query = VacancyApplication::find()
            ->with('vacancy')
            ->orderBy(['created_at' => SORT_DESC]);

        // Vakansiya bo'yicha filtr
        if ($vacancy_id) {
            $query->andWhere(['vacancy_id' => $vacancy_id]);
            $vacancy = Vacancy::findOne($vacancy_id);
        } else {
            $vacancy = null;
        }

        // Status bo'yicha filtr
        if ($status) {
            $query->andWhere(['status' => $status]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'vacancy' => $vacancy,
        ]);
    }

    /**
     * Displays a single VacancyApplication model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Agar status "new" bo'lsa, "viewed" ga o'zgartirish
        if ($model->status === VacancyApplication::STATUS_NEW) {
            $model->status = VacancyApplication::STATUS_VIEWED;
            $model->save(false);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates application status.
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Status muvaffaqiyatli yangilandi.');
        } else {
            Yii::$app->session->setFlash('error', 'Status yangilanmadi. Iltimos, qaytadan urinib ko\'ring.');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Adds admin note to application.
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionAddNote($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Izoh muvaffaqiyatli qo\'shildi.');
        } else {
            Yii::$app->session->setFlash('error', 'Izoh qo\'shilmadi. Iltimos, qaytadan urinib ko\'ring.');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing VacancyApplication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Ariza muvaffaqiyatli o\'chirildi.');
        } else {
            Yii::$app->session->setFlash('error', 'Ariza o\'chirilmadi. Iltimos, qaytadan urinib ko\'ring.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Export applications to Excel
     * @param int|null $vacancy_id
     * @param string|null $status
     * @return Response
     */
    public function actionExport($vacancy_id = null, $status = null)
    {
        $query = VacancyApplication::find()
            ->with('vacancy')
            ->orderBy(['created_at' => SORT_DESC]);

        if ($vacancy_id) {
            $query->andWhere(['vacancy_id' => $vacancy_id]);
        }

        if ($status) {
            $query->andWhere(['status' => $status]);
        }

        $models = $query->all();

        // Excel fayl yaratish (PHPSpreadsheet yoki boshqa kutubxona kerak)
        // Bu yerda faqat misol ko'rsatilgan

        $filename = 'vakansiya_arizalari_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // UTF-8 BOM qo'shish (Excel uchun)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header qo'shish
        fputcsv($output, [
            'ID',
            'To\'liq ism',
            'Email',
            'Telefon',
            'Tug\'ilgan sana',
            'Ma\'lumot',
            'Vakansiya',
            'Status',
            'Yuborilgan sana'
        ]);

        // Ma'lumotlarni qo'shish
        foreach ($models as $model) {
            fputcsv($output, [
                $model->id,
                $model->full_name,
                $model->email,
                $model->phone,
                $model->birth_date ? Yii::$app->formatter->asDate($model->birth_date) : '',
                $model->education,
                $model->vacancy->title_uz,
                $model->getStatusName(),
                Yii::$app->formatter->asDatetime($model->created_at)
            ]);
        }

        fclose($output);
        Yii::$app->end();
    }

    /**
     * Sends email to applicant
     * @param int $id
     * @return Response
     */
    public function actionSendEmail($id)
    {
        $model = $this->findModel($id);

        // Bu yerda email yuborish logikasi
        // Yii2 mailer yoki boshqa email kutubxonasidan foydalanish mumkin

        try {
            Yii::$app->mailer->compose()
                ->setTo($model->email)
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                ->setSubject('Vakansiya bo\'yicha javob')
                ->setTextBody('Sizning arizangiz ko\'rib chiqildi.')
                ->send();

            Yii::$app->session->setFlash('success', 'Email muvaffaqiyatli yuborildi.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Email yuborishda xatolik yuz berdi: ' . $e->getMessage());
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Bulk status update
     * @return Response
     */
    public function actionBulkUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $ids = Yii::$app->request->post('ids', []);
        $status = Yii::$app->request->post('status');

        if (empty($ids) || !$status) {
            return [
                'success' => false,
                'message' => 'Ma\'lumotlar to\'liq emas.'
            ];
        }

        $count = VacancyApplication::updateAll(
            ['status' => $status],
            ['id' => $ids]
        );

        return [
            'success' => true,
            'message' => $count . ' ta ariza yangilandi.',
            'count' => $count
        ];
    }

    /**
     * Get statistics
     * @param int|null $vacancy_id
     * @return Response
     */
    public function actionStatistics($vacancy_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = VacancyApplication::find();

        if ($vacancy_id) {
            $query->andWhere(['vacancy_id' => $vacancy_id]);
        }

        $total = $query->count();
        $new = (clone $query)->andWhere(['status' => VacancyApplication::STATUS_NEW])->count();
        $viewed = (clone $query)->andWhere(['status' => VacancyApplication::STATUS_VIEWED])->count();
        $accepted = (clone $query)->andWhere(['status' => VacancyApplication::STATUS_ACCEPTED])->count();
        $rejected = (clone $query)->andWhere(['status' => VacancyApplication::STATUS_REJECTED])->count();

        return [
            'total' => $total,
            'new' => $new,
            'viewed' => $viewed,
            'accepted' => $accepted,
            'rejected' => $rejected,
        ];
    }

    /**
     * Finds the VacancyApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return VacancyApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VacancyApplication::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Ariza topilmadi.');
    }
}