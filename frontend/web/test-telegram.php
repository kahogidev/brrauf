<?php

// Frontend web papkasida yarating: frontend/web/test-telegram.php

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/main.php');
$application = new yii\web\Application($config);

$botToken = Yii::$app->params['telegramBotToken'];
$chatId = Yii::$app->params['telegramChatId'];

echo "Bot Token: {$botToken}\n";
echo "Chat ID: {$chatId}\n\n";

// Test message
$url = "https://api.telegram.org/bot{$botToken}/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => "🧪 <b>TEST XABAR</b>\n\nVaqt: " . date('d.m.Y H:i:s'),
    'parse_mode' => 'HTML'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Response: {$response}\n";

$result = json_decode($response, true);
if (isset($result['ok']) && $result['ok']) {
    echo "\n✅ SUCCESS! Xabar yuborildi!\n";
} else {
    echo "\n❌ ERROR! Xabar yuborilmadi!\n";
    echo "Error: " . ($result['description'] ?? 'Unknown error') . "\n";
}