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

try {
    $pdo = require __DIR__ . '/db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $schools = $pdo->query(
            'SELECT id, name, category, region, status, updated_at FROM schools ORDER BY updated_at DESC, id DESC'
        )->fetchAll();
        echo json_encode(['schools' => $schools], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT'], true)) {
        respond(405, ['error' => 'Method not allowed']);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        respond(400, ['error' => 'Invalid request']);
    }

    $school = [
        'name' => trim((string) ($input['name'] ?? '')),
        'category' => trim((string) ($input['category'] ?? '')),
        'region' => trim((string) ($input['region'] ?? '')),
        'status' => trim((string) ($input['status'] ?? 'draft')),
    ];

    if ($school['name'] === '' || mb_strlen($school['name'], 'UTF-8') > 200
        || !in_array($school['category'], ['大学', '専門学校'], true)
        || $school['region'] === '' || mb_strlen($school['region'], 'UTF-8') > 160
        || !in_array($school['status'], ['published', 'draft'], true)) {
        respond(422, ['error' => '入力内容を確認してください']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $statement = $pdo->prepare(
            'INSERT INTO schools (name, category, region, status) VALUES (:name, :category, :region, :status)'
        );
        $statement->execute($school);
        respond(201, ['id' => (int) $pdo->lastInsertId()]);
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id || $id < 1) {
        respond(400, ['error' => 'Invalid school ID']);
    }

    $statement = $pdo->prepare(
        'UPDATE schools SET name = :name, category = :category, region = :region, status = :status WHERE id = :id'
    );
    $statement->execute($school + ['id' => $id]);
    $check = $pdo->prepare('SELECT id FROM schools WHERE id = :id');
    $check->execute(['id' => $id]);
    if (!$check->fetchColumn()) {
        respond(404, ['error' => '学校情報が見つかりません']);
    }

    echo json_encode(['id' => $id], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    error_log($error->getMessage());
    respond(500, ['error' => '学校情報を保存できませんでした']);
}