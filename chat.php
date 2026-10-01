<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function respond(int $status, array $payload): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function getGeminiKey(): string
{
    @include_once __DIR__ . '/config.php';
    if (defined('GEMINI_API_KEY') && trim((string) GEMINI_API_KEY) !== '') {
        return trim((string) GEMINI_API_KEY);
    }

    $config = @include __DIR__ . '/db-config.php';
    if (is_array($config) && !empty($config['gemini_api_key'])) {
        return trim((string) $config['gemini_api_key']);
    }

    $envKey = getenv('GEMINI_API_KEY');
    return $envKey !== false ? trim((string) $envKey) : '';
}

function getGeminiApiUrl(): string
{
    @include_once __DIR__ . '/config.php';
    $config = @include __DIR__ . '/db-config.php';
    $envUrl = getenv('GEMINI_API_URL');
    $apiUrl = defined('GEMINI_API_URL') && trim((string) GEMINI_API_URL) !== ''
        ? trim((string) GEMINI_API_URL)
        : (is_array($config) && !empty($config['gemini_api_url'])
            ? trim((string) $config['gemini_api_url'])
            : ($envUrl !== false && trim((string) $envUrl) !== ''
                ? trim((string) $envUrl)
                : 'https://generativelanguage.googleapis.com/v1beta'));

    return preg_replace('~/openai/chat/completions/?$~', '', rtrim($apiUrl, '/')) ?: 'https://generativelanguage.googleapis.com/v1beta';
}

function fallbackReply(string $message, string $lang): string
{
    $text = strtolower($message);

    if ($lang === 'en') {
        if (preg_match('/school|university|study|major|course/i', $text)) {
            return 'For school choices, compare tuition, location, academic field, and whether the school supports international students. Tell me your preferred area and study field.';
        }
        if (preg_match('/house|apartment|dorm|live|home|rent/i', $text)) {
            return 'For housing, compare rent, commute time, safety, and whether you prefer a dormitory or apartment. I can help you shortlist good options.';
        }
        if (preg_match('/job|work|part-time|career|employment/i', $text)) {
            return 'For part-time jobs, check your available working hours and Japanese level. Convenience stores and restaurants are often easier first choices.';
        }
        if (preg_match('/japanese|jlpt|n1|n2|n3|language/i', $text)) {
            return 'For Japanese learning, focus on daily conversation, interview practice, and JLPT study based on your current level. We can plan a study routine together.';
        }
        if (preg_match('/hello|hi|good morning|thanks/i', $text)) {
            return 'Hello! I can help with school, work, housing, and daily life in Japan.';
        }
        return 'Please tell me a bit more about your question. I can help with school, housing, work, or life in Japan.';
    }

    if (preg_match('/大学|学校|専門|進学|学部|学科/i', $message)) {
        return '学校選びでは、学費、勤務地、専攻、留学生サポートの有無を確認すると安心です。希望の分野や地域があれば、より具体的に比較できます。';
    }
    if (preg_match('/住|寮|アパート|ホーム|家賃|住む/i', $message)) {
        return '住まいは、家賃、駅までの距離、治安、寮かアパートかを比較すると選びやすくなります。住みたいエリアや予算があればおすすめを絞れます。';
    }
    if (preg_match('/仕事|バイト|アルバイト|就職|就活/i', $message)) {
        return 'アルバイトは、勤務時間と語学レベルの両方を確認するのが大事です。コンビニや飲食店は比較的入りやすいです。';
    }
    if (preg_match('/日本語|JLPT|N1|N2|N3|語学/i', $message)) {
        return '日本語のレベルに合わせて、日常会話・面接対策・JLPT対策を進めると効果的です。今のレベルと目標があれば、勉強計画も作れます。';
    }
    if (preg_match('/病院|医療|ケガ|体調|健康/i', $message)) {
        return '病院選びでは、外国人対応があるか、最寄り駅、診療時間を確認すると安心です。必要なら病院の選び方も案内できます。';
    }
    if (preg_match('/こんにちは|hello|hi|ありがとう|thanks/i', $message)) {
        return 'こんにちは！留学生活や学校選びのことなら、何でも相談してください。';
    }

    return 'ご相談内容をもう少し詳しく教えてください。学校選び、住まい、仕事、生活など、どのテーマでも対応できます。';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, ['error' => 'POST method required']);
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
    respond(400, ['error' => 'Invalid JSON payload']);
}

$message = trim((string) ($data['message'] ?? ''));
$lang = strtolower((string) ($data['lang'] ?? 'ja'));
$lang = in_array($lang, ['en', 'ja'], true) ? $lang : 'ja';

if ($message === '' || mb_strlen($message, 'UTF-8') > 2000) {
    respond(422, ['error' => 'Message is invalid']);
}

$apiKey = getGeminiKey();

if ($apiKey === '') {
    respond(200, [
        'reply' => fallbackReply($message, $lang),
        'source' => 'fallback',
        'reason' => 'missing_api_key',
    ]);
}

@include_once __DIR__ . '/config.php';
$config = @include __DIR__ . '/db-config.php';
$model = defined('GEMINI_MODEL') && trim((string) GEMINI_MODEL) !== ''
    ? trim((string) GEMINI_MODEL)
    : (is_array($config) && !empty($config['gemini_model'])
        ? trim((string) $config['gemini_model'])
        : (getenv('GEMINI_MODEL') ?: 'gemini-2.5-flash'));
$payload = [
    'systemInstruction' => [
        'parts' => [[
            'text' => 'You are a helpful assistant for international students in Japan. Answer the user’s specific question directly; do not give a generic greeting or topic list unless the user only greets you. Reply in the same language the user writes in, including Bengali and Bengali written with Latin letters. Use ' . ($lang === 'en' ? 'English' : 'Japanese') . ' only when the user’s language is unclear. Give practical, friendly advice about studying, living, housing, jobs, and daily life in Japan.'
        ]]
    ],
    'contents' => [[
        'role' => 'user',
        'parts' => [['text' => $message]]
    ]],
    'generationConfig' => ['temperature' => 0.7],
];

$requestUrl = rtrim(getGeminiApiUrl(), '/') . '/models/' . rawurlencode($model) . ':generateContent';
$response = false;
$httpStatus = 0;
$curlError = '';
for ($attempt = 1; $attempt <= 3; $attempt++) {
    $ch = curl_init($requestUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-goog-api-key: ' . $apiKey,
        ],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
    ]);

    $response = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpStatus !== 503 || $attempt === 3) {
        break;
    }
    usleep(500000 * $attempt);
}

$decodedResponse = is_string($response) ? json_decode($response, true) : null;
$providerMessage = is_array($decodedResponse)
    ? trim((string) ($decodedResponse['error']['message'] ?? ''))
    : '';
if ($providerMessage !== '') {
    $providerMessage = str_replace($apiKey, '[redacted]', $providerMessage);
}

if ($response !== false && $httpStatus >= 200 && $httpStatus < 300) {
    $parts = $decodedResponse['candidates'][0]['content']['parts'] ?? [];
    $content = trim(implode("\n", array_filter(array_map(
        static fn (array $part): string => trim((string) ($part['text'] ?? '')),
        is_array($parts) ? $parts : []
    ))));
    if ($content !== '') {
        respond(200, ['reply' => $content, 'source' => 'gemini']);
    }
}

error_log('Gemini chat request failed: ' . ($curlError !== '' ? $curlError : 'HTTP ' . $httpStatus));
$failureMessage = $httpStatus === 503
    ? ($lang === 'en'
        ? 'Gemini is temporarily busy. Please try again in a little while.'
        : 'Geminiが混み合っています。少し時間をおいてもう一度お試しください。')
    : ($response === false
        ? ($lang === 'en' ? 'Could not connect to Gemini.' : 'Geminiに接続できませんでした。')
        : ($lang === 'en'
            ? 'Gemini returned HTTP ' . $httpStatus . '. ' . $providerMessage
            : 'GeminiからHTTP ' . $httpStatus . ' が返されました。' . $providerMessage));
respond(200, [
    'reply' => fallbackReply($message, $lang),
    'source' => 'fallback',
    'reason' => $failureMessage,
]);
