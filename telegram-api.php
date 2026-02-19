<?php
// Вказуємо, що ми приймаємо та віддаємо дані у форматі JSON
header('Content-Type: application/json');

// ТУТ ХОВАЄМО НАШІ КЛЮЧІ (користувачі їх не побачать)
$botToken = '8255112696:AAH618AP2t9MROWhov-sKLWsr_24WxadmfI';
$chatId = '1266321063';

// Отримуємо дані, які прислав наш JavaScript
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['name']) && isset($data['phone'])) {
    $name = $data['name'];
    $phone = $data['phone'];
    $text = "🔔 ЗАЯВКА\n👤 $name\n📞 $phone";

    // Відправляємо запит до Telegram з нашого сервера
    $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $postData = json_encode(['chat_id' => $chatId, 'text' => $text]);

    $ch = curl_init($telegramUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Немає даних']);
}
?>