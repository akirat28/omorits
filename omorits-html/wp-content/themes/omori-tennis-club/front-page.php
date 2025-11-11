<?php
/**
 * フロントページテンプレート
 * WordPressの設定でフロントページに指定されたページで使用
 */

// ホームページテンプレートが設定されている場合はそちらを使用
$page_template = get_page_template_slug();

if ($page_template === 'page-home.php' || empty($page_template)) {
    // HOMEページテンプレートを読み込む
    include(get_template_directory() . '/page-home.php');
} else {
    // 通常の固定ページテンプレートを使用
    include(get_template_directory() . '/page.php');
}