<?php

use WHMCS\Database\Capsule;

add_hook('TicketOpen', 1, function($vars) {
    // Bắt đầu log
    logActivity('AutoResponder: Bắt đầu xử lý ticket.');

    // Lấy API key và admin username từ cấu hình addon
    $settings = Capsule::table('tbladdonmodules')
        ->where('module', 'autoresponder')
        ->pluck('value', 'setting')
        ->toArray();

    $apiKey = $settings['api_key'] ?? '';
    $adminUser = $settings['admin_username'] ?? '';
    $prompt = $settings['prompt'] ?? '';

    if (empty($apiKey)) {
        logActivity('AutoResponder: Không tìm thấy API key trong cấu hình.');
        return;
    }

    if (empty($adminUser)) {
        logActivity('AutoResponder: Không tìm thấy admin username trong cấu hình.');
        return;
    }

    logActivity('AutoResponder: API key và admin username đã được lấy thành công.');

    $ticketId = $vars['ticketid'];
    $subject = $vars['subject'];
    $message = $vars['message'];

    logActivity("AutoResponder: Đang xử lý ticket ID: $ticketId với tiêu đề: $subject");

    // Sử dụng API ChatGPT để tạo câu trả lời
    $apiUrl = 'https://api.openai.com/v1/chat/completions';
    $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ];
    
    $temperature = 0.5;
    
    $postData = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => "Bạn là một người hỗ trợ cho doanh nghiệp đang sử dụng whmcs và sẽ trả lời ticket này: Question: $subject\n\n$message\nThông tin thêm về doanh nghiệp:\n$prompt"]
        ],
        'temperature' => $temperature,
    ];

    logActivity("AutoResponder: Đang gọi API ChatGPT với prompt: $subject\n\n$message");

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        logActivity('AutoResponder: Lỗi cURL: ' . curl_error($ch));
        curl_close($ch);
        return;
    }

    curl_close($ch);

    logActivity('AutoResponder: API ChatGPT đã phản hồi.');

    $responseData = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logActivity('AutoResponder: Lỗi khi giải mã phản hồi JSON: ' . json_last_error_msg());
        return;
    }

    $reply = $responseData['choices'][0]['message']['content'] ?? 'Câu hỏi của bạn sẽ được trả lời sớm, cảm ơn bạn đã chờ đợi.';
    $signature = "\n\n---\nPhản hồi này được tạo tự động bởi bot hỗ trợ của chúng tôi.\nNếu bạn có thêm câu hỏi, vui lòng trả lời ticket này.\n\nTrân trọng,\nĐội ngũ hỗ trợ";
    $replyWithSignature = $reply . $signature;
    logActivity("AutoResponder: Câu trả lời đã được tạo: $reply");

    // Trả lời ticket dưới tư cách admin
    $apiResponse = localAPI('AddTicketReply', [
        'ticketid' => $ticketId,
        'message' => $replyWithSignature,
        'adminusername' => $adminUser, // Trả lời dưới tư cách admin
    ]);

    if ($apiResponse['result'] === 'success') {
        logActivity("AutoResponder: Đã trả lời ticket ID: $ticketId thành công.");
    } else {
        logActivity("AutoResponder: Lỗi khi trả lời ticket ID: $ticketId. Phản hồi API: " . json_encode($apiResponse));
    }
});
