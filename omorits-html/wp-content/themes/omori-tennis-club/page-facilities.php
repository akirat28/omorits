<?php
/**
 * Template Name: 充実した施設テンプレート
 * Description: 施設紹介ページ用テンプレート
 */

get_header();

$image_base = get_template_directory_uri() . '/images/';

$facilities = [
    [
        'name'        => 'メインコート 3面',
        'name_en'     => 'Main Courts',
        'title'       => '砂入り人工芝コート（ナイター照明完備）',
        'features'      => [
            '最新式の砂入り人工芝コート',
            '照明設備完備',
        ],
        'description' => '開放的な空間でプレーできる屋外コート。自然光の中、テニスを楽しむ最高の環境です。',
        'quote'       => '「最高の環境で、最高のパフォーマンスを。」',
        'image'       => $image_base . 'maincoat.jpg',
    ],
    [
        'name'        => 'サブコート 6面',
        'name_en'     => 'Sub Courts',
        'title'       => '砂入り人工芝コート（ナイター照明完備）',
        'features'      => [
           '最新式の砂入り人工芝コート',
            '照明設備完備',
        ],
        'description' => '開放的な空間でプレーできる屋外コート。スクール２～４面使用',
        'quote'       => '「自然の中で、テニスを楽しむ。」',
        'image'       => $image_base . 'subcoat.jpg',
    ],
    [
        'name'        => 'クラブハウス',
        'name_en'     => 'Clubhouse',
        'title'       => '休憩・交流スペース',
        'features'      => [
            'ロッカールーム',
            'シャワールーム',
            'ラウンジスペース',
            'ドリンクバー'
        ],
        'description' => 'プレーの前後にリラックスできる空間。メンバー同士の交流も生まれるクラブハウスです。',
        'quote'       => '「リラックスして、次のプレーに。」',
        'image'       => $image_base . 'clubhouse.jpg',
    ],
    [
        'name'        => 'ラウンジ',
        'name_en'     => 'Lounge',
        'title'       => 'ラウンジ',
        'features'      => [
            '最新のトレーニング機器',
            'ストレッチエリア',
            'シャワールーム完備',
            '24時間利用可能'
        ],
        'description' => 'テニスパフォーマンス向上のための専門トレーニング機器を完備。体作りからケアまで幅広くサポートします。',
        'quote'       => '「強い身体が、強いプレーを生む。」',
        'image'       => $image_base . 'lounge.jpg',
    ],
];

$amenities = [
    [
        'title'       => '駐車場',
        'description' => '専用駐車場20台完備。会員様は無料でご利用いただけます。'
    ],
    [
        'title'       => 'レンタル用品',
        'description' => 'ラケット、ウェア、シューズなど、必要な用品をレンタル可能。'
    ],
    [
        'title'       => 'プロショップ',
        'description' => '最新のテニス用品や、クラブオリジナルグッズを販売。'
    ],
    [
        'title'       => 'Wi-Fi環境',
        'description' => 'クラブハウス全域で無料Wi-Fiをご利用いただけます。'
    ],
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
    <section class="coach-hero" style="background-image: url('<?php echo esc_url($image_base . 'kv01.jpg'); ?>');">
        <div class="coach-hero__overlay"></div>
        <div class="coach-container coach-hero__content">
            <span class="coach-hero__label">FACILITIES</span>
            <h1 class="coach-hero__title"><?php echo esc_html(get_the_title()); ?></h1>
            <p class="coach-hero__subtitle">
                最新の設備と快適な環境が、あなたのテニスライフをサポートします。
                プレースタイルに合わせた最適な施設で、理想のパフォーマンスを発揮してください。
            </p>
            <div class="coach-hero__actions">
                <a class="coach-hero__button" href="/#contact">体験レッスンを申し込む</a>
            </div>
        </div>
    </section>

    
    <section class="coach-coaches">
        <div class="coach-container">
            <div class="coach-section__header">
                <span class="coach-section__label">Our Facilities</span>
                <h2 class="coach-section__title">施設紹介</h2>
            </div>
            <div class="coach-coaches__grid">
                <?php foreach ($facilities as $index => $facility) : ?>
                    <div class="coach-card <?php echo $index % 2 === 1 ? 'is-reversed' : ''; ?>">
                        <div class="coach-card__photo" style="background-image: url('<?php echo esc_url($facility['image']); ?>');"></div>
                        <div class="coach-card__content">
                            <div class="coach-card__role"><?php echo esc_html($facility['name_en']); ?></div>
                            <h3 class="coach-card__name"><?php echo esc_html($facility['name']); ?></h3>
                            <p class="coach-card__title"><?php echo esc_html($facility['title']); ?></p>
                            
                            <?php if (!empty($facility['features'])) : ?>
                                <div class="coach-card__badges">
                                    <?php foreach ($facility['features'] as $feature) : ?>
                                        <span class="coach-card__badge"><?php echo esc_html($feature); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <p class="coach-card__description"><?php echo esc_html($facility['description']); ?></p>
                            <blockquote class="coach-card__quote"><?php echo esc_html($facility['quote']); ?></blockquote>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="coach-flow">
        <div class="coach-container">
            <div class="coach-section__header">
                <span class="coach-section__label">Amenities</span>
                <h2 class="coach-section__title">充実の付帯設備</h2>
            </div>
            <div class="coach-flow__grid">
                <?php foreach ($amenities as $index => $amenity) : ?>
                    <div class="coach-flow__step">
                        <span class="coach-flow__number">0<?php echo esc_html($index + 1); ?></span>
                        <h3 class="coach-flow__title"><?php echo esc_html($amenity['title']); ?></h3>
                        <p class="coach-flow__description"><?php echo esc_html($amenity['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="coach-cta">
        <div class="coach-container coach-cta__inner">
            <div class="coach-cta__text">
                <h2>体験レッスンで<br>　実感してください</h2>
                <p>
                    実際に施設を見て、雰囲気を感じてください。<br>
                    ご希望の日時やご質問もお気軽にご相談ください。
                </p>
            </div>
            <div class="coach-cta__actions">
                <a class="coach-cta__button" href="/#contact">入会＆体験レッスンの申込</a>
                <a class="coach-cta__link" href="tel:0337759711">お電話で相談する</a>
            </div>
        </div>
    </section>
</div>
    </div>
</main>

<?php get_footer(); ?>
