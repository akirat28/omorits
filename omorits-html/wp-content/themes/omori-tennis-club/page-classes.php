<?php
/**
 * Template Name: クラステンプレート
 * Description: クラス紹介ページ用テンプレート
 */

get_header();

$image_base = get_template_directory_uri() . '/images/';

$adult_classes = [
    [
        'name'        => '一般',
        'level'       => '初級',
        'target'      => '初心者の方。数回程度経験のある方。',
        'description' => '各ショットの基本を覚えていただきます。',
        'features'    => [
            'グリップの握り方',
            '基本スイングの習得',
            'フォアハンド・バックハンド',
            'サーブとレシーブの基本',
            'ボールコントロール'
        ],
        'schedule'    => '月曜・水曜・金曜 10:00-12:00',
        'image'       => $image_base . 'ippan.jpg',
        'color'       => '#4CAF50'
    ],
    [
        'name'        => '一般',
        'level'       => '初中級',
        'target'      => '各ショットを理解しており、ラリーの繋げる方。',
        'description' => '各ショットの安定と雁行陣の動きを身につけていただきます。',
        'features'    => [
            '安定したラリーの構築',
            '雁行陣の基本動作',
            'ボレーの技術向上',
            'スマッシュの習得',
            'ゲーム戦術の基礎'
        ],
        'schedule'    => '火曜・木曜・土曜 10:00-12:00',
        'image'       => $image_base . 'ippan.jpg',
        'color'       => '#2196F3'
    ],
    [
        'name'        => '一般',
        'level'       => '中級',
        'target'      => '雁行陣を理解し、各ショットにある程度安定感のある方。',
        'description' => '並行陣の動きを覚えていただきます。',
        'features'    => [
            '並行陣の基本動作',
            'ネットプレーの強化',
            'スライスとトップスピン',
            '戦術的ラリー',
            'ダブルス戦術'
        ],
        'schedule'    => '月曜・木曜・日曜 14:00-16:00',
        'image'       => $image_base . 'ippan.jpg',
        'color'       => '#FF9800'
    ],
    [
        'name'        => '一般',
        'level'       => '中上級',
        'target'      => 'ある程度、ボールのスピードに対応ができ、安定している方。',
        'description' => '並行陣の動き、ゲームの組み立てを目指します。',
        'features'    => [
            '高速ボールへの対応',
            '高度なネットプレー',
            'ゲームメイク能力',
            'メンタルトレーニング',
            'トーナメント戦略'
        ],
        'schedule'    => '火曜・金曜 19:00-21:00',
        'image'       => $image_base . 'ippan.jpg',
        'color'       => '#9C27B0'
    ],
    [
        'name'        => '一般',
        'level'       => '上級',
        'target'      => '各ショットに安定感があり、ボールのスピードコントロールができる方。',
        'description' => 'より高度なゲームを目指します。',
        'features'    => [
            'プロレベルの技術',
            '高度な戦術理解',
            'コンディショニング',
            'ビデオ分析',
            '個別指導'
        ],
        'schedule'    => '水曜・土曜 19:00-21:00',
        'image'       => $image_base . 'ippan.jpg',
        'color'       => '#F44336'
    ]
];

$junior_classes = [
    [
        'name'        => 'ジュニア',
        'level'       => 'J1',
        'target'      => '小学校1年生から6年生の初心者',
        'description' => '楽しくテニスの基本を学びます。',
        'features'    => [
            'ボールに慣れる',
            '基本的な動き',
            'ラケット操作',
            'ゲーム感覚の練習',
            '体力づくり'
        ],
        'schedule'    => '月曜・水曜・金曜 16:00-17:30',
        'image'       => $image_base . 'Junior.jpg',
        'color'       => '#00BCD4',
        'test'        => false
    ],
    [
        'name'        => 'ジュニア',
        'level'       => 'J2',
        'target'      => '小学校1年生から6年生の初級者',
        'description' => '基本技術の定着を目指します。',
        'features'    => [
            'ショットの基本',
            'ラリー練習',
            'ルールの理解',
            '協調性の育成',
            '体力向上'
        ],
        'schedule'    => '火曜・木曜 16:00-17:30',
        'image'       => $image_base . 'Junior.jpg',
        'color'       => '#009688',
        'test'        => true
    ],
    [
        'name'        => 'ジュニア',
        'level'       => 'J3',
        'target'      => '小学校1年生から6年生の初中級者',
        'description' => '実践的な技術を習得します。',
        'features'    => [
            '応用技術',
            'ゲーム戦術',
            'メンタルトレーニング',
            'チームワーク',
            'コンディショニング'
        ],
        'schedule'    => '月曜・木曜 16:00-17:30',
        'image'       => $image_base . 'Junior.jpg',
        'color'       => '#4CAF50',
        'test'        => true
    ],
    [
        'name'        => 'ジュニア',
        'level'       => 'J4',
        'target'      => '中・高校生までの初級者',
        'description' => '年齢に合わせた指導を行います。',
        'features'    => [
            '年齢適正技術',
            '体力作り',
            '戦術理解',
            'コミュニケーション',
            '目標設定'
        ],
        'schedule'    => '水曜・金曜 17:00-18:30',
        'image'       => $image_base . 'Junior.jpg',
        'color'       => '#FF9800',
        'test'        => false
    ],
    [
        'name'        => 'ジュニア',
        'level'       => 'J5',
        'target'      => '中・高校生までの中級者',
        'description' => '上級者へのステップアップを目指します。',
        'features'    => [
            '高度な技術',
            '戦術的思考',
            '体力強化',
            'リーダーシップ',
            '目標達成'
        ],
        'schedule'    => '火曜・金曜 17:00-18:30',
        'image'       => $image_base . 'Junior.jpg',
        'color'       => '#FF5722',
        'test'        => true
    ],
    [
        'name'        => 'ジュニア',
        'level'       => '選抜Jr',
        'target'      => '中・高校生までの上級者',
        'description' => '定員1面6人までの選抜クラスです。',
        'features'    => [
            '選抜レベル指導',
            '大会対策',
            '専門トレーニング',
            '個別分析',
            '目標達成支援'
        ],
        'schedule'    => '土曜・日曜 10:00-12:00',
        'image'       => $image_base . 'Junior.jpg',
        'color'       => '#E91E63',
        'test'        => true
    ]
];

$benefits = [
    [
        'icon' => '🎯',
        'title' => 'レベル別指導',
        'description' => '一人ひとりのレベルに合わせた最適な指導プログラム'
    ],
    [
        'icon' => '👥',
        'title' => '少人数制',
        'description' => '1コート最大8名までの少人数で丁寧な指導'
    ],
    [
        'icon' => '🏆',
        'title' => '経験豊富なコーチ',
        'description' => 'プロ経験者も含む専門コーチ陣による指導'
    ],
    [
        'icon' => '📈',
        'title' => '段階的アップ',
        'description' => '確実なステップアップを目指すカリキュラム'
    ]
];
?>

<main class="site-main with-sidebar">
    <div class="page-container">
        <!-- 左側：ナビゲーションメニュー -->
        <aside class="sidebar-navigation">
            <div class="sidebar-inner">
                <!-- サイト内ナビゲーション -->
                <nav class="side-nav">
                    <h3 class="side-nav-title">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M4 6h12M4 10h12M4 14h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        ページ一覧
                    </h3>
                    <?php
                    // サイドメニューを表示
                    wp_nav_menu(array(
                        'theme_location' => 'sidebar',
                        'menu_class'     => 'side-menu',
                        'container'      => false,
                        'fallback_cb'    => 'omori_tennis_fallback_menu',
                        'depth'          => 2,
                    ));
                    ?>
                </nav>

                <!-- カテゴリー -->
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'hide_empty' => true,
                ));

                if (!empty($categories)) :
                ?>
                <div class="side-widget">
                    <h3 class="side-widget-title">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M3 7h14l-1 9H4L3 7zM3 7l1-3h12l1 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        カテゴリー
                    </h3>
                    <ul class="category-list">
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="count">(<?php echo $category->count; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- お問い合わせボタン -->
                <div class="side-cta">
                    <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-primary btn-block">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M3 5h14l-7 5-7-5zM3 5v10h14V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        お問い合わせ
                    </a>
                    <a href="tel:03-1234-5678" class="btn btn-outline btn-block">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M5 3h3l1 3-1.5 1.5c1 2 3 4 5 5L14 11l3 1v3a2 2 0 01-2 2C8 17 3 12 3 5a2 2 0 012-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        03-1234-5678
                    </a>
                </div>
            </div>
        </aside>

        <!-- 右側：メインコンテンツ -->
        <div class="content-area">
    <section class="class-hero" style="background-image: url('<?php echo esc_url($image_base . 'kv01.jpg'); ?>');">
        <div class="class-hero__overlay"></div>
        <div class="coach-container class-hero__content">
            <span class="class-hero__label">CLASSES</span>
            <h1 class="class-hero__title"><?php echo esc_html(get_the_title()); ?></h1>
            <p class="class-hero__subtitle">
                レベルに合わせた最適なクラスで、理想のテニスライフを実現。
                初心者から上級者まで、一人ひとりに寄り添った指導を提供します。
            </p>
            <div class="class-hero__actions">
                <a class="class-hero__button" href="/#contact">入会＆体験レッスンの申込</a>
            </div>
        </div>
    </section>

    <!-- メリットセクション -->
    <section class="class-benefits">
        <div class="coach-container">
            <div class="class-benefits__grid">
                <?php foreach ($benefits as $benefit) : ?>
                    <div class="benefit-card">
                        <div class="benefit-card__icon"><?php echo esc_html($benefit['icon']); ?></div>
                        <h3 class="benefit-card__title"><?php echo esc_html($benefit['title']); ?></h3>
                        <p class="benefit-card__description"><?php echo esc_html($benefit['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 一般クラス -->
    <section class="class-section">
        <div class="coach-container">
            <div class="class-section__header">
                <span class="class-section__label">Adult Classes</span>
                <h2 class="class-section__title">一般クラス</h2>
                <p class="class-section__description">大人のテニスを楽しむためのレベル別クラス</p>
            </div>
            <div class="class-grid">
                <?php foreach ($adult_classes as $index => $class) : ?>
                    <div class="class-card" style="--accent-color: <?php echo esc_attr($class['color']); ?>;">
                        <div class="class-card__header">
                            <div class="class-card__image" style="background-image: url('<?php echo esc_url($class['image']); ?>');"></div>
                            <div class="class-card__level">
                                <span class="class-card__category"><?php echo esc_html($class['name']); ?></span>
                                <span class="class-card__level-name"><?php echo esc_html($class['level']); ?></span>
                            </div>
                        </div>
                        <div class="class-card__content">
                            <div class="class-card__target">
                                <h4 class="class-card__target-title">対象者</h4>
                                <p class="class-card__target-text"><?php echo esc_html($class['target']); ?></p>
                            </div>
                            <div class="class-card__description">
                                <p><?php echo esc_html($class['description']); ?></p>
                            </div>
                            <div class="class-card__features">
                                <h4 class="class-card__features-title">学習内容</h4>
                                <ul class="class-card__features-list">
                                    <?php foreach ($class['features'] as $feature) : ?>
                                        <li><?php echo esc_html($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="class-card__schedule">
                                <div class="class-card__schedule-info">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 0v6l3 3M8 14A6 6 0 108 2a6 6 0 000 12z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span><?php echo esc_html($class['schedule']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ジュニアクラス -->
    <section class="class-section class-section--alternate">
        <div class="coach-container">
            <div class="class-section__header">
                <span class="class-section__label">Junior Classes</span>
                <h2 class="class-section__title">ジュニアクラス</h2>
                <p class="class-section__description">未来のテニスプレーヤーを育成するジュニア専門クラス</p>
            </div>
            <div class="class-grid">
                <?php foreach ($junior_classes as $index => $class) : ?>
                    <div class="class-card class-card--junior" style="--accent-color: <?php echo esc_attr($class['color']); ?>;">
                        <div class="class-card__header">
                            <div class="class-card__image" style="background-image: url('<?php echo esc_url($class['image']); ?>');"></div>
                            <div class="class-card__level">
                                <span class="class-card__category"><?php echo esc_html($class['name']); ?></span>
                                <span class="class-card__level-name">
                                    <?php echo esc_html($class['level']); ?>
                                    <?php if ($class['test']) : ?>
                                        <span class="class-card__test-badge">※見極めテストあり</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="class-card__content">
                            <div class="class-card__target">
                                <h4 class="class-card__target-title">対象者</h4>
                                <p class="class-card__target-text"><?php echo esc_html($class['target']); ?></p>
                            </div>
                            <div class="class-card__description">
                                <p><?php echo esc_html($class['description']); ?></p>
                            </div>
                            <div class="class-card__features">
                                <h4 class="class-card__features-title">学習内容</h4>
                                <ul class="class-card__features-list">
                                    <?php foreach ($class['features'] as $feature) : ?>
                                        <li><?php echo esc_html($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="class-card__schedule">
                                <div class="class-card__schedule-info">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 0v6l3 3M8 14A6 6 0 108 2a6 6 0 000 12z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span><?php echo esc_html($class['schedule']); ?></span>
                                </div>
                                <?php if ($class['level'] === '選抜Jr') : ?>
                                    <div class="class-card__capacity">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M8 8a3 3 0 100-6 3 3 0 000 6zM12 12H4a1 1 0 00-1 1v2h10v-2a1 1 0 00-1-1z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>定員1面6人まで</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTAセクション -->
    <section class="class-cta">
        <div class="coach-container class-cta__inner">
            <div class="class-cta__content">
                <h2 class="class-cta__title">どのクラスから始めるか迷ったら</h2>
                <p class="class-cta__description">
                    現在のレベルや目標に合わせて、最適なクラスをご提案します。<br>
                    無料の体験レッスンも実施しておりますので、お気軽にご相談ください。
                </p>
                <div class="class-cta__actions">
                    <a class="class-cta__button" href="/#contact">入会＆体験レッスンの申込</a>
                    <a class="class-cta__link" href="tel:0337759711">お電話で相談する</a>
                </div>
            </div>
        </div>
    </section>
</div>
    </div>
</main>

<?php get_footer(); ?>
