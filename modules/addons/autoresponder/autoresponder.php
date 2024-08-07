<?php

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

function autoresponder_config() {
    return [
        'name' => 'AutoResponder',
        'description' => 'Tự động trả lời ticket bằng ChatGPT',
        'version' => '1.0',
        'author' => 'H2N (<a href="https://topcloud.vn">TopCloud.vn</a>)',
        'fields' => [
            'api_key' => [
                'FriendlyName' => 'ChatGPT API Key',
                'Type' => 'text',
                'Size' => '50',
                'Description' => 'Nhập API Key ChatGPT của bạn tại đây',
                'Default' => '',
            ],
            'admin_username' => [
                'FriendlyName' => 'Admin Username',
                'Type' => 'text',
                'Size' => '20',
                'Description' => 'nhập email người dùng sẽ trả lời ticket vd: bot@example.com',
                'Default' => '',
            ],
            'prompt' => [
                'FriendlyName' => 'Prompt',
                'Type' => 'text',
                'Description' => 'Cung cấp thêm thông tin để câu trả lời thêm chi tiết vd: [nameserver] [tên doanh nghiệp]',
                'Default' => '',
            ],
        ],
    ];
}

function autoresponder_activate() {
    return ['status' => 'success', 'description' => 'AutoResponder addon activated successfully.'];
}

function autoresponder_deactivate() {
    return ['status' => 'success', 'description' => 'AutoResponder addon deactivated successfully.'];
}

function autoresponder_output() {
    echo 'AutoResponder addon is working!';
}
