<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Vacancy;
use common\models\VacancyApplication;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

class VacancyController extends Controller
{
    /**
     * Ariza yuborish action
     */
    public function actionApply($id)
    {
        $vacancy = $this->findVacancy($id);
        $model = new VacancyApplication();
        $model->vacancy_id = $vacancy->id;

        if ($model->load(Yii::$app->request->post())) {
            // Resume faylini instance qilish
            $model->resumeFile = UploadedFile::getInstance($model, 'resumeFile');

            // Transaksiya boshlaymiz
            $transaction = Yii::$app->db->beginTransaction();

            try {
                // Modelni saqlash
                if ($model->save()) {
                    // Resume yuklash (agar mavjud bo'lsa)
                    if ($model->resumeFile) {
                        $model->uploadResume();
                        $model->save(false); // resume_file maydonini yangilash
                    }

                    // Ma'lumotlarni Telegram botga yuborish
                    $telegramResult = $this->sendToTelegram($model, $vacancy);

                    if ($telegramResult) {
                        Yii::$app->session->setFlash('success',
                            Yii::$app->language == 'uz'
                                ? 'Arizangiz muvaffaqiyatli yuborildi!'
                                : 'Ваша заявка успешно отправлена!'
                        );
                    } else {
                        Yii::$app->session->setFlash('warning',
                            Yii::$app->language == 'uz'
                                ? 'Ariza saqlandi, lekin Telegram\'ga yuborishda xatolik yuz berdi.'
                                : 'Заявка сохранена, но произошла ошибка при отправке в Telegram.'
                        );
                    }

                    $transaction->commit();
                    return $this->redirect(['vacancy-view', 'id' => $vacancy->id]);
                }

                $transaction->rollBack();

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error('Application save error: ' . $e->getMessage());

                Yii::$app->session->setFlash('error',
                    Yii::$app->language == 'uz'
                        ? 'Arizani yuborishda xatolik yuz berdi. Iltimos, qayta urinib ko\'ring.'
                        : 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте еще раз.'
                );
            }
        }

        return $this->render('apply', [
            'vacancy' => $vacancy,
            'model' => $model,
        ]);
    }

    /**
     * Telegram botga xabar yuborish
     */
    private function sendToTelegram($model, $vacancy)
    {
        $botToken = Yii::$app->params['telegramBotToken'] ?? null;
        $chatId = Yii::$app->params['telegramChatId'] ?? null;

        if (!$botToken || !$chatId) {
            Yii::error('Telegram bot settings not configured in params');
            return false;
        }

        $lang = Yii::$app->language;
        $title = $lang == 'uz' ? 'title_uz' : 'title_ru';

        // Xabar matni tayyorlash
        $message = $this->formatTelegramMessage($model, $vacancy, $lang, $title);

        // Matnli xabarni yuborish
        $messageResult = $this->sendTelegramMessage($botToken, $chatId, $message);

        if (!$messageResult) {
            Yii::error('Failed to send Telegram message');
            return false;
        }

        // Resume faylini yuborish (agar mavjud bo'lsa)
        if ($model->resume_file) {
            $filePath = Yii::getAlias('@frontend/web/' . $model->resume_file);

            if (file_exists($filePath)) {
                $documentResult = $this->sendTelegramDocument($botToken, $chatId, $filePath, $model->full_name);

                if (!$documentResult) {
                    Yii::warning('Message sent but failed to send document to Telegram');
                }
            } else {
                Yii::warning("Resume file not found: {$filePath}");
            }
        }

        return true;
    }

    /**
     * Telegram xabar matni formatlash
     */
    private function formatTelegramMessage($model, $vacancy, $lang, $title)
    {
        $message = "🔔 <b>YANGI VAKANSIYA ARIZASI</b>\n\n";

        $message .= "📋 <b>Vakansiya:</b> " . htmlspecialchars($vacancy->$title, ENT_QUOTES, 'UTF-8') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n\n";

        $message .= "👤 <b>To'liq ism:</b> " . htmlspecialchars($model->full_name, ENT_QUOTES, 'UTF-8') . "\n";
        $message .= "📧 <b>Email:</b> " . htmlspecialchars($model->email, ENT_QUOTES, 'UTF-8') . "\n";
        $message .= "📱 <b>Telefon:</b> " . htmlspecialchars($model->phone, ENT_QUOTES, 'UTF-8') . "\n";

        if ($model->birth_date) {
            $message .= "🎂 <b>Tug'ilgan sana:</b> " . Yii::$app->formatter->asDate($model->birth_date) . "\n";
        }

        $message .= "\n";

        if ($model->education) {
            $education = htmlspecialchars($model->education, ENT_QUOTES, 'UTF-8');
            $message .= "🎓 <b>Ma'lumoti:</b>\n" . $education . "\n\n";
        }

        if ($model->experience) {
            $experience = htmlspecialchars($model->experience, ENT_QUOTES, 'UTF-8');
            // Telegram HTML da \n ishlamaydi, <br> yoki bo'sh qator kerak
            $experience = nl2br($experience, false);
            $experience = str_replace('<br>', "\n", $experience);
            $message .= "💼 <b>Ish tajribasi:</b>\n" . $experience . "\n\n";
        }

        if ($model->cover_letter) {
            $coverLetter = htmlspecialchars($model->cover_letter, ENT_QUOTES, 'UTF-8');
            $coverLetter = nl2br($coverLetter, false);
            $coverLetter = str_replace('<br>', "\n", $coverLetter);
            $message .= "✍️ <b>Qo'shimcha ma'lumot:</b>\n" . $coverLetter . "\n\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "📅 <b>Yuborilgan vaqt:</b> " . date('d.m.Y H:i') . "\n";

        return $message;
    }

    /**
     * Telegram API orqali xabar yuborish
     */
    private function sendTelegramMessage($botToken, $chatId, $message)
    {
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        try {
            $result = $this->sendCurlRequest($url, $data);

            if ($result && isset($result['ok']) && $result['ok'] === true) {
                Yii::info('Telegram message sent successfully');
                return true;
            }

            Yii::error('Telegram API returned error: ' . json_encode($result));
            return false;

        } catch (\Exception $e) {
            Yii::error('Exception in sendTelegramMessage: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Telegram API orqali fayl yuborish
     */
    private function sendTelegramDocument($botToken, $chatId, $filePath, $caption = '')
    {
        $url = "https://api.telegram.org/bot{$botToken}/sendDocument";

        if (!file_exists($filePath)) {
            Yii::error("File not found: {$filePath}");
            return false;
        }

        // CURLFile yaratish
        $cFile = new \CURLFile(realpath($filePath));
        $cFile->setMimeType(mime_content_type($filePath));
        $cFile->setPostFilename(basename($filePath));

        $post = [
            'chat_id' => $chatId,
            'document' => $cFile,
            'caption' => "📄 Resume: " . $caption
        ];

        try {
            $result = $this->sendCurlRequest($url, $post, true);

            if ($result && isset($result['ok']) && $result['ok'] === true) {
                Yii::info('Telegram document sent successfully');
                return true;
            }

            Yii::error('Telegram API document error: ' . json_encode($result));
            return false;

        } catch (\Exception $e) {
            Yii::error('Exception in sendTelegramDocument: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * CURL so'rov yuborish
     */
    private function sendCurlRequest($url, $data, $isFile = false)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $isFile ? $data : http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            curl_close($ch);

            if ($curlError) {
                Yii::error("CURL Error: {$curlError}");
                return false;
            }

            if ($httpCode != 200) {
                Yii::error("Telegram API Error: HTTP {$httpCode}, Response: {$response}");
                return false;
            }

            $result = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Yii::error("JSON decode error: " . json_last_error_msg());
                return false;
            }

            return $result;

        } catch (\Exception $e) {
            Yii::error("Telegram send error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vakansiyani topish
     */
    protected function findVacancy($id)
    {
        if (($model = Vacancy::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}