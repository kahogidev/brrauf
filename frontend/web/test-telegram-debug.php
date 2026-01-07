<?php
/**
 * Telegram Bot Debug va Test Script
 *
 * Bu faylni frontend/web/ ga saqlang: test-telegram-debug.php
 * Brauzerda: http://yoursite.com/test-telegram-debug.php
 */

// Bot sozlamalari
$botToken = '8272768491:AAEMAZGByzrYHQbPfyv_ABW9oeVzQ_VKdVI';
$chatId = '-5231304930'; // Bu sizning chat ID

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Telegram Bot Debug</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success {
            padding: 15px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
            margin: 15px 0;
        }
        .error {
            padding: 15px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 5px;
            margin: 15px 0;
        }
        .warning {
            padding: 15px;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            border-radius: 5px;
            margin: 15px 0;
        }
        .info {
            padding: 15px;
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            border-radius: 5px;
            margin: 15px 0;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
        }
        h1, h2, h3 { color: #333; }
        .step {
            background: #e7f3ff;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #2196F3;
            border-radius: 5px;
        }
        .code {
            background: #f4f4f4;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 13px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
        }
        button:hover { background: #45a049; }
        .btn-secondary { background: #2196F3; }
        .btn-secondary:hover { background: #0b7dda; }
    </style>
</head>
<body>
<div class="container">
    <h1>🤖 Telegram Bot Debug</h1>

    <?php
    // Test 1: getMe - Bot malumotlarini olish
    echo "<h2>1️⃣ Bot Ma'lumotlari Tekshiruvi</h2>";
    $getMeUrl = "https://api.telegram.org/bot{$botToken}/getMe";
    $ch = curl_init($getMeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $botInfo = json_decode($response, true);

    if ($httpCode == 200 && isset($botInfo['ok']) && $botInfo['ok']) {
        echo '<div class="success">✅ <strong>Bot Token TO\'G\'RI!</strong></div>';
        echo '<div class="info">';
        echo '<strong>Bot nomi:</strong> ' . htmlspecialchars($botInfo['result']['first_name']) . '<br>';
        echo '<strong>Username:</strong> @' . htmlspecialchars($botInfo['result']['username']) . '<br>';
        echo '<strong>Bot ID:</strong> ' . $botInfo['result']['id'];
        echo '</div>';
    } else {
        echo '<div class="error">❌ <strong>Bot Token NOTO\'G\'RI!</strong><br>';
        echo 'HTTP Code: ' . $httpCode . '<br>';
        echo 'Response: ' . htmlspecialchars($response);
        echo '</div>';
        echo '<div class="warning">⚠️ Botni qayta yarating va tokenni to\'g\'ri nusxalang!</div>';
        exit;
    }

    // Test 2: getUpdates - Chat ID ni olish
    echo "<h2>2️⃣ Chat ID Tekshiruvi</h2>";
    $getUpdatesUrl = "https://api.telegram.org/bot{$botToken}/getUpdates";
    $ch = curl_init($getUpdatesUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $updates = json_decode($response, true);

    if (isset($updates['result']) && !empty($updates['result'])) {
        echo '<div class="success">✅ Xabarlar topildi!</div>';

        echo '<div class="info">';
        echo '<strong>Topilgan Chat ID lar:</strong><br><br>';

        $foundChats = [];
        foreach ($updates['result'] as $update) {
            if (isset($update['message']['chat'])) {
                $chat = $update['message']['chat'];
                $chatId = $chat['id'];
                $chatType = $chat['type'];
                $chatTitle = isset($chat['title']) ? $chat['title'] : 'Private Chat';

                if (!isset($foundChats[$chatId])) {
                    $foundChats[$chatId] = [
                        'id' => $chatId,
                        'type' => $chatType,
                        'title' => $chatTitle
                    ];

                    echo "📍 <strong>Chat ID:</strong> <span class='code'>" . $chatId . "</span><br>";
                    echo "   Type: " . $chatType . "<br>";
                    echo "   Title: " . htmlspecialchars($chatTitle) . "<br><br>";
                }
            }
        }
        echo '</div>';

        // Joriy Chat ID tekshirish
        if (in_array($chatId, array_column($foundChats, 'id'))) {
            echo '<div class="success">✅ Sizning Chat ID <code>' . $chatId . '</code> to\'g\'ri!</div>';
        } else {
            echo '<div class="error">❌ Sizning Chat ID <code>' . $chatId . '</code> topilmadi!</div>';
            echo '<div class="warning">⚠️ Yuqoridagi ro\'yxatdan to\'g\'ri Chat ID ni tanlang va params.php da o\'zgartiring!</div>';
        }

    } else {
        echo '<div class="warning">⚠️ Hech qanday xabar topilmadi!<br><br>';
        echo '<strong>Chat ID olish uchun:</strong><br>';
        echo '1. Botga (yoki guruhga) biror xabar yuboring<br>';
        echo '2. Ushbu sahifani yangilang (F5)<br>';
        echo '</div>';
    }

    // Test 3: Test xabar yuborish
    echo "<h2>3️⃣ Test Xabar Yuborish</h2>";

    if (isset($_GET['send_test'])) {
        $testMessage = "🧪 <b>TEST XABAR</b>\n\n";
        $testMessage .= "✅ Agar bu xabarni ko'ryapsangiz, hammasi to'g'ri ishlayapti!\n\n";
        $testMessage .= "📅 Vaqt: " . date('d.m.Y H:i:s') . "\n";
        $testMessage .= "🔗 Server: " . $_SERVER['HTTP_HOST'];

        $sendUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $testMessage,
            'parse_mode' => 'HTML'
        ];

        $ch = curl_init($sendUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode == 200 && isset($result['ok']) && $result['ok']) {
            echo '<div class="success">✅ <strong>Xabar muvaffaqiyatli yuborildi!</strong><br>';
            echo 'Telegram\'dan tekshiring!</div>';
        } else {
            echo '<div class="error">❌ <strong>Xabar yuborilmadi!</strong><br><br>';
            echo '<strong>HTTP Code:</strong> ' . $httpCode . '<br>';
            echo '<strong>Xato:</strong><br>';
            echo '<pre>' . htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . '</pre>';

            // Umumiy xatolar
            if (isset($result['description'])) {
                $desc = $result['description'];

                if (strpos($desc, 'chat not found') !== false) {
                    echo '<div class="warning">⚠️ <strong>Chat topilmadi!</strong><br>';
                    echo 'Sabablari:<br>';
                    echo '• Chat ID noto\'g\'ri<br>';
                    echo '• Botga /start yubormagan<br>';
                    echo '• Botni guruhga qo\'shmagan<br>';
                    echo '</div>';
                }

                if (strpos($desc, 'Forbidden') !== false) {
                    echo '<div class="warning">⚠️ <strong>Ruxsat berilmagan!</strong><br>';
                    echo 'Sabablari:<br>';
                    echo '• Botni guruhdan chiqarib yuborgan<br>';
                    echo '• Bot admin emas (guruh uchun)<br>';
                    echo '• Bot bloklangan<br>';
                    echo '</div>';
                }
            }
            echo '</div>';
        }
    } else {
        echo '<div class="info">';
        echo '<strong>Test xabar yuborish:</strong><br>';
        echo 'Chat ID: <code>' . $chatId . '</code><br><br>';
        echo '<a href="?send_test=1"><button class="btn-secondary">📤 Test Xabar Yuborish</button></a>';
        echo '</div>';
    }

    // Yo'riqnoma
    echo "<h2>📚 To'g'ri Chat ID Olish Yo'riqnomasi</h2>";
    echo '<div class="step">';
    echo '<h3>Variant 1: Shaxsiy botga yuborish</h3>';
    echo '1. Botingizni toping (username: @' . ($botInfo['result']['username'] ?? 'your_bot') . ')<br>';
    echo '2. Botga /start yuboring<br>';
    echo '3. Ushbu sahifani yangilang<br>';
    echo '4. "Chat ID Tekshiruvi" bo\'limidan Chat ID ni oling<br>';
    echo '</div>';

    echo '<div class="step">';
    echo '<h3>Variant 2: Guruhga yuborish</h3>';
    echo '1. Telegram guruh yarating<br>';
    echo '2. Botni guruhga qo\'shing<br>';
    echo '3. Botni <strong>admin</strong> qiling<br>';
    echo '4. Guruhda biror xabar yuboring<br>';
    echo '5. Ushbu sahifani yangilang<br>';
    echo '6. Guruh Chat ID si <strong>minus (-)</strong> bilan boshlanadi<br>';
    echo '7. Chat ID odatda shunday: <code>-100XXXXXXXXXX</code><br>';
    echo '</div>';

    echo '<div class="step">';
    echo '<h3>Variant 3: IDBot yordamida (eng oson)</h3>';
    echo '1. Telegram\'da @myidbot ni toping<br>';
    echo '2. Botga /start yuboring<br>';
    echo '3. Shaxsiy ID ni olish uchun: /getid<br>';
    echo '4. Guruh ID ni olish uchun: Botni guruhga qo\'shing va /getgroupid yuboring<br>';
    echo '</div>';

    // Joriy sozlamalar
    echo "<h2>⚙️ Joriy Sozlamalar</h2>";
    echo '<pre>';
    echo "Bot Token: " . substr($botToken, 0, 20) . "...\n";
    echo "Chat ID: " . $chatId . "\n";
    echo "\nparams.php dagi kod:\n\n";
    echo htmlspecialchars("'telegramBotToken' => '{$botToken}',\n");
    echo htmlspecialchars("'telegramChatId' => '{$chatId}',");
    echo '</pre>';

    ?>

    <h2>🔧 Keyingi Qadamlar</h2>
    <div class="info">
        <ol>
            <li>Agar yuqoridagi barcha testlar muvaffaqiyatli bo'lsa ✅</li>
            <li>Saytingizda vakansiya formasini to'ldiring</li>
            <li>Telegram guruhingizda xabar kelishini kuting</li>
            <li>Agar xabar kelmasa, <code>frontend/runtime/logs/app.log</code> faylini tekshiring</li>
        </ol>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 5px;">
        <h3>📝 Tez Ko'chirish</h3>
        <p>Agar yangi Chat ID topgan bo'lsangiz, uni params.php ga qo'shing:</p>
        <pre><?php
            echo "// common/config/params.php yoki frontend/config/params-local.php\n";
            echo "return [\n";
            echo "    // ... boshqa sozlamalar ...\n";
            echo "    'telegramBotToken' => '{$botToken}',\n";
            echo "    'telegramChatId' => 'TO\'G\'RI_CHAT_ID_NI_YOZING', // Yuqoridan oling\n";
            echo "];";
            ?></pre>
    </div>
</div>
</body>
</html>