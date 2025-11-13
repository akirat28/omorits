<?php
/**
 * 大森テニスクラブ テーマ functions and definitions
 */

// テーマサポート
function omori_tennis_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');

    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');

    // HTML5サポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // メニューの登録
    register_nav_menus(array(
        'primary' => 'プライマリーメニュー',
        'footer' => 'フッターメニュー',
        'sidebar' => 'サイドメニュー',
    ));
}
add_action('after_setup_theme', 'omori_tennis_setup');

// スタイルとスクリプトの読み込み
function omori_tennis_scripts() {
    wp_enqueue_style('omori-tennis-style', get_stylesheet_uri(), array(), '1.0');
}
add_action('wp_enqueue_scripts', 'omori_tennis_scripts');

// ウィジェットエリアの登録
function omori_tennis_widgets_init() {
    register_sidebar(array(
        'name'          => 'サイドバー',
        'id'            => 'sidebar-1',
        'description'   => 'サイドバーウィジェットエリア',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => 'フッター',
        'id'            => 'footer-1',
        'description'   => 'フッターウィジェットエリア',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'omori_tennis_widgets_init');

// 抜粋の長さを変更
function omori_tennis_excerpt_length($length) {
    return 100;
}
add_filter('excerpt_length', 'omori_tennis_excerpt_length');

// 抜粋の最後の文字を変更
function omori_tennis_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'omori_tennis_excerpt_more');

// カスタマイザー設定
function omori_tennis_customize_register($wp_customize) {
    // HEROセクション設定
    $wp_customize->add_section('hero_section', array(
        'title'       => 'トップページ HEROセクション',
        'description' => 'トップページのHEROセクションの背景画像を設定します',
        'priority'    => 30,
    ));

    // HERO背景画像の設定
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => get_template_directory_uri() . '/images/hero.jpg',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'       => 'HERO背景画像',
        'description' => '推奨サイズ: 1920x1080px以上の高解像度画像',
        'section'     => 'hero_section',
        'settings'    => 'hero_background_image',
    )));

    // オーバーレイの透明度設定
    $wp_customize->add_setting('hero_overlay_opacity', array(
        'default'           => '50',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_overlay_opacity', array(
        'type'        => 'range',
        'label'       => 'オーバーレイの透明度',
        'description' => '背景画像の暗さを調整します（0:透明 - 100:黒）',
        'section'     => 'hero_section',
        'settings'    => 'hero_overlay_opacity',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 10,
        ),
    ));

    // オーバーレイカラーの設定
    $wp_customize->add_setting('hero_overlay_type', array(
        'default'           => 'gradient',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_overlay_type', array(
        'type'    => 'select',
        'label'   => 'オーバーレイタイプ',
        'section' => 'hero_section',
        'choices' => array(
            'none'     => 'なし',
            'dark'     => '黒（シンプル）',
            'gradient' => 'グラデーション（紫系）',
            'blue'     => 'グラデーション（青系）',
        ),
    ));

    // HEROセクション下のショートコード設定
    $wp_customize->add_setting('hero_shortcode', array(
        'default'           => '[tennis_notification]',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_shortcode', array(
        'type'        => 'textarea',
        'label'       => 'HEROセクション下のショートコード',
        'description' => 'HEROセクションの直下に表示するショートコードを入力してください。例: [tennis_notification]',
        'section'     => 'hero_section',
        'settings'    => 'hero_shortcode',
    ));

    // ショートコードの表示/非表示設定
    $wp_customize->add_setting('hero_shortcode_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_shortcode_enable', array(
        'type'        => 'checkbox',
        'label'       => 'ショートコードを表示',
        'description' => 'チェックを外すと非表示になります',
        'section'     => 'hero_section',
        'settings'    => 'hero_shortcode_enable',
    ));
}
add_action('customize_register', 'omori_tennis_customize_register');

// ページタイトルでページを取得する関数（WordPress 6.2.0以降対応）
function omori_tennis_get_page_by_title($page_title) {
    $query = new WP_Query(array(
        'post_type' => 'page',
        'title' => $page_title,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ));

    if ($query->have_posts()) {
        return $query->posts[0];
    }

    return null;
}

// メインメニューのフォールバック関数（お問い合わせを除く）
function omori_tennis_main_menu($args = array()) {
    $menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'menu-list';

    echo '<ul class="' . esc_attr($menu_class) . '">';

    // スクール紹介へのリンク
    echo '<li><a href="' . esc_url(home_url('/#school-intro')) . '">スクール紹介</a></li>';

    // スクールの特徴へのリンク
    echo '<li><a href="' . esc_url(home_url('/#features')) . '">スクールの特徴</a></li>';

    // 施設案内へのリンク
    echo '<li><a href="' . esc_url(home_url('/#facilities')) . '">施設案内</a></li>';

    // クラスの種類へのリンク
    echo '<li><a href="' . esc_url(home_url('/#classes')) . '">クラスの種類</a></li>';

    // 体験レッスンへのリンク
    echo '<li><a href="' . esc_url(home_url('/#trial')) . '">体験レッスン</a></li>';

    // キャンペーンへのリンク
    echo '<li><a href="' . esc_url(home_url('/#campaign')) . '">キャンペーン</a></li>';

    // アクセスへのリンク
    echo '<li><a href="' . esc_url(home_url('/#access')) . '">アクセス</a></li>';

    echo '</ul>';
}

// サイドバー詳細ページメニューのフォールバック関数
function omori_tennis_sidebar_menu($args = array()) {
    $menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'sidebar-menu-list';

    echo '<ul class="' . esc_attr($menu_class) . '">';

    // スクール紹介ページへのリンク
    $school_page = omori_tennis_get_page_by_title('スクール紹介');
    if ($school_page) {
        echo '<li><a href="' . esc_url(get_permalink($school_page)) . '">スクール紹介</a></li>';
    }

    // コーチページへのリンク
    $coach_page = omori_tennis_get_page_by_title('コーチ');
    if ($coach_page) {
        echo '<li><a href="' . esc_url(get_permalink($coach_page)) . '">コーチ</a></li>';
    }

    // 施設ページへのリンク
    $facilities_page = omori_tennis_get_page_by_title('施設');
    if ($facilities_page) {
        echo '<li><a href="' . esc_url(get_permalink($facilities_page)) . '">施設</a></li>';
    }

    echo '</ul>';
}

// 旧フォールバックメニュー関数（互換性のため残す）
function omori_tennis_fallback_menu($args = array()) {
    omori_tennis_main_menu($args);
}

// お問い合わせフォームのAJAX処理
function omori_contact_form_handler() {
    // ノンスの検証
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'omori_contact_nonce')) {
        wp_send_json_error(array('message' => '不正なリクエストです。'));
        return;
    }

    // フォームデータの取得とサニタイズ
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $comment = isset($_POST['comment']) ? sanitize_textarea_field($_POST['comment']) : '';

    // バリデーション
    if (empty($name)) {
        wp_send_json_error(array('message' => 'お名前を入力してください。'));
        return;
    }

    if (empty($email)) {
        wp_send_json_error(array('message' => 'メールアドレスを入力してください。'));
        return;
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => '有効なメールアドレスを入力してください。'));
        return;
    }

    // 管理者メールアドレスを取得
    $admin_email = get_option('admin_email');

    // メール件名
    $subject = '【大森テニスクラブ】お問い合わせがありました';

    // メール本文
    $message = "大森テニスクラブのウェブサイトから新しいお問い合わせがありました。\n\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "お名前: {$name}\n";

    if (!empty($address)) {
        $message .= "住所: {$address}\n";
    }

    if (!empty($phone)) {
        $message .= "電話番号: {$phone}\n";
    }

    $message .= "メールアドレス: {$email}\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";

    if (!empty($comment)) {
        $message .= "【お問い合わせ内容】\n";
        $message .= $comment . "\n\n";
    }

    $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "送信日時: " . current_time('Y年m月d日 H:i:s') . "\n";

    // メールヘッダー
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // メール送信
    $sent = wp_mail($admin_email, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success(array(
            'message' => 'お問い合わせを受け付けました。ありがとうございます。2営業日以内にご返信いたします。'
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'メール送信に失敗しました。お手数ですが、お電話でお問い合わせください。'
        ));
    }
}

// AJAXアクションフックを追加（ログインユーザーと非ログインユーザーの両方）
add_action('wp_ajax_omori_contact_form', 'omori_contact_form_handler');
add_action('wp_ajax_nopriv_omori_contact_form', 'omori_contact_form_handler');
