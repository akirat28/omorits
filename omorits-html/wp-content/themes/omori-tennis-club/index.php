<?php
/**
 * メインテンプレートファイル
 * 他の特定のテンプレートが存在しない場合のフォールバック
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
            <?php if (have_posts()) : ?>

                <?php if (is_home() || is_archive()) : ?>
                    <!-- 複数記事の表示（ブログホームやアーカイブ） -->
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
                    <!-- 単一記事やページの表示 -->
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                            <header class="page-header">
                                <h1 class="page-title"><?php the_title(); ?></h1>
                                <?php if (is_single()) : ?>
                                    <div class="post-meta">
                                        <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>
                                <?php endif; ?>
                            </header>

                            <div class="page-body">
                                <?php the_content(); ?>
                            </div>

                            <?php if (is_single()) : ?>
                                <footer class="post-footer">
                                    <nav class="post-navigation">
                                        <div class="nav-previous">
                                            <?php previous_post_link('%link', '← %title'); ?>
                                        </div>
                                        <div class="nav-next">
                                            <?php next_post_link('%link', '%title →'); ?>
                                        </div>
                                    </nav>
                                </footer>
                            <?php endif; ?>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>

            <?php else : ?>
                <!-- コンテンツがない場合 -->
                <div class="no-posts">
                    <h2>コンテンツが見つかりませんでした</h2>
                    <p>お探しのコンテンツは見つかりませんでした。</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        ホームへ戻る
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
