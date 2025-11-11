<?php
/**
 * アーカイブページ用テンプレート
 * カテゴリー、タグ、日付アーカイブなどで使用
 */

get_header();
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
                            <li class="<?php echo (is_category($category->term_id)) ? 'current-category' : ''; ?>">
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="count">(<?php echo $category->count; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- 月別アーカイブ -->
                <div class="side-widget">
                    <h3 class="side-widget-title">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <rect x="3" y="4" width="14" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M3 8h14M7 3v2M13 3v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        月別アーカイブ
                    </h3>
                    <ul class="archive-list">
                        <?php wp_get_archives(array(
                            'type' => 'monthly',
                            'limit' => 12,
                            'format' => 'custom',
                            'before' => '<li>',
                            'after' => '</li>',
                            'show_post_count' => true,
                        )); ?>
                    </ul>
                </div>

                <!-- タグクラウド -->
                <?php
                $tags = get_tags();
                if ($tags) :
                ?>
                <div class="side-widget">
                    <h3 class="side-widget-title">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 3L3 10v7h7l7-7-7-7zM7 8a1 1 0 100-2 1 1 0 000 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        タグ
                    </h3>
                    <div class="tag-cloud">
                        <?php wp_tag_cloud(array(
                            'smallest' => 0.8,
                            'largest' => 1.2,
                            'unit' => 'rem',
                            'number' => 20,
                            'format' => 'flat',
                            'orderby' => 'count',
                            'order' => 'DESC',
                        )); ?>
                    </div>
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
            <!-- アーカイブヘッダー -->
            <header class="archive-header">
                <h1 class="archive-title">
                    <?php
                    if (is_category()) {
                        echo 'カテゴリー: ' . single_cat_title('', false);
                    } elseif (is_tag()) {
                        echo 'タグ: ' . single_tag_title('', false);
                    } elseif (is_author()) {
                        echo '著者: ' . get_the_author();
                    } elseif (is_date()) {
                        if (is_day()) {
                            echo get_the_date('Y年n月j日');
                        } elseif (is_month()) {
                            echo get_the_date('Y年n月');
                        } elseif (is_year()) {
                            echo get_the_date('Y年');
                        }
                    } else {
                        echo 'アーカイブ';
                    }
                    ?>
                </h1>

                <?php
                // アーカイブの説明文がある場合は表示
                $description = get_the_archive_description();
                if ($description) :
                ?>
                    <div class="archive-description">
                        <?php echo $description; ?>
                    </div>
                <?php endif; ?>

                <div class="archive-count">
                    全<?php echo $wp_query->found_posts; ?>件の投稿
                </div>
            </header>

            <!-- 記事リスト -->
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-card-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', array('class' => 'post-image')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-card-content">
                                <div class="post-card-meta">
                                    <time class="post-card-date" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                    <?php
                                    $post_categories = get_the_category();
                                    if ($post_categories) :
                                    ?>
                                        <span class="post-card-categories">
                                            <?php foreach ($post_categories as $cat) : ?>
                                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="category-link">
                                                    <?php echo esc_html($cat->name); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h2 class="post-card-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="post-card-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="post-card-link">
                                    続きを読む →
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- ページネーション -->
                <nav class="pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '← 前へ',
                        'next_text' => '次へ →',
                        'type' => 'list',
                    ));
                    ?>
                </nav>

            <?php else : ?>
                <!-- 記事がない場合 -->
                <div class="no-posts">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" class="no-posts-icon">
                        <circle cx="40" cy="40" r="38" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                        <path d="M30 30h20v20H30z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M25 50l30-30M25 20l30 30" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
                    </svg>
                    <h2>記事が見つかりませんでした</h2>
                    <p>お探しの記事は見つかりませんでした。<br>他の条件で検索してみてください。</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        ホームへ戻る
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>