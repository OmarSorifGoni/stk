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

$category = $_GET['category'] ?? '';
if (!in_array($category, ['大学', '専門学校'], true)) {
    respond(400, ['error' => 'Invalid school category']);
}

try {
    $pdo = require __DIR__ . '/db.php';
    $statement = $pdo->prepare(
        'SELECT id, name, category, region, description, jlpt_requirement, eju_requirement, '
        . 'english_requirement, tuition, website_url FROM schools '
        . 'WHERE category = :category AND status = :status ORDER BY name, id'
    );
    $statement->execute(['category' => $category, 'status' => 'published']);
    echo json_encode(['schools' => $statement->fetchAll()], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    error_log($error->getMessage());
    respond(500, ['error' => '学校情報を読み込めませんでした']);
}
