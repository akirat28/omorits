<?php
/**
 * Template Name: コーチ一覧テンプレート
 * Description: コーチ紹介ページ用テンプレート
 */

get_header();

$image_base = get_template_directory_uri() . '/images/';

$coaches = [
    [
        'name'        => '岩波 広明',
        'name_en'     => 'Hiroaki Iwanami',
        'title'       => 'ヘッドコーチ',
        'badges'      => [
            '川崎室内選手権複優勝',
            '神奈川選手権複準優勝',
            '横浜市民複準優勝',
            '大田区民大会単・複優勝',
            '横浜市民４０才以上単優勝',
            '川崎市民３５才以上単優勝'
        ],
        'description' => '試合での経験を活かし、皆様の上達のお手伝いをしたいと思います。',
        'quote'       => '「試合で結果を出すための"武器"を一緒に磨きましょう。」',
        'image'       => $image_base . 'コーチ.jpg',
    ],
    [
        'name'        => '羽根田 秀明',
        'name_en'     => 'Hideaki Haneeda',
        'title'       => '専属コーチ',
        'badges'      => [
            '日本スポーツ協会公認テニスコーチ２',
            'Wilson Advisory Staff',
            'WAS',
            'チーム  ralosso'
        ],
        'description' => '最近、日本酒にはまってます🍶',
        'quote'       => '「効率的な体の使い方が安定したショットを生みます。」',
        'image'       => $image_base . 'コーチ.jpg',
    ],
    [
        'name'        => '本郷 寛幸',
        'name_en'     => ' Hiroyuki Hongo',
        'title'       => '専属コーチ',
        'badges'      => [
            '日本スポーツ協会公認テニスコーチ1'
        ],
        'description' => '楽しくなくちゃテニスじゃない！楽しみながらテニスのレベルアップをしましょう！！',
        'quote'       => '「大切なのは"勝つための選択"を積み重ねること。」',
        'image'       => $image_base . 'コーチ.jpg',
    ],
    [
        'name'        => '田中 智弘',
        'name_en'     => 'Tomohiro Tanaka',
        'title'       => '専属コーチ',
        'badges'      => [
            'なし',
        ],
        'description' => '皆様に楽しくテニスを上達して頂けるよう、明るく元気にがんばります。',
        'quote'       => '「小さな成功体験を積み重ねることがモチベーションを育てます。」',
        'image'       => $image_base . 'コーチ.jpg',
    ]
];

$flow_steps = [
    [
        'title'       => 'カウンセリング & 目標設定',
        'description' => '現在の課題と理想のプレースタイルを丁寧にヒアリング。上達スケジュールとレッスンプランを一緒に設計します。'
    ],
    [
        'title'       => 'フォーム解析 & 個別レッスン',
        'description' => '動画解析とコーチングでフォームを可視化。実戦レベルを想定したドリルで、習得した技術を確実なものにします。'
    ],
    [
        'title'       => 'ゲーム実践 & フィードバック',
        'description' => '実戦形式のマッチ練習で戦術とメンタルを総合的にチェック。毎回のフィードバックで成果と課題を共有します。'
    ],
];


?>

<main class="site-main coach-page">
    <section class="coach-hero" style="background-image: url('<?php echo esc_url($image_base . 'kv01.jpg'); ?>');">
        <div class="coach-hero__overlay"></div>
        <div class="coach-container coach-hero__content">
            <span class="coach-hero__label">LESSON PRO</span>
            <h1 class="coach-hero__title"><?php echo esc_html(get_the_title()); ?></h1>
            <p class="coach-hero__subtitle">
                経験豊富なコーチ陣が、あなたのプレースタイルに寄り添ったレッスンで上達をサポートします。
                初心者の方から全国大会を目指す選手まで、目的に合わせた最適なトレーニングを提供しています。
            </p>
            <div class="coach-hero__actions">
                <a class="coach-hero__button" href="<?php echo esc_url(home_url('/contact')); ?>">体験レッスンを予約する</a>
            </div>
        </div>
    </section>

    <section class="coach-intro">
        <div class="coach-container">
            <div class="coach-intro__text">
                <span class="coach-section__label">About Coaches</span>
                <h2 class="coach-section__title">目的に合わせた専属チームが伴走</h2>
                <p>
                    大森テニスクラブでは、競技力向上・健康志向・ジュニア育成など、目的別に専門性を備えたコーチが在籍。
                    定期的なミーティングで情報を共有し、個々の課題に対する最適なトレーニングプランを提案します。
                </p>
                <p>
                    レッスンは動画解析やデータを活用しながら、技術・戦術・フィジカル・メンタルの4つの視点からアプローチ。
                    どなたでも安心して継続できるよう、丁寧なコミュニケーションを大切にしています。
                </p>
            </div>
            <div class="coach-intro__stats">
                <div class="coach-stat">
                    <span class="coach-stat__number">1,500+</span>
                    <span class="coach-stat__label">年間指導実績</span>
                </div>
                <div class="coach-stat">
                    <span class="coach-stat__number">92%</span>
                    <span class="coach-stat__label">継続率（6ヶ月）</span>
                </div>
                <div class="coach-stat">
                    <span class="coach-stat__number">58名</span>
                    <span class="coach-stat__label">公式戦入賞者</span>
                </div>
            </div>
        </div>
    </section>

    <section class="coach-list" id="coaches">
        <div class="coach-container">
            <div class="coach-section__header">
                <span class="coach-section__label">Coach Lineup</span>
                <h2 class="coach-section__title">専門分野ごとのエキスパート</h2>
                <p class="coach-section__description">
                    技術・体力・メンタル・戦術。それぞれの分野に強みを持つコーチがチームとなり、あなたの成長を多角的に支えます。
                </p>
            </div>

            <?php foreach ($coaches as $index => $coach) : ?>
                <?php $is_reversed = $index % 2 === 1; ?>
                <article class="coach-card <?php echo $is_reversed ? 'is-reversed' : ''; ?>">
                    <div class="coach-card__media">
                        <div class="coach-card__photo" style="background-image: url('<?php echo esc_url($coach['image']); ?>');"></div>
                    </div>
                    <div class="coach-card__content">
                        <span class="coach-card__role"><?php echo esc_html($coach['title']); ?></span>
                        <h3 class="coach-card__name">
                            <?php echo esc_html($coach['name']); ?>
                            <small><?php echo esc_html($coach['name_en']); ?></small>
                        </h3>
                        <?php if (!empty($coach['badges'])) : ?>
                            <ul class="coach-card__badges">
                                <?php foreach ($coach['badges'] as $badge) : ?>
                                    <li><?php echo esc_html($badge); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <p class="coach-card__description"><?php echo esc_html($coach['description']); ?></p>
                        <?php if (!empty($coach['quote'])) : ?>
                            <blockquote class="coach-card__quote">
                                <span class="coach-card__quote-text"><?php echo esc_html($coach['quote']); ?></span>
                            </blockquote>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="coach-flow" id="lesson-flow">
        <div class="coach-container">
            <div class="coach-section__header">
                <span class="coach-section__label">Lesson Flow</span>
                <h2 class="coach-section__title">一人ひとりに寄り添うレッスンプロセス</h2>
            </div>
            <div class="coach-flow__grid">
                <?php foreach ($flow_steps as $index => $step) : ?>
                    <div class="coach-flow__step">
                        <span class="coach-flow__number">0<?php echo esc_html($index + 1); ?></span>
                        <h3 class="coach-flow__title"><?php echo esc_html($step['title']); ?></h3>
                        <p class="coach-flow__description"><?php echo esc_html($step['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    

    <section class="coach-cta">
        <div class="coach-container coach-cta__inner">
            <div class="coach-cta__text">
                <h2>まずは体験レッスンで実感してください</h2>
                <p>
                    レベルや目標に合わせた最適なクラスをご提案します。<br>
                    ご希望の日時やお悩みもお気軽にご相談ください。
                </p>
            </div>
            <div class="coach-cta__actions">
                <a class="coach-cta__button" href="<?php echo esc_url(home_url('/contact')); ?>">体験レッスンを申し込む</a>
                <a class="coach-cta__link" href="tel:0337759711">お電話で相談する</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
