<?php
$properties = [
    [
        'name' => 'グリーンハイツ',
        'area' => '横浜',
        'address' => '横浜市',
        'station' => '黄金町駅',
        'walk_minutes' => 7,
        'layout' => '1K',
        'size' => 19.87,
        'rent' => 65000,
    ],
    [
        'name' => 'N-FLATS横浜関内II',
        'area' => '横浜',
        'address' => '横浜市中区',
        'station' => '関内駅',
        'walk_minutes' => 12,
        'layout' => '1LDK',
        'size' => 41.33,
        'rent' => 152000,
    ],
];

$areas = ['all' => 'すべて', '横浜' => '横浜', '川崎' => '川崎', '東京' => '東京'];
$layouts = ['all' => 'すべて', '1K' => '1K', '1LDK' => '1LDK'];
$rentLimits = ['all' => '指定なし', '80000' => '～80,000円', '120000' => '～120,000円', '160000' => '～160,000円'];
$walkLimits = ['all' => '指定なし', '5' => '5分以内', '10' => '10分以内', '15' => '15分以内'];

$areaFilter = (string) ($_GET['area'] ?? 'all');
$layoutFilter = (string) ($_GET['layout'] ?? 'all');
$rentFilter = (string) ($_GET['max_rent'] ?? 'all');
$walkFilter = (string) ($_GET['max_walk'] ?? 'all');

if (!array_key_exists($areaFilter, $areas)) $areaFilter = 'all';
if (!array_key_exists($layoutFilter, $layouts)) $layoutFilter = 'all';
if (!array_key_exists($rentFilter, $rentLimits)) $rentFilter = 'all';
if (!array_key_exists($walkFilter, $walkLimits)) $walkFilter = 'all';

$filteredProperties = array_values(array_filter($properties, static function (array $property) use ($areaFilter, $layoutFilter, $rentFilter, $walkFilter): bool {
    return ($areaFilter === 'all' || $property['area'] === $areaFilter)
        && ($layoutFilter === 'all' || $property['layout'] === $layoutFilter)
        && ($rentFilter === 'all' || $property['rent'] <= (int) $rentFilter)
        && ($walkFilter === 'all' || $property['walk_minutes'] <= (int) $walkFilter);
}));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="留学生向けに、横浜・川崎・東京エリアの部屋探しの情報を紹介します。">
    <title>家探し | 留学生サポートサイト</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🏠 家探し</h1>
        <p>留学生向けの部屋・アパート情報</p>
    </header>

    <nav aria-label="メインナビゲーション">
        <a href="index.html">ホーム</a>
        <a href="university.html">🎓大学情報</a>
        <a href="senmon.html">🎓専門学校情報</a>
        <a href="jobs.php">✨ アルバイト</a>
        <a href="life.html">🏠生活サポート</a>
        <a href="contact.html">📩お問い合わせ</a>
    </nav>

    <main class="house-page">
        <section class="house-intro">
            <p class="house-eyebrow">HOUSING FOR INTERNATIONAL STUDENTS</p>
            <h2>横浜・川崎・東京エリアの住まいを探せます</h2>
            <p>エリア、間取り、家賃、駅からの距離を選んで、掲載例を絞り込めます。</p>
        </section>

        <section class="house-search" aria-labelledby="house-search-title">
            <h2 id="house-search-title">🔎 部屋を探す</h2>
            <form method="get" action="house.php">
                <div class="house-filter-grid">
                    <label for="area">📍 エリア
                        <select id="area" name="area">
                            <?php foreach ($areas as $value => $label): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" <?= $areaFilter === $value ? 'selected' : '' ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label for="layout">🏠 間取り
                        <select id="layout" name="layout">
                            <?php foreach ($layouts as $value => $label): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" <?= $layoutFilter === $value ? 'selected' : '' ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label for="max-rent">💴 家賃
                        <select id="max-rent" name="max_rent">
                            <?php foreach ($rentLimits as $value => $label): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" <?= $rentFilter === $value ? 'selected' : '' ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label for="max-walk">🚆 駅から
                        <select id="max-walk" name="max_walk">
                            <?php foreach ($walkLimits as $value => $label): ?>
                                <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" <?= $walkFilter === $value ? 'selected' : '' ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="house-search-actions">
                    <a href="house.php" class="house-reset-link">条件をクリア</a>
                    <button type="submit">🔍 検索する</button>
                </div>
            </form>
        </section>

        <section class="house-results" aria-labelledby="house-results-title">
            <div class="house-results-heading">
                <h2 id="house-results-title">おすすめ物件</h2>
                <p role="status" aria-live="polite"><?= count($filteredProperties) ?>件の掲載例</p>
            </div>
            <p class="house-sample-note">掲載例です。現在の空室状況、賃料、入居条件は確認できていません。問い合わせ先で最新情報をご確認ください。</p>

            <?php if ($filteredProperties === []): ?>
                <p class="house-empty" role="status">条件に合う掲載例はありません。検索条件を変更してください。</p>
            <?php else: ?>
                <div class="house-listings">
                    <?php foreach ($filteredProperties as $property): ?>
                        <article class="house-listing">
                            <div class="house-listing-heading">
                                <span aria-hidden="true">🏠</span>
                                <h3><?= htmlspecialchars($property['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            </div>
                            <dl class="house-details">
                                <div><dt>📍 エリア</dt><dd><?= htmlspecialchars($property['address'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                                <div><dt>🚆 最寄り駅</dt><dd><?= htmlspecialchars($property['station'], ENT_QUOTES, 'UTF-8') ?> 徒歩<?= (int) $property['walk_minutes'] ?>分</dd></div>
                                <div><dt>🏠 間取り</dt><dd><?= htmlspecialchars($property['layout'], ENT_QUOTES, 'UTF-8') ?></dd></div>
                                <div><dt>📐 専有面積</dt><dd><?= number_format($property['size'], 2) ?>㎡</dd></div>
                                <div class="house-rent"><dt>💴 家賃</dt><dd>¥<?= number_format($property['rent']) ?>/月</dd></div>
                            </dl>
                            <details class="house-more">
                                <summary>物件詳細</summary>
                                <p>初期費用、敷金・礼金、保証会社、外国籍の入居条件、設備、契約期間については物件ごとに異なります。内見や契約の前に不動産会社へご確認ください。</p>
                            </details>
                            <a class="house-contact-link" href="contact.html?property=<?= rawurlencode($property['name']) ?>">🏠 この物件について問い合わせる <span aria-hidden="true">→</span></a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="house-tips" aria-labelledby="house-tips-title">
            <h2 id="house-tips-title">📋 留学生が部屋を探すときのポイント</h2>
            <ul>
                <li>初期費用</li>
                <li>敷金・礼金</li>
                <li>保証会社</li>
                <li>外国人入居可か</li>
                <li>駅からの距離</li>
                <li>家具・家電</li>
                <li>契約期間</li>
            </ul>
        </section>

        <aside class="house-warning">
            <h2>⚠️ 注意</h2>
            <p>掲載情報は各不動産会社の最新情報を確認してください。契約条件や初期費用も、契約前に必ず書面で確認しましょう。</p>
        </aside>
    </main>

    <footer>
        <p>© 2026 留学生サポートサイト</p>
    </footer>
</body>
</html>