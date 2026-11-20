<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, array $body): never
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond(405, ['error' => 'Method not allowed']);
}

try {
    $pdo = require __DIR__ . '/db.php';
    $statement = $pdo->query(
        "SELECT id, name, region, description, jlpt_requirement, eju_requirement, "
        . "english_requirement, tuition, website_url "
        . "FROM schools WHERE category = '大学' AND status = 'published' "
        . 'ORDER BY name, id'
    );
    echo json_encode(['universities' => $statement->fetchAll()], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    error_log($error->getMessage());
    respond(500, ['error' => '大学情報を読み込めませんでした']);
}
