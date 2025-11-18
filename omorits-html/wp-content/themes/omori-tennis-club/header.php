<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/header-logo.png'); ?>"
                     alt="<?php bloginfo('name'); ?>"
                     class="header-logo">
            </a>
        </div>

        <!-- デスクトップナビゲーション -->
        <nav class="desktop-navigation">
            <!-- プルダウンメニュー -->
            <div class="dropdown-wrapper">
                <button class="dropdown-toggle" aria-label="メニュー" aria-expanded="false">
                    <span>メニュー</span>
                    <svg class="dropdown-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="dropdown-menu">
                    <!-- TOPページメニュー -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'dropdown-menu-list',
                        'container'      => false,
                        'fallback_cb'    => 'omori_tennis_main_menu',
                    ));
                    ?>

                    <!-- 区切り線 -->
                    <div class="dropdown-divider"></div>

                    <!-- 会員メニュー -->
                    <div class="dropdown-section-title">会員メニュー</div>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'sidebar',
                        'menu_class'     => 'dropdown-menu-list dropdown-submenu',
                        'container'      => false,
                        'fallback_cb'    => 'omori_tennis_sidebar_menu',
                    ));
                    ?>
                </div>
            </div>

            <!-- お問い合わせボタン -->
            <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="contact-button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                </svg>
                <span>お問い合わせ</span>
            </a>
        </nav>

        <!-- モバイルメニューボタン -->
        <button class="mobile-menu-toggle" aria-label="メニュー">
            <span class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>

        <!-- モバイルナビゲーション -->
        <nav class="mobile-navigation">
            <!-- TOPページメニュー -->
            <div class="mobile-menu-section">
                <h3 class="mobile-menu-title">メニュー</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'mobile-menu-list',
                    'container'      => false,
                    'fallback_cb'    => 'omori_tennis_main_menu',
                ));
                ?>
            </div>

            <!-- 会員メニュー -->
            <div class="mobile-menu-section">
                <h3 class="mobile-menu-title">会員メニュー</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'sidebar',
                    'menu_class'     => 'mobile-menu-list',
                    'container'      => false,
                    'fallback_cb'    => 'omori_tennis_sidebar_menu',
                ));
                ?>
            </div>

            <!-- お問い合わせボタン -->
            <div class="mobile-contact-section">
                <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="mobile-contact-button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                    </svg>
                    <span>お問い合わせ</span>
                </a>
            </div>
        </nav>
    </div>
</header>

<!-- メニュー用スクリプト -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // デスクトップドロップダウンメニュー
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const dropdownWrapper = document.querySelector('.dropdown-wrapper');

    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isExpanded = dropdownToggle.getAttribute('aria-expanded') === 'true';
            dropdownToggle.setAttribute('aria-expanded', !isExpanded);
            dropdownWrapper.classList.toggle('is-open');
        });

        // ドロップダウン外クリックで閉じる
        document.addEventListener('click', function(e) {
            if (!dropdownWrapper.contains(e.target)) {
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdownWrapper.classList.remove('is-open');
            }
        });

        // メニューアイテムクリック時にドロップダウンを閉じる
        const dropdownLinks = dropdownMenu.querySelectorAll('a');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', function() {
                dropdownToggle.setAttribute('aria-expanded', 'false');
                dropdownWrapper.classList.remove('is-open');
            });
        });
    }

    // モバイルメニュー
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNavigation = document.querySelector('.mobile-navigation');
    const body = document.body;

    if (menuToggle && mobileNavigation) {
        menuToggle.addEventListener('click', function() {
            mobileNavigation.classList.toggle('is-active');
            menuToggle.classList.toggle('is-active');
            body.classList.toggle('menu-open');
        });

        // メニュー外クリックで閉じる（リンククリックは除外）
        document.addEventListener('click', function(e) {
            // リンクをクリックした場合は何もしない
            const clickedLink = e.target.closest('a');
            if (clickedLink && mobileNavigation.contains(clickedLink)) {
                return;
            }

            if (!mobileNavigation.contains(e.target) && !menuToggle.contains(e.target)) {
                mobileNavigation.classList.remove('is-active');
                menuToggle.classList.remove('is-active');
                body.classList.remove('menu-open');
            }
        });
    }

    // スムーススクロール関数
    function smoothScrollToElement(targetId) {
        const targetElement = document.getElementById(targetId);
        if (!targetElement) return false;

        // モバイルメニューを閉じる
        if (mobileNavigation) {
            mobileNavigation.classList.remove('is-active');
        }
        if (menuToggle) {
            menuToggle.classList.remove('is-active');
        }
        body.classList.remove('menu-open');

        // デスクトップドロップダウンを閉じる
        if (dropdownToggle) {
            dropdownToggle.setAttribute('aria-expanded', 'false');
        }
        if (dropdownWrapper) {
            dropdownWrapper.classList.remove('is-open');
        }

        // ヘッダーの高さを取得
        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 0;

        // スムーススクロール（ヘッダー分のオフセットを考慮）
        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;

        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });

        return true;
    }

    // ページ内アンカーリンクのクリックイベント
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // 完全なURLの場合（例: http://example.com/#features）
            if (href.includes('/#')) {
                const hashIndex = href.indexOf('#');
                const targetId = href.substring(hashIndex + 1);

                if (targetId) {
                    // 現在のページにターゲット要素がある場合はスムーススクロール
                    if (document.getElementById(targetId)) {
                        e.preventDefault();
                        smoothScrollToElement(targetId);
                    }
                    // ターゲット要素がない場合（別ページの場合）は通常のリンク遷移を許可
                    // デフォルト動作でHOMEページに遷移し、そこでハッシュが処理される
                }
            }
            // 相対URLの場合（例: #features）
            else if (href.startsWith('#')) {
                const targetId = href.substring(1);

                if (targetId && targetId !== '' && document.getElementById(targetId)) {
                    e.preventDefault();
                    smoothScrollToElement(targetId);
                }
            }
        });
    });

    // ページ読み込み時にURLにハッシュがある場合
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);

        // 少し遅延させてからスクロール（ページの読み込みを待つ）
        setTimeout(function() {
            smoothScrollToElement(targetId);
        }, 100);
    }
});

</script>
