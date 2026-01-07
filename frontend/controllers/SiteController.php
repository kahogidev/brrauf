<?php

namespace frontend\controllers;

use common\models\AboutCompany;
use common\models\Order;
use common\models\Vacancy;
use common\models\VacancyApplication;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\components\LanguageBehavior;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'language' => [
                'class' => LanguageBehavior::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Portfolio detail sahifasi
     */
    public function actionPortfolio()
    {
        $models = \common\models\Portfolio::find()->all();

        return $this->render('portfolio', [
            'models' => $models,
        ]);
    }

    /**
     * Product item detail sahifasi
     */
    public function actionProductItem($id)
    {
        $model = \common\models\ProductItem::findOne($id);

        if (!$model || $model->status != 1 || $model->product->status != 1) {
            throw new \yii\web\NotFoundHttpException('Mahsulot topilmadi.');
        }

        // Related products from same category
        $relatedItems = \common\models\ProductItem::find()
            ->joinWith('product')
            ->where(['product_items.status' => 1, 'products.status' => 1])
            ->andWhere(['products.category_id' => $model->product->category_id])
            ->andWhere(['!=', 'product_items.id', $model->id])
            ->limit(4)
            ->all();

        return $this->render('product-item-view', [
            'model' => $model,
            'relatedItems' => $relatedItems,
        ]);
    }

    public function actionProduct()
    {
        return $this->render('product');
    }

    public function actionPortfolioView($id)
    {
        $model = \common\models\Portfolio::findOne($id);

        if (!$model || $model->status != 1) {
            throw new \yii\web\NotFoundHttpException('Sahifa topilmadi.');
        }

        // Oldingi va keyingi portfoliolar
        $prevModel = \common\models\Portfolio::find()
            ->where(['status' => 1])
            ->andWhere(['<', 'id', $model->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $nextModel = \common\models\Portfolio::find()
            ->where(['status' => 1])
            ->andWhere(['>', 'id', $model->id])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        return $this->render('portfolio-view', [
            'model' => $model,
            'prevModel' => $prevModel,
            'nextModel' => $nextModel,
        ]);
    }

    /**
     * News detail sahifasi
     */
    public function actionNews($slug)
    {
        $model = \common\models\News::findOne(['slug' => $slug, 'status' => 1]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Yangilik topilmadi.');
        }

        // Latest news for sidebar
        $latestNews = \common\models\News::find()
            ->where(['status' => 1])
            ->andWhere(['!=', 'id', $model->id])
            ->orderBy(['published_date' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(3)
            ->all();

        // Previous and next news
        $prevNews = \common\models\News::find()
            ->where(['status' => 1])
            ->andWhere(['<', 'id', $model->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $nextNews = \common\models\News::find()
            ->where(['status' => 1])
            ->andWhere(['>', 'id', $model->id])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        return $this->render('news-detail', [
            'model' => $model,
            'latestNews' => $latestNews,
            'prevNews' => $prevNews,
            'nextNews' => $nextNews,
        ]);
    }

    /**
     * Aksiyalar sahifasi
     */
    public function actionPromotions()
    {
        $query = \common\models\Promotion::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_DESC]);

        // Filter by active/expired
        $filter = Yii::$app->request->get('filter');

        if ($filter === 'active') {
            $query->andWhere(['<=', 'start_date', date('Y-m-d')])
                ->andWhere(['>=', 'end_date', date('Y-m-d')]);
        } elseif ($filter === 'expired') {
            $query->andWhere(['<', 'end_date', date('Y-m-d')]);
        } elseif ($filter === 'upcoming') {
            $query->andWhere(['>', 'start_date', date('Y-m-d')]);
        }

        $promotions = $query->all();

        return $this->render('promotions', [
            'promotions' => $promotions,
        ]);
    }

    /**
     * Production detail sahifasi
     */
    public function actionProduction($id)
    {
        $model = \common\models\ProductionVolume::findOne(['id' => $id, 'status' => 1]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Ma\'lumot topilmadi.');
        }

        // Previous and next production
        $prevProduction = \common\models\ProductionVolume::find()
            ->where(['status' => 1])
            ->andWhere(['<', 'id', $model->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $nextProduction = \common\models\ProductionVolume::find()
            ->where(['status' => 1])
            ->andWhere(['>', 'id', $model->id])
            ->orderBy(['id' => SORT_ASC])
            ->one();

        // All productions for pagination
        $allProductions = \common\models\ProductionVolume::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        return $this->render('production-view', [
            'model' => $model,
            'prevProduction' => $prevProduction,
            'nextProduction' => $nextProduction,
            'allProductions' => $allProductions,
        ]);
    }

    public function actionPromotion($id)
    {
        $model = \common\models\Promotion::findOne(['id' => $id, 'status' => 1]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Aksiya topilmadi.');
        }

        // Get products in this promotion
        $products = $model->products;

        return $this->render('promotion-detail', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Vakansiyalar ro'yxati
     */
    public function actionVacancy()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vacancy::find()
                ->where(['status' => 1])
                ->orderBy(['sort_order' => SORT_ASC, 'created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('vacancy/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Vakansiya tafsilotlari
     */
    public function actionVacancyView($id)
    {
        $model = $this->findVacancy($id);

        return $this->render('vacancy/view', [
            'model' => $model,
        ]);
    }

    /**
     * Vakansiyaga ariza yuborish
     */
    public function actionVacancyApply($id)
    {
        $vacancy = $this->findVacancy($id);
        $application = new VacancyApplication();
        $application->vacancy_id = $vacancy->id;

        if ($application->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                // Resume yuklash
                $resumeUploaded = $application->uploadResume();

                // Modelni saqlash
                if ($application->save()) {
                    // Telegram'ga yuborish
                    $telegramResult = $this->sendApplicationToTelegram($application, $vacancy);

                    if ($telegramResult) {
                        Yii::$app->session->setFlash('success',
                            Yii::$app->language == 'uz'
                                ? 'Arizangiz muvaffaqiyatli yuborildi! Tez orada siz bilan bog\'lanamiz.'
                                : 'Ваша заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.'
                        );
                    } else {
                        Yii::$app->session->setFlash('warning',
                            Yii::$app->language == 'uz'
                                ? 'Arizangiz saqlandi, lekin xabarnoma yuborishda muammo bo\'ldi.'
                                : 'Ваша заявка сохранена, но возникла проблема с отправкой уведомления.'
                        );
                    }

                    $transaction->commit();
                    return $this->redirect(['vacancy-view', 'id' => $vacancy->id]);

                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error',
                        Yii::$app->language == 'uz'
                            ? 'Ariza yuborishda xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.'
                            : 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте еще раз.'
                    );
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error('Application save error: ' . $e->getMessage());

                Yii::$app->session->setFlash('error',
                    Yii::$app->language == 'uz'
                        ? 'Kutilmagan xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.'
                        : 'Произошла непредвиденная ошибка. Пожалуйста, попробуйте еще раз.'
                );
            }
        }

        return $this->render('vacancy/apply', [
            'vacancy' => $vacancy,
            'model' => $application,
        ]);
    }

    /**
     * Telegram botga vacancy ariza yuborish
     */
    private function sendApplicationToTelegram($application, $vacancy)
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
        $message = $this->formatApplicationTelegramMessage($application, $vacancy, $lang, $title);

        // Matnli xabarni yuborish
        $messageResult = $this->sendTelegramMessage($botToken, $chatId, $message);

        if (!$messageResult) {
            Yii::error('Failed to send Telegram message');
            return false;
        }

        // Resume faylini yuborish (agar mavjud bo'lsa)
        if ($application->resume_file) {
            $filePath = Yii::getAlias('@frontend/web/' . $application->resume_file);

            if (file_exists($filePath)) {
                $documentResult = $this->sendTelegramDocument($botToken, $chatId, $filePath, $application->full_name);

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
    private function formatApplicationTelegramMessage($model, $vacancy, $lang, $title)
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
            $experience = str_replace("\r\n", "\n", $experience);
            $message .= "💼 <b>Ish tajribasi:</b>\n" . $experience . "\n\n";
        }

        if ($model->cover_letter) {
            $coverLetter = htmlspecialchars($model->cover_letter, ENT_QUOTES, 'UTF-8');
            $coverLetter = str_replace("\r\n", "\n", $coverLetter);
            $message .= "✍️ <b>Qo'shimcha ma'lumot:</b>\n" . $coverLetter . "\n\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "📅 <b>Yuborilgan vaqt:</b> " . date('d.m.Y H:i') . "\n";
        $message .= "🆔 <b>Ariza ID:</b> #" . $model->id . "\n";

        return $message;
    }

    public function actionCart()
    {
        return $this->render('cart');
    }

    /**
     * Checkout sahifasi
     */
    public function actionCheckout()
    {
        // AJAX so'rovlar uchun JSON javob
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $model = new Order();

            if ($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    // Cart ma'lumotlarini olish
                    $cartData = Yii::$app->request->post('cart_data');

                    if (empty($cartData)) {
                        return [
                            'success' => false,
                            'message' => Yii::$app->language == 'uz'
                                ? 'Savat bo\'sh!'
                                : 'Корзина пуста!'
                        ];
                    }

                    $cart = json_decode($cartData, true);

                    if (!$cart || !is_array($cart) || count($cart) === 0) {
                        return [
                            'success' => false,
                            'message' => Yii::$app->language == 'uz'
                                ? 'Savat ma\'lumotlari noto\'g\'ri!'
                                : 'Неверные данные корзины!'
                        ];
                    }

                    // Total amount ni hisoblash
                    $totalAmount = 0;
                    foreach ($cart as $item) {
                        $price = floatval($item['price'] ?? 0);
                        $quantity = intval($item['quantity'] ?? 1);
                        $totalAmount += $price * $quantity;
                    }

                    $model->total_amount = $totalAmount;
                    $model->status = 'pending';

                    if ($model->save()) {
                        // Order items ni saqlash
                        foreach ($cart as $item) {
                            $orderItem = new \common\models\OrderItem();
                            $orderItem->order_id = $model->id;
                            $orderItem->product_item_id = $item['id'] ?? null;
                            $orderItem->product_name = $item['name'] ?? 'Unknown';
                            $orderItem->product_sku = $item['sku'] ?? null;
                            $orderItem->price = floatval($item['price'] ?? 0);
                            $orderItem->quantity = intval($item['quantity'] ?? 1);
                            $orderItem->subtotal = $orderItem->price * $orderItem->quantity;

                            if (!$orderItem->save()) {
                                throw new \Exception('Order item save failed');
                            }
                        }

                        // Telegram'ga yuborish
                        $telegramResult = $this->sendOrderToTelegram($model);

                        $transaction->commit();

                        return [
                            'success' => true,
                            'orderNumber' => $model->order_number,
                            'message' => Yii::$app->language == 'uz'
                                ? 'Buyurtmangiz muvaffaqiyatli qabul qilindi!'
                                : 'Ваш заказ успешно принят!',
                            'redirectUrl' => Url::to(['order-success', 'order_number' => $model->order_number])
                        ];

                    } else {
                        $transaction->rollBack();

                        // Validation errors
                        $errors = [];
                        foreach ($model->getErrors() as $field => $fieldErrors) {
                            $errors[$field] = implode(', ', $fieldErrors);
                        }

                        return [
                            'success' => false,
                            'message' => Yii::$app->language == 'uz'
                                ? 'Forma to\'ldirishda xatolik!'
                                : 'Ошибка заполнения формы!',
                            'errors' => $errors
                        ];
                    }

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Order save error: ' . $e->getMessage());

                    return [
                        'success' => false,
                        'message' => Yii::$app->language == 'uz'
                            ? 'Kutilmagan xatolik yuz berdi: ' . $e->getMessage()
                            : 'Произошла непредвиденная ошибка: ' . $e->getMessage()
                    ];
                }
            }

            // POST bo'lmasa
            return [
                'success' => false,
                'message' => Yii::$app->language == 'uz'
                    ? 'Noto\'g\'ri so\'rov!'
                    : 'Неверный запрос!'
            ];
        }

        // Oddiy GET so'rovi uchun - checkout sahifasini ko'rsatish
        $model = new Order();

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }

    /**
     * Order success sahifasi
     */
    public function actionOrderSuccess($order_number)
    {
        $order = Order::findOne(['order_number' => $order_number]);

        if (!$order) {
            throw new NotFoundHttpException(
                Yii::$app->language == 'uz'
                    ? 'Buyurtma topilmadi.'
                    : 'Заказ не найден.'
            );
        }

        return $this->render('order-success', [
            'order' => $order,
        ]);
    }

    /**
     * Telegram botga order yuborish
     */
    private function sendOrderToTelegram($order)
    {
        $botToken = Yii::$app->params['telegramBotToken'] ?? null;
        $chatId = Yii::$app->params['telegramOrderChatId'] ?? Yii::$app->params['telegramChatId'] ?? null;

        if (!$botToken || !$chatId) {
            Yii::warning('Telegram bot settings not configured for orders');
            return false;
        }

        $lang = Yii::$app->language;

        // Xabar matni tayyorlash
        $message = $this->formatOrderTelegramMessage($order, $lang);

        // Matnli xabarni yuborish
        $messageResult = $this->sendTelegramMessage($botToken, $chatId, $message);

        if (!$messageResult) {
            Yii::warning('Failed to send order Telegram message');
            return false;
        }

        return true;
    }

    /**
     * Order xabar matni formatlash
     */
    private function formatOrderTelegramMessage($order, $lang)
    {
        $message = "🛒 <b>YANGI BUYURTMA</b>\n\n";

        $message .= "📋 <b>Buyurtma raqami:</b> #" . htmlspecialchars($order->order_number, ENT_QUOTES, 'UTF-8') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n\n";

        $message .= "👤 <b>Mijoz:</b> " . htmlspecialchars($order->customer_name, ENT_QUOTES, 'UTF-8') . "\n";
        $message .= "📱 <b>Telefon:</b> " . htmlspecialchars($order->customer_phone, ENT_QUOTES, 'UTF-8') . "\n";
        $message .= "🏙 <b>Shahar:</b> " . htmlspecialchars($order->customer_city, ENT_QUOTES, 'UTF-8') . "\n";

        if ($order->customer_address) {
            $message .= "📍 <b>Manzil:</b> " . htmlspecialchars($order->customer_address, ENT_QUOTES, 'UTF-8') . "\n";
        }

        $message .= "\n<b>📦 Buyurtma tarkibi:</b>\n\n";

        foreach ($order->orderItems as $item) {
            $message .= "• " . htmlspecialchars($item->product_name, ENT_QUOTES, 'UTF-8');
            if ($item->product_sku) {
                $message .= " (SKU: " . htmlspecialchars($item->product_sku, ENT_QUOTES, 'UTF-8') . ")";
            }
            $message .= "\n";
            $message .= "  Narxi: " . number_format($item->price, 0, '.', ' ') . " so'm\n";
            $message .= "  Miqdori: " . $item->quantity . " dona\n";
            $message .= "  Jami: " . number_format($item->subtotal, 0, '.', ' ') . " so'm\n\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "💰 <b>JAMI SUMMA: " . number_format($order->total_amount, 0, '.', ' ') . " so'm</b>\n\n";

        if ($order->notes) {
            $message .= "📝 <b>Izoh:</b> " . htmlspecialchars($order->notes, ENT_QUOTES, 'UTF-8') . "\n\n";
        }

        $message .= "📅 <b>Sana:</b> " . date('d.m.Y H:i', $order->created_at) . "\n";
        $message .= "🆔 <b>Order ID:</b> #" . $order->id . "\n";

        return $message;
    }

    /**
     * Telegram API orqali xabar yuborish (birlashtirilgan versiya)
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
     * CURL so'rov yuborish (birlashtirilgan versiya)
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
        if (($model = Vacancy::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Vakansiya topilmadi.');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        // Barcha faol AboutCompany yozuvlarini olish
        $dataProvider = new ActiveDataProvider([
            'query' => AboutCompany::find()
                ->where(['status' => 1])
                ->orderBy(['sort_order' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // Yoki faqat bitta asosiy ma'lumotni olish
        $model = AboutCompany::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Ma\'lumot topilmadi.');
        }

        return $this->render('about', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Kompaniya tarixi
     */
    public function actionCompanyHistory()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\CompanyHistory::find()
                ->where(['status' => 1])
                ->orderBy(['year' => SORT_ASC, 'sort_order' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('company-history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}