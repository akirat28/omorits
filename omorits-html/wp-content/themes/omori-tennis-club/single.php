<?php
/**
 * 投稿（ブログ記事）用テンプレート
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
                            <li class="<?php echo (in_category($category->term_id)) ? 'current-category' : ''; ?>">
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="count">(<?php echo $category->count; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- タグ -->
                <?php
                $tags = get_the_tags();
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
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag">
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
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
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <!-- 記事ヘッダー -->
                    <header class="post-header">
                        <div class="post-meta">
                            <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                            <?php
                            $post_categories = get_the_category();
                            if ($post_categories) :
                            ?>
                                <span class="post-categories">
                                    <?php foreach ($post_categories as $cat) : ?>
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="category-badge">
                                            <?php echo esc_html($cat->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <h1 class="post-title"><?php the_title(); ?></h1>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <!-- 記事本文 -->
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- 記事フッター -->
                    <footer class="post-footer">
                        <?php
                        $post_tags = get_the_tags();
                        if ($post_tags) :
                        ?>
                            <div class="post-tags">
                                <span class="tags-label">タグ:</span>
                                <?php foreach ($post_tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag">
                                        #<?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- ナビゲーション -->
                        <nav class="post-navigation">
                            <div class="nav-previous">
                                <?php previous_post_link('%link', '← %title'); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_post_link('%link', '%title →'); ?>
                            </div>
                        </nav>
                    </footer>
                </article>

                <!-- コメント -->
                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="comments-area">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>