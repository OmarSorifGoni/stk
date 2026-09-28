<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, array $body): never
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    respond(403, ['error' => 'Local access only']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond(405, ['error' => 'GET method required']);
}

try {
    $pdo = require __DIR__ . '/db.php';
    $messages = $pdo->query(
        'SELECT id, name, email, message, created_at FROM contact_messages ORDER BY created_at DESC, id DESC LIMIT 50'
    )->fetchAll();
    echo json_encode(['messages' => $messages], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    error_log($error->getMessage());
    respond(500, ['error' => '問い合わせを読み込めませんでした']);
}