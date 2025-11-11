<?php
/**
 * Plugin Name: テニススクール開催連絡
 * Plugin URI: https://omori-tennis.club
 * Description: テニススクールの開催・中止情報を管理・表示するプラグイン
 * Version: 1.0.0
 * Author: 大森テニスクラブ
 * Author URI: https://omori-tennis.club
 * License: GPL v2 or later
 * Text Domain: tennis-school-notification
 */

// 直接アクセス防止
if (!defined('ABSPATH')) {
    exit;
}

// プラグイン定数定義
define('TSN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TSN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TSN_PLUGIN_VERSION', '1.0.0');

// 必要なファイルを読み込み
require_once TSN_PLUGIN_DIR . 'includes/class-database.php';
require_once TSN_PLUGIN_DIR . 'includes/class-admin.php';
require_once TSN_PLUGIN_DIR . 'includes/class-shortcode.php';

// プラグイン有効化時の処理
register_activation_hook(__FILE__, 'tsn_activate_plugin');
function tsn_activate_plugin() {
    // データベーステーブルの作成
    TSN_Database::create_table();

    // デフォルト設定の保存
    add_option('tsn_settings', array(
        'default_color' => 'green',
        'display_days' => 7  // 表示する日数
    ));

    flush_rewrite_rules();
}

// プラグイン無効化時の処理
register_deactivation_hook(__FILE__, 'tsn_deactivate_plugin');
function tsn_deactivate_plugin() {
    flush_rewrite_rules();
}

// プラグインアンインストール時の処理
register_uninstall_hook(__FILE__, 'tsn_uninstall_plugin');
function tsn_uninstall_plugin() {
    // データベーステーブルの削除（オプション）
    // TSN_Database::drop_table();

    // オプションの削除
    delete_option('tsn_settings');
}

// プラグインの初期化
add_action('init', 'tsn_init');
function tsn_init() {
    // テキストドメインの読み込み
    load_plugin_textdomain('tennis-school-notification', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

// 管理画面の初期化
if (is_admin()) {
    new TSN_Admin();
}

// ショートコードの登録
new TSN_Shortcode();

// スタイルシートの読み込み
add_action('wp_enqueue_scripts', 'tsn_enqueue_styles');
function tsn_enqueue_styles() {
    wp_enqueue_style('tsn-frontend', TSN_PLUGIN_URL . 'assets/css/frontend.css', array(), TSN_PLUGIN_VERSION);
}

// 管理画面用のスタイル・スクリプトの読み込み
add_action('admin_enqueue_scripts', 'tsn_admin_enqueue_scripts');
function tsn_admin_enqueue_scripts($hook) {
    // 開催連絡の管理画面でのみ読み込む
    if (strpos($hook, 'tennis-notification') !== false) {
        // jQuery UI Datepickerの読み込み
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css');

        // カスタムスクリプト
        wp_enqueue_script('tsn-admin', TSN_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-datepicker'), TSN_PLUGIN_VERSION, true);
        wp_localize_script('tsn-admin', 'tsn_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tsn_ajax_nonce')
        ));

        // カスタムスタイル
        wp_enqueue_style('tsn-admin', TSN_PLUGIN_URL . 'assets/css/admin.css', array(), TSN_PLUGIN_VERSION);

        // フロントエンドスタイルも読み込み（プレビュー用）
        wp_enqueue_style('tsn-frontend', TSN_PLUGIN_URL . 'assets/css/frontend.css', array(), TSN_PLUGIN_VERSION);
    }
}

// AJAXハンドラー（削除）
add_action('wp_ajax_tsn_delete_notification', 'tsn_ajax_delete_notification');
function tsn_ajax_delete_notification() {
    // セキュリティチェック
    if (!check_ajax_referer('tsn_ajax_nonce', 'nonce', false)) {
        wp_die('Security check failed');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
    }

    $id = intval($_POST['id']);
    if (TSN_Database::delete_notification($id)) {
        wp_send_json_success();
    } else {
        wp_send_json_error('削除に失敗しました。');
    }
}

// AJAXハンドラー（取得）
add_action('wp_ajax_tsn_get_notification', 'tsn_ajax_get_notification');
function tsn_ajax_get_notification() {
    // セキュリティチェック
    if (!check_ajax_referer('tsn_ajax_nonce', 'nonce', false)) {
        wp_die('Security check failed');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
    }

    $id = intval($_POST['id']);
    $notification = TSN_Database::get_notification($id);
    if ($notification) {
        wp_send_json_success($notification);
    } else {
        wp_send_json_error('データの取得に失敗しました。');
    }
}