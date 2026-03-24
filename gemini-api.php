<?php
header('Content-Type: application/json');

// ТУТ ХОВАЄМО КЛЮЧ GEMINI
$apiKey = 'AIzaSyC6Uf5wUTVEF00BCdXtzbpTvCKWlqZDfaM';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['question'])) {
    $question = $data['question'];
    
    $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
    
    // Формуємо запит до AI
    $postData = json_encode([
        "contents" => [
            ["role" => "user", "parts" => [["text" => "Ти менеджер Бастіон-БЦ. Відповідай коротко. Питання: " . $question]]]
        ]
    ]);

    $ch = curl_init($geminiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);

    // Повертаємо відповідь від Gemini назад нашому сайту
    echo $result;
}
?>