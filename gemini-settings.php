<?php
declare(strict_types=1);

$allowedAddresses = ['127.0.0.1', '::1'];
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', $allowedAddresses, true)) {
    http_response_code(403);
    exit('This settings page is available only from this computer.');
}

session_start();
header('Cache-Control: no-store');

if (empty($_SESSION['gemini_settings_token'])) {
    $_SESSION['gemini_settings_token'] = bin2hex(random_bytes(32));
}

$config = @include __DIR__ . '/db-config.php';
@include_once __DIR__ . '/config.php';
$apiUrl = defined('GEMINI_API_URL')
    ? (string) GEMINI_API_URL
    : (is_array($config) ? (string) ($config['gemini_api_url'] ?? 'https://generativelanguage.googleapis.com/v1beta') : 'https://generativelanguage.googleapis.com/v1beta');
$model = defined('GEMINI_MODEL')
    ? (string) GEMINI_MODEL
    : (is_array($config) ? (string) ($config['gemini_model'] ?? 'gemini-3.8-flash') : 'gemini-3.8-flash');
$storedApiKey = defined('GEMINI_API_KEY')
    ? trim((string) GEMINI_API_KEY)
    : (is_array($config) ? trim((string) ($config['gemini_api_key'] ?? '')) : '');
$hasApiKey = $storedApiKey !== '';
$message = '';
$messageType = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf_token'] ?? '');
    $apiKey = trim((string) ($_POST['api_key'] ?? ''));
    $apiUrl = trim((string) ($_POST['api_url'] ?? ''));
    $model = trim((string) ($_POST['model'] ?? ''));

    if (!hash_equals($_SESSION['gemini_settings_token'], $token)) {
        http_response_code(400);
        $message = 'フォームの有効期限が切れました。ページを再読み込みしてください。';
        $messageType = 'error';
    } elseif ($apiKey === '' && !$hasApiKey) {
        $message = 'APIキーを入力してください。';
        $messageType = 'error';
    } elseif (filter_var($apiUrl, FILTER_VALIDATE_URL) === false
        || parse_url($apiUrl, PHP_URL_SCHEME) !== 'https'
        || parse_url($apiUrl, PHP_URL_HOST) !== 'generativelanguage.googleapis.com') {
        $message = 'HTTPSのGemini API URLを入力してください。';
        $messageType = 'error';
    } elseif (!preg_match('/^[A-Za-z0-9._-]{1,100}$/', $model)) {
        $message = 'モデル名を確認してください。';
        $messageType = 'error';
    } else {
        if ($apiKey === '') {
            $apiKey = $storedApiKey;
        }
        $configContents = "<?php\n\ndefine('GEMINI_API_KEY', " . var_export($apiKey, true) . ");\n"
            . "define('GEMINI_API_URL', " . var_export($apiUrl, true) . ");\n"
            . "define('GEMINI_MODEL', " . var_export($model, true) . ");\n";

        if (file_put_contents(__DIR__ . '/config.php', $configContents, LOCK_EX) !== false) {
            $hasApiKey = true;
            $message = 'Geminiの設定を保存しました。チャットを再読み込みしてください。';
            $messageType = 'success';
            $_SESSION['gemini_settings_token'] = bin2hex(random_bytes(32));
        } else {
            $message = '設定ファイルに書き込めませんでした。';
            $messageType = 'error';
        }
    }
}

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gemini設定</title>
    <style>
        :root { color-scheme: light; font-family: "Yu Gothic UI", Meiryo, sans-serif; color: #172b3a; background: #f1f6f8; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 620px; margin: 0 auto; padding: 28px; background: #fff; border: 1px solid #d5e2e8; border-radius: 8px; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { line-height: 1.65; }
        .status { margin: 18px 0; padding: 12px 14px; border-radius: 4px; background: #edf3f6; }
        .status.success { color: #145b37; background: #e6f5ec; }
        .status.error { color: #8b2525; background: #fff0ef; }
        label { display: block; margin: 18px 0 6px; font-weight: 600; }
        input { box-sizing: border-box; width: 100%; min-height: 44px; padding: 10px 12px; border: 1px solid #8296a1; border-radius: 4px; font: inherit; }
        button { margin-top: 22px; min-height: 44px; padding: 0 18px; border: 0; border-radius: 4px; background: #146c94; color: #fff; font: inherit; font-weight: 700; cursor: pointer; }
        button:hover { background: #0d5477; }
        small { color: #536975; }
    </style>
</head>
<body>
<main>
    <h1>Gemini API設定</h1>
    <p>このページはこのPCからのみ利用できます。キーはブラウザーに再表示せず、ローカル設定ファイルに保存します。</p>
    <div class="status <?= $hasApiKey ? 'success' : '' ?>">
        APIキー: <?= $hasApiKey ? '設定済み' : '未設定' ?>
    </div>
    <?php if ($message !== ''): ?>
        <div class="status <?= escapeHtml($messageType) ?>" role="status"><?= escapeHtml($message) ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
        <input type="hidden" name="csrf_token" value="<?= escapeHtml($_SESSION['gemini_settings_token']) ?>">
        <label for="api_key">Google AI Studio APIキー</label>
        <input id="api_key" name="api_key" type="password" autocomplete="new-password" <?= $hasApiKey ? '' : 'required' ?>>
        <small>空欄のまま保存すると、現在のキーを維持します。</small>

        <label for="api_url">API URL</label>
        <input id="api_url" name="api_url" type="url" value="<?= escapeHtml($apiUrl) ?>" required>

        <label for="model">モデル</label>
        <input id="model" name="model" value="<?= escapeHtml($model) ?>" required>

        <button type="submit">設定を保存</button>
    </form>
</main>
</body>
</html>