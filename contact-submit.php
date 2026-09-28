<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, array $body): never
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, ['error' => 'POST method required']);
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($name === '' || mb_strlen($name, 'UTF-8') > 120
    || filter_var($email, FILTER_VALIDATE_EMAIL) === false || mb_strlen($email, 'UTF-8') > 320
    || $message === '' || mb_strlen($message, 'UTF-8') > 5000) {
    respond(422, ['error' => '入力内容を確認してください']);
}

try {
    $pdo = require __DIR__ . '/db.php';
    $statement = $pdo->prepare('INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)');
    $statement->execute(['name' => $name, 'email' => $email, 'message' => $message]);
    respond(201, ['ok' => true]);
} catch (Throwable $error) {
    error_log($error->getMessage());
    respond(500, ['error' => '送信を保存できませんでした']);
}