<?php
$jobs = [
    [
        'id' => 'convenience-store',
        'title' => 'コンビニスタッフ',
        'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/7-Eleven_Glow_%2824450652778%29.jpg/960px-7-Eleven_Glow_%2824450652778%29.jpg',
        'image_alt' => '日本のセブン‐イレブン店舗の夜景',
        'image_credit' => [
            'name' => 'Aleister Kelman / Wikimedia Commons',
            'url' => 'https://commons.wikimedia.org/wiki/File:7-Eleven_Glow_(24450652778).jpg',
            'license' => 'CC BY 2.0',
            'license_url' => 'https://creativecommons.org/licenses/by/2.0/',
        ],
        'location' => '神奈川県横浜市',
        'station' => '横浜駅',
        'wage' => '時給 ¥1,200〜',
        'hours' => '1日4時間〜',
        'days' => '週2日〜',
        'japanese' => 'N4程度〜',
        'description' => 'レジ対応、商品の品出し、売り場の清掃など。シフトや担当業務は、面接時に相談できます。',
    ],
    [
        'id' => 'restaurant',
        'title' => 'レストランスタッフ',
        'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Torikizoku-Nishio.jpg/960px-Torikizoku-Nishio.jpg',
        'image_alt' => '鳥貴族 西尾店の外観',
        'image_credit' => [
            'name' => 'HQA02330 / Wikimedia Commons',
            'url' => 'https://commons.wikimedia.org/wiki/File:Torikizoku-Nishio.jpg',
            'license' => 'CC BY-SA 4.0',
            'license_url' => 'https://creativecommons.org/licenses/by-sa/4.0/',
        ],
        'location' => '神奈川県横浜市中区',
        'station' => '関内駅',
        'wage' => '時給 ¥1,250〜',
        'hours' => '1日4時間〜',
        'days' => '週2日〜',
        'japanese' => 'N4程度〜',
        'description' => 'お客様のご案内、料理の提供、テーブルの片付けなど。接客と簡単な準備・片付けを担当します。',
    ],
];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="留学生歓迎のアルバイト情報。勤務地、時給、シフト、日本語レベルなどを確認できます。">
    <title>留学生歓迎のアルバイト | 留学生サポートサイト</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="jobs-theme">
    <header>
        <h1>留学生歓迎のアルバイト</h1>
        <p>勤務地やシフト、日本語レベルから仕事を探せます</p>
    </header>

    <nav aria-label="メインナビゲーション">
        <a href="index.html">ホーム</a>
        <a href="university.html">🎓大学情報</a>
        <a href="senmon.html">🎓専門学校情報</a>
        <a href="jobs.php" aria-current="page">アルバイト</a>
        <a href="life.html">🏠生活サポート</a>
        <a href="contact.html">📩お問い合わせ</a>
    </nav>

    <main class="jobs-page">
        <div class="jobs-intro">
            <p class="jobs-eyebrow">PART-TIME JOBS</p>
            <h2>自分に合う働き方を見つけよう</h2>
            <p>留学生の応募を歓迎する仕事の掲載例です。募集状況や実際の条件は、応募前にお問い合わせください。</p>
        </div>

        <section class="jobs-grid" aria-label="アルバイト一覧">
            <?php foreach ($jobs as $job): ?>
                <article class="job-card">
                    <img class="job-card-image" src="<?= htmlspecialchars($job['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($job['image_alt'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php if (isset($job['image_credit'])): ?>
                        <p class="job-image-credit">写真: <a href="<?= htmlspecialchars($job['image_credit']['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($job['image_credit']['name'], ENT_QUOTES, 'UTF-8') ?></a>・<a href="<?= htmlspecialchars($job['image_credit']['license_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($job['image_credit']['license'], ENT_QUOTES, 'UTF-8') ?></a></p>
                    <?php endif; ?>
                    <div class="job-card-heading">
                        <div>
                            <p class="job-category">留学生歓迎</p>
                            <h3><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                        </div>
                    </div>

                    <dl class="job-details">
                        <div><dt>勤務地</dt><dd><?= htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                        <div><dt>最寄り駅</dt><dd><?= htmlspecialchars($job['station'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                        <div><dt>時給</dt><dd><?= htmlspecialchars($job['wage'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                        <div><dt>勤務時間</dt><dd><?= htmlspecialchars($job['hours'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                        <div><dt>勤務日数</dt><dd><?= htmlspecialchars($job['days'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                        <div><dt>日本語レベル</dt><dd><?= htmlspecialchars($job['japanese'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                        <div class="job-description"><dt>仕事内容</dt><dd><?= htmlspecialchars($job['description'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                    </dl>

                    <p class="job-student-note">留学生の応募歓迎</p>
                    <a class="job-apply-link" href="contact.html?job=<?= rawurlencode($job['title']) ?>">この仕事に応募・問い合わせる <span aria-hidden="true">→</span></a>
                </article>
            <?php endforeach; ?>
        </section>

        <aside class="work-permission-note">
            <h2>⚠️ 留学生のアルバイトルール</h2>
            <ul>
                <li>アルバイトには、原則として資格外活動許可が必要です。</li>
                <li>包括許可の場合、勤務は原則として週28時間以内です。</li>
                <li>学校が定める長期休業期間中は、1日8時間以内が目安です。</li>
                <li>学校の勉強を優先し、学業に支障が出ないようにしましょう。</li>
                <li>風俗営業など、資格外活動が禁止されている仕事に注意してください。</li>
            </ul>
            <p>ルールは在留資格や個別の許可内容によって異なる場合があります。自分の在留カードや資格外活動許可書類を必ず確認してください。雇用主にも、外国人がその仕事に就ける資格があるか確認することが求められています。</p>
            <p>アルバイトにも日本の最低賃金制度が適用されます。勤務地の最低賃金を確認しましょう。</p>
        </aside>
    </main>

    <footer>
        <p>© 2026 留学生サポートサイト</p>
    </footer>
</body>

</html>