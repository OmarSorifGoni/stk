-- Populate existing university and vocational-school information.
-- Run once against the stk_support database.
INSERT INTO schools
    (name, category, region, description, jlpt_requirement, eju_requirement, english_requirement, tuition, website_url, status)
SELECT * FROM (
    SELECT '東京大学', '大学', '東京都文京区', '日本トップレベル大学', 'N1推奨', 'EJU高得点必要', '英語力必要', '54万円', 'https://www.u-tokyo.ac.jp/', 'published' UNION ALL
    SELECT '早稲田大学', '大学', '東京都新宿区', '面接あり', 'N1推奨', 'EJU必要', '留学生が多い人気大学', '120万円', 'https://www.waseda.jp/', 'published' UNION ALL
    SELECT '慶應義塾大学', '大学', '東京都港区', '有名私立大学', 'N1推奨', '面接あり', 'TOEFL/IELTS必要', '130万円', 'https://www.keio.ac.jp/', 'published' UNION ALL
    SELECT '上智大学', '大学', '東京都千代田区', '国際系に強い', 'N1推奨', '面接あり', '英語力重要', '130万円', 'https://www.sophia.ac.jp/', 'published' UNION ALL
    SELECT '明治大学', '大学', '東京都千代田区', '就職に強い', 'N2〜N1', 'EJU必要な場合あり', '留学生歓迎', '120万円', 'https://www.meiji.ac.jp/', 'published' UNION ALL
    SELECT '青山学院大学', '大学', '東京都渋谷区', 'おしゃれなキャンパス', 'N1推奨', '面接あり', '英語力重視', '130万円', 'https://www.aoyama.ac.jp/', 'published' UNION ALL
    SELECT '立教大学', '大学', '東京都豊島区', '英語プログラムあり', 'N2〜N1', '面接あり', '英語教育が人気', '125万円', 'https://www.rikkyo.ac.jp/', 'published' UNION ALL
    SELECT '中央大学', '大学', '東京都八王子市', '法学部が有名', 'N2以上', '面接あり', '留学生歓迎', '115万円', 'https://www.chuo-u.ac.jp/', 'published' UNION ALL
    SELECT '法政大学', '大学', '東京都千代田区', '留学生歓迎', 'N2以上', '面接あり', '留学生サポートあり', '120万円', 'https://www.hosei.ac.jp/', 'published' UNION ALL
    SELECT '日本大学', '大学', '東京都千代田区', '学部数が多い', 'N2以上', '', '留学生歓迎', '110万円', 'https://www.nihon-u.ac.jp/', 'published' UNION ALL
    SELECT '東洋大学', '大学', '東京都文京区', '学費：約100万円', 'N2以上', '面接あり', '留学生サポートあり', '学費比較的安い', 'https://www.toyo.ac.jp/', 'published' UNION ALL
    SELECT '駒澤大学', '大学', '東京都世田谷区', '仏教系大学', 'N2以上', '面接あり', '留学生歓迎', '110万円', 'https://www.komazawa-u.ac.jp/', 'published' UNION ALL
    SELECT '専修大学', '大学', '東京都千代田区', '経済・商学人気', 'N2以上', '', '留学生歓迎', '105万円', 'https://www.senshu-u.ac.jp/', 'published' UNION ALL
    SELECT '神奈川大学', '大学', '神奈川県横浜市', '留学生多数', 'N2以上', '', '留学生が多い', '100万円', 'https://www.kanagawa-u.ac.jp/', 'published' UNION ALL
    SELECT '横浜国立大学', '大学', '神奈川県横浜市', '国立大学', 'N1推奨', 'EJU必要', '英語力必要', '54万円', 'https://www.ynu.ac.jp/', 'published' UNION ALL
    SELECT '関東学院大学', '大学', '神奈川県横浜市', '', 'N2以上', '', '留学生歓迎', '100万円', 'https://univ.kanto-gakuin.ac.jp/', 'published' UNION ALL
    SELECT '桜美林大学', '大学', '東京都町田市', '', 'N2以上', '', '英語プログラムあり', '110万円', 'https://www.obirin.ac.jp/', 'published' UNION ALL
    SELECT '東京工科大学', '大学', '東京都八王子市', 'IT・ゲーム人気', 'N2以上', '', '', '130万円', 'https://www.teu.ac.jp/', 'published' UNION ALL
    SELECT 'デジタルハリウッド大学', '大学', '東京都千代田区', 'ポートフォリオ必要な場合あり', 'N2以上', '', '', '150万円', 'https://www.dhw.ac.jp/', 'published' UNION ALL
    SELECT '湘南工科大学', '大学', '神奈川県藤沢市', '工学系人気', 'N2以上', '', '', '120万円', 'https://www.shonan-it.ac.jp/', 'published' UNION ALL
    SELECT '東海大学', '大学', '神奈川県平塚市', '', 'N2以上', '', '留学生多数', '110万円', 'https://www.u-tokai.ac.jp/', 'published' UNION ALL
    SELECT '神奈川工科大学', '大学', '神奈川県厚木市', 'IT系人気', 'N2以上', '', '', '120万円', 'https://www.kait.jp/', 'published' UNION ALL
    SELECT '学習院大学', '大学', '東京都豊島区', '', 'N1推奨', '面接あり', '', '120万円', 'https://www.univ.gakushuin.ac.jp/', 'published' UNION ALL
    SELECT '國學院大學', '大学', '東京都渋谷区', '', 'N2〜N1', '', '', '110万円', 'https://www.kokugakuin.ac.jp/', 'published' UNION ALL
    SELECT '成蹊大学', '大学', '東京都武蔵野市', '', 'N2〜N1', '', '', '120万円', 'https://www.seikei.ac.jp/university/', 'published' UNION ALL
    SELECT '成城大学', '大学', '東京都世田谷区', '', 'N2〜N1', '小論文あり', '', '120万円', 'https://www.seijo.ac.jp/', 'published' UNION ALL
    SELECT '武蔵大学', '大学', '東京都練馬区', '', 'N2以上', '', '留学生歓迎', '110万円', 'https://www.musashi.ac.jp/', 'published' UNION ALL
    SELECT '武蔵野大学', '大学', '東京都江東区', '国際交流あり', 'N2以上', '', '', '115万円', 'https://www.musashino-u.ac.jp/', 'published' UNION ALL
    SELECT '東京経済大学', '大学', '東京都国分寺市', '', 'N2以上', '面接あり', '', '110万円', 'https://www.tku.ac.jp/', 'published' UNION ALL
    SELECT '東京農業大学', '大学', '東京都世田谷区', '', 'N2以上', '理科系歓迎', '', '125万円', 'https://www.nodai.ac.jp/', 'published' UNION ALL
    SELECT '東京電機大学', '大学', '東京都足立区', 'IT・工学人気', 'N2以上', '', '', '130万円', 'https://www.dendai.ac.jp/', 'published' UNION ALL
    SELECT '工学院大学', '大学', '東京都新宿区', '', 'N2以上', '数学試験あり', '', '130万円', 'https://www.kogakuin.ac.jp/', 'published' UNION ALL
    SELECT '東京理科大学', '大学', '東京都新宿区', '', 'N1推奨', '数学・理科重要', '', '140万円', 'https://www.tus.ac.jp/', 'published' UNION ALL
    SELECT '帝京大学', '大学', '東京都板橋区', '', 'N2以上', '', '留学生サポート強い', '110万円', 'https://www.teikyo-u.ac.jp/', 'published' UNION ALL
    SELECT '拓殖大学', '大学', '東京都文京区', '国際学部人気', 'N2以上', '', '', '105万円', 'https://www.takushoku-u.ac.jp/', 'published' UNION ALL
    SELECT '大東文化大学', '大学', '東京都板橋区', '外国語学部あり', 'N2以上', '', '', '105万円', 'https://www.daito.ac.jp/', 'published' UNION ALL
    SELECT '東京都市大学', '大学', '東京都世田谷区', '工学系試験あり', 'N2以上', '', '', '130万円', 'https://www.tcu.ac.jp/', 'published' UNION ALL
    SELECT '明星大学', '大学', '東京都日野市', '編入可能', 'N2以上', '', '', '110万円', 'https://www.meisei-u.ac.jp/', 'published' UNION ALL
    SELECT '玉川大学', '大学', '東京都町田市', '', 'N2以上', '', '英語教育あり', '120万円', 'https://www.tamagawa.jp/university/', 'published' UNION ALL
    SELECT '多摩大学', '大学', '東京都多摩市', '', 'N2以上', '面接あり', '', '110万円', 'https://www.tama.ac.jp/', 'published' UNION ALL
    SELECT '神奈川県立保健福祉大学', '大学', '神奈川県横須賀市', '医療系条件あり', 'N1推奨', '', '', '60万円', 'https://www.kuhs.ac.jp/', 'published' UNION ALL
    SELECT '横浜商科大学', '大学', '神奈川県横浜市', '商学人気', 'N2以上', '', '', '105万円', 'https://www.shodai.ac.jp/', 'published' UNION ALL
    SELECT '鶴見大学', '大学', '神奈川県横浜市', '', 'N2以上', '面接あり', '', '115万円', 'https://www.tsurumi-u.ac.jp/', 'published' UNION ALL
    SELECT 'フェリス女学院大学', '大学', '神奈川県横浜市', '', 'N2〜N1', '', '英語教育あり', '120万円', 'https://www.ferris.ac.jp/', 'published' UNION ALL
    SELECT '横浜薬科大学', '大学', '神奈川県横浜市', '', 'N1推奨', '理科系必要', '', '150万円', 'https://www.hamayaku.ac.jp/', 'published' UNION ALL
    SELECT '麻布大学', '大学', '神奈川県相模原市', '生物系歓迎', 'N2以上', '', '', '130万円', 'https://www.azabu-u.ac.jp/', 'published' UNION ALL
    SELECT '相模女子大学', '大学', '神奈川県相模原市', '', 'N2以上', '', '留学生歓迎', '110万円', 'https://www.sagami-wu.ac.jp/', 'published' UNION ALL
    SELECT '湘南鎌倉医療大学', '大学', '神奈川県鎌倉市', '医療日本語必要', 'N1推奨', '', '', '140万円', 'https://www.sku.ac.jp/', 'published' UNION ALL
    SELECT '産業能率大学', '大学', '東京都世田谷区', '経営系人気', 'N2以上', '', '', '110万円', 'https://www.sanno.ac.jp/', 'published' UNION ALL
    SELECT '国士舘大学', '大学', '東京都世田谷区', '', 'N2以上', '面接あり', '', '110万円', 'https://www.kokushikan.ac.jp/', 'published' UNION ALL
    SELECT 'HAL東京', '専門学校', '東京都新宿区', 'ゲーム・IT・CGが人気', '留学生条件：N2以上推奨', '', '', '', 'https://www.hal.ac.jp/tokyo', 'published' UNION ALL
    SELECT '日本工学院専門学校', '専門学校', '東京都大田区', 'IT・デザイン・音楽', '留学生条件：N2またはEJU', '', '', '', 'https://www.neec.ac.jp/', 'published' UNION ALL
    SELECT '東京デザインテクノロジーセンター専門学校', '専門学校', '東京都新宿区', 'AI・ゲーム・CG', '留学生条件：N2以上', '', '', '', 'https://www.tech.ac.jp/', 'published' UNION ALL
    SELECT '東京デザイナー学院', '専門学校', '東京都千代田区', 'アニメ・イラスト・デザイン', '留学生条件：日本語学校卒業', '', '', '', 'https://www.tdg.ac.jp/', 'published' UNION ALL
    SELECT '武蔵野調理師専門学校', '専門学校', '東京都豊島区', '料理・ホテル分野', '留学生条件：N3〜N2', '', '', '', 'https://www.musashino-chouri.ac.jp/', 'published' UNION ALL
    SELECT '横浜医療専門学校', '専門学校', '神奈川県横浜市', '医療・福祉分野', '留学生条件：N2以上', '', '', '', 'https://www.yokohama-iryo.ac.jp/', 'published' UNION ALL
    SELECT '東京エアトラベル・ホテル専門学校', '専門学校', '東京都中野区', 'ホテル・観光', '', '留学生条件：面接あり', '', '', 'https://www.tit.ac.jp/', 'published' UNION ALL
    SELECT '日本自動車大学校', '専門学校', '神奈川県横浜市', '自動車整備', '留学生条件：N3以上', '', '', '', 'https://www.nats.ac.jp/', 'published' UNION ALL
    SELECT 'ESPエンタテインメント東京', '専門学校', '東京都新宿区', '音楽・声優', '留学生条件：日本語能力必要', '', '', '', 'https://www.esp.ac.jp/', 'published' UNION ALL
    SELECT '山野美容専門学校', '専門学校', '東京都渋谷区', '美容・メイク', '留学生条件：N2推奨', '', '', '', 'https://www.yamano-bc.jp/', 'published' UNION ALL
    SELECT '東京製菓学校', '専門学校', '東京都新宿区', 'パティシエ・製菓', '留学生条件：N3以上', '', '', '', 'https://www.tokyoseika.ac.jp/', 'published' UNION ALL
    SELECT '文化服装学院', '専門学校', '東京都渋谷区', 'ファッション分野', '', '留学生条件：作品提出あり', '', '', 'https://www.bunka-fc.ac.jp/', 'published' UNION ALL
    SELECT '日本写真芸術専門学校', '専門学校', '東京都渋谷区', '写真・映像分野', '留学生条件：N2推奨', '', '', '', 'https://www.jps.ac.jp/', 'published' UNION ALL
    SELECT '東京IT会計専門学校', '専門学校', '東京都杉並区', 'IT・会計・公務員', '留学生条件：N2以上', '', '', '', 'https://www.tokyo-itkaikei.ac.jp/', 'published' UNION ALL
    SELECT '東京観光専門学校', '専門学校', '東京都新宿区', '観光・ホテル', '', '留学生条件：面接あり', '', '', 'https://www.tit.ac.jp/', 'published' UNION ALL
    SELECT '東京ビジュアルアーツ', '専門学校', '東京都千代田区', '映像・音楽・写真', '留学生条件：N2推奨', '', '', '', 'https://www.tva.ac.jp/', 'published' UNION ALL
    SELECT '辻調理師専門学校', '専門学校', '東京都小金井市', '調理・製菓', '留学生条件：N3以上', '', '', '', 'https://www.tsuji.ac.jp/', 'published' UNION ALL
    SELECT '東京アニメーションカレッジ', '専門学校', '東京都新宿区', 'アニメ・マンガ', '留学生条件：N2程度', '', '', '', 'https://www.tokyo-anime.jp/', 'published' UNION ALL
    SELECT '資生堂美容技術専門学校', '専門学校', '東京都板橋区', '美容・ヘアメイク', '留学生条件：N2推奨', '', '', '', 'https://www.shiseido-gaza.com/', 'published' UNION ALL
    SELECT '東京交通短期大学', '専門学校', '東京都豊島区', '鉄道・交通', '留学生条件：N2以上', '', '', '', 'https://www.koutan.ac.jp/', 'published' UNION ALL
    SELECT '東京医薬看護専門学校', '専門学校', '東京都江戸川区', '医療・看護', '留学生条件：N2以上', '', '', '', 'https://www.tcm.ac.jp/', 'published' UNION ALL
    SELECT '日本電子専門学校', '専門学校', '東京都新宿区', 'IT・AI・ゲーム', '留学生条件：N2推奨', '', '', '', 'https://www.jec.ac.jp/', 'published' UNION ALL
    SELECT '東京モード学園', '専門学校', '東京都新宿区', 'ファッション・デザイン', '留学生条件：N2程度', '', '', '', 'https://www.mode.ac.jp/tokyo', 'published' UNION ALL
    SELECT '専門学校東京スクールオブビジネス', '専門学校', '東京都渋谷区', '経営・ペット・IT', '留学生条件：日本語試験あり', '', '', '', 'https://www.tsb-yyg.ac.jp/', 'published' UNION ALL
    SELECT '東京スクールオブミュージック', '専門学校', '25.東京都江戸川区', '音楽・ダンス', '', '留学生条件：実技面接あり', '', '', 'https://www.tsm.ac.jp/', 'published' UNION ALL
    SELECT '日本航空大学校', '専門学校', '神奈川県横浜市', '航空・整備', '留学生条件：N2以上', '', '', '', 'https://www.jaa-tech.jp/', 'published' UNION ALL
    SELECT '湘央医学技術専門学校', '専門学校', '神奈川県綾瀬市', '医療技術', '留学生条件：N2程度', '', '', '', 'https://sho-oh.ac.jp/', 'published' UNION ALL
    SELECT '横浜デザイン学院', '専門学校', '神奈川県横浜市', 'デザイン・イラスト', '留学生条件：N2推奨', '', '', '', 'https://www.ydc.ac.jp/', 'published' UNION ALL
    SELECT '横浜fカレッジ', '専門学校', '神奈川県横浜市', 'ファッション・美容', '留学生条件：N3〜N2', '', '', '', 'https://www.yfc.ac.jp/', 'published' UNION ALL
    SELECT '東京すし和食調理専門学校', '専門学校', '東京都世田谷区', '寿司・和食', '留学生条件：日本語面接あり', '', '', '', 'https://www.tokyosushiacademy.com/', 'published' UNION ALL
    SELECT 'KCS福岡情報専門学校 東京校', '専門学校', '東京都台東区', 'IT・システム開発', '留学生条件：N2以上', '', '', '', 'https://www.kcs.ac.jp/', 'published' UNION ALL
    SELECT '阿佐ヶ谷美術専門学校', '専門学校', '東京都杉並区', 'デザイン・アート', '', '留学生条件：作品提出', '', '', 'https://www.asabi.ac.jp/', 'published' UNION ALL
    SELECT '東京ゲームデザイナー学院', '専門学校', '東京都千代田区', 'ゲーム開発', '留学生条件：N2程度', '', '', '', 'https://www.tdg.ac.jp/', 'published' UNION ALL
    SELECT '華調理製菓専門学校', '専門学校', '東京都台東区', '調理・製菓', '留学生条件：N3以上', '', '', '', 'https://www.hana.ac.jp/', 'published' UNION ALL
    SELECT '尚美ミュージックカレッジ', '専門学校', '東京都文京区', '音楽・作曲', '', '留学生条件：実技試験あり', '', '', 'https://www.shobi.ac.jp/', 'published' UNION ALL
    SELECT '東京スマホ専門学校', '専門学校', '東京都新宿区', 'アプリ・AI開発', '留学生条件：N2以上', '', '', '', '', 'published' UNION ALL
    SELECT '神奈川情報IT専門学校', '専門学校', '神奈川県横浜市', 'IT・AI', '留学生条件：N2推奨', '', '', '', '', 'published' UNION ALL
    SELECT '横浜観光専門学校', '専門学校', '神奈川県横浜市', '観光・ホテル', '', '留学生条件：面接あり', '', '', '', 'published' UNION ALL
    SELECT '日本映画大学専門部', '専門学校', '神奈川県川崎市', '映画・映像', '留学生条件：N2程度', '', '', '', 'https://www.eiga.ac.jp/', 'published' UNION ALL
    SELECT '湘南医療福祉専門学校', '専門学校', '神奈川県横浜市', '医療・福祉', '留学生条件：N2以上', '', '', '', 'https://www.smw.ac.jp/', 'published'
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM schools WHERE schools.name = seed.name AND schools.category = seed.category);
