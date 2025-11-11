<?php
/**
 * 管理画面クラス
 */
class TSN_Admin {

    /**
     * コンストラクタ
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_post_tsn_save_notification', array($this, 'save_notification'));
    }

    /**
     * 管理メニューの追加
     */
    public function add_admin_menu() {
        // メインメニューの追加（一覧を表示）
        add_menu_page(
            '開催連絡',                        // ページタイトル
            '開催連絡',                        // メニュータイトル
            'manage_options',                   // 必要な権限
            'tennis-notification',              // スラッグ
            array($this, 'display_list_page'),  // コールバック（一覧画面）
            'dashicons-megaphone',              // アイコン
            30                                  // 位置
        );

        // サブメニュー（一覧）- メインメニューと同じスラッグで最初に表示
        add_submenu_page(
            'tennis-notification',
            '通知一覧',
            '通知一覧',
            'manage_options',
            'tennis-notification',
            array($this, 'display_list_page')
        );

        // サブメニュー（新規追加）
        add_submenu_page(
            'tennis-notification',
            '新規追加',
            '新規追加',
            'manage_options',
            'tennis-notification-add',
            array($this, 'display_admin_page')
        );
    }

    /**
     * 管理画面（新規追加・編集）の表示
     */
    public function display_admin_page() {
        // 編集モードかチェック
        $edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
        $notification = null;

        if ($edit_id) {
            $notification = TSN_Database::get_notification($edit_id);
        }

        // メッセージ表示
        if (isset($_GET['message'])) {
            switch ($_GET['message']) {
                case 'saved':
                    echo '<div class="notice notice-success is-dismissible"><p>開催連絡を保存しました。</p></div>';
                    break;
                case 'error':
                    echo '<div class="notice notice-error is-dismissible"><p>エラーが発生しました。</p></div>';
                    break;
                case 'duplicate':
                    echo '<div class="notice notice-error is-dismissible"><p><strong>エラー：</strong>この日付の開催連絡は既に登録されています。同じ日に複数の連絡を登録することはできません。</p></div>';
                    break;
            }
        }

        // サンプルメッセージ
        $sample_messages = array(
            '本日のテニススクールは通常通り開催します。',
            '本日のテニススクールは雨のため中止とさせていただきます。',
            '本日のテニススクールは A・Bクラスは中止とさせていただきます。',
            '本日のテニススクールは強風のため中止とさせていただきます。',
            '本日のテニススクールはコート整備のため中止とさせていただきます。',
        );
        ?>
        <div class="wrap tsn-admin-wrap">
            <h1><?php echo $edit_id ? '開催連絡の編集' : '開催連絡の新規追加'; ?></h1>

            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="tsn-notification-form">
                <?php wp_nonce_field('tsn_save_notification', 'tsn_nonce'); ?>
                <input type="hidden" name="action" value="tsn_save_notification" />
                <?php if ($edit_id) : ?>
                    <input type="hidden" name="id" value="<?php echo $edit_id; ?>" />
                <?php endif; ?>

                <table class="form-table">
                    <tbody>
                        <!-- 日付選択 -->
                        <tr>
                            <th scope="row">
                                <label for="notification_date">日付 <span class="required">*</span></label>
                            </th>
                            <td>
                                <input type="text"
                                       id="notification_date"
                                       name="notification_date"
                                       class="regular-text datepicker"
                                       value="<?php echo $notification ? esc_attr($notification['notification_date']) : ''; ?>"
                                       required />
                                <p class="description">開催連絡を表示する日付を選択してください</p>
                            </td>
                        </tr>

                        <!-- 色選択 -->
                        <tr>
                            <th scope="row">
                                <label for="color">表示色 <span class="required">*</span></label>
                            </th>
                            <td>
                                <div class="tsn-color-selector">
                                    <label>
                                        <input type="radio"
                                               name="color"
                                               value="green"
                                               <?php checked($notification ? $notification['color'] : 'green', 'green'); ?> />
                                        <span class="tsn-color-badge green">緑色（通常連絡）</span>
                                    </label>
                                    <label>
                                        <input type="radio"
                                               name="color"
                                               value="yellow"
                                               <?php checked($notification ? $notification['color'] : '', 'yellow'); ?> />
                                        <span class="tsn-color-badge yellow">黄色（注意連絡）</span>
                                    </label>
                                    <label>
                                        <input type="radio"
                                               name="color"
                                               value="red"
                                               <?php checked($notification ? $notification['color'] : '', 'red'); ?> />
                                        <span class="tsn-color-badge red">赤色（中止連絡）</span>
                                    </label>
                                </div>
                            </td>
                        </tr>

                        <!-- メッセージ入力 -->
                        <tr>
                            <th scope="row">
                                <label for="message">メッセージ <span class="required">*</span></label>
                            </th>
                            <td>
                                <div class="tsn-sample-messages">
                                    <label>サンプルメッセージ：</label>
                                    <select id="sample_message_selector" class="regular-text">
                                        <option value="">-- サンプルを選択 --</option>
                                        <?php foreach ($sample_messages as $sample) : ?>
                                            <option value="<?php echo esc_attr($sample); ?>"><?php echo esc_html($sample); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <textarea id="message"
                                          name="message"
                                          rows="4"
                                          class="large-text"
                                          placeholder="例：本日のテニススクールは通常通り開催します。"
                                          required><?php echo $notification ? esc_textarea($notification['message']) : ''; ?></textarea>
                                <p class="description">表示するメッセージを入力してください。日付は自動的に挿入されます。</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="submit">
                    <input type="submit"
                           name="submit"
                           id="submit"
                           class="button button-primary"
                           value="<?php echo $edit_id ? '更新' : '保存'; ?>" />
                    <a href="<?php echo admin_url('admin.php?page=tennis-notification'); ?>" class="button">一覧へ戻る</a>
                </p>
            </form>

            <!-- プレビューエリア -->
            <div class="tsn-preview-container">
                <h2>プレビュー</h2>
                <div id="tsn-preview-area">
                    <div class="tsn-notification-preview">
                        プレビューはここに表示されます
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * 一覧画面の表示
     */
    public function display_list_page() {
        // 削除処理
        if (isset($_GET['delete']) && isset($_GET['_wpnonce'])) {
            if (wp_verify_nonce($_GET['_wpnonce'], 'delete_notification_' . $_GET['delete'])) {
                TSN_Database::delete_notification($_GET['delete']);
                echo '<div class="notice notice-success is-dismissible"><p>削除しました。</p></div>';
            }
        }

        // ページネーション設定
        $per_page = 20; // 1ページあたりの表示件数
        $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($current_page - 1) * $per_page;

        // 全件数を取得
        $total_items = TSN_Database::get_notification_count();

        // 通知一覧を取得（新しい日付順、ページネーション付き）
        $notifications = TSN_Database::get_notifications(array(
            'orderby' => 'notification_date',
            'order' => 'DESC',
            'limit' => $per_page,
            'offset' => $offset
        ));

        // ページ数を計算
        $total_pages = ceil($total_items / $per_page);

        ?>
        <div class="wrap">
            <h1>
                開催連絡一覧
                <a href="<?php echo admin_url('admin.php?page=tennis-notification-add'); ?>" class="page-title-action">新規追加</a>
            </h1>

            <?php if (empty($notifications)) : ?>
                <p>開催連絡はまだ登録されていません。</p>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col" class="manage-column column-date">日付</th>
                            <th scope="col" class="manage-column column-message">メッセージ</th>
                            <th scope="col" class="manage-column column-color">表示色</th>
                            <th scope="col" class="manage-column column-created">作成日時</th>
                            <th scope="col" class="manage-column column-actions">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notifications as $notification) : ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?php
                                        $date = new DateTime($notification['notification_date']);
                                        $weekday = array('日', '月', '火', '水', '木', '金', '土');
                                        echo $date->format('Y年n月j日') . '（' . $weekday[$date->format('w')] . '）';
                                        ?>
                                    </strong>
                                    <?php if ($notification['notification_date'] == current_time('Y-m-d')) : ?>
                                        <span class="badge today">本日</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo esc_html(mb_strimwidth($notification['message'], 0, 60, '...')); ?>
                                </td>
                                <td>
                                    <?php
                                    $color_labels = array(
                                        'green' => '通常連絡',
                                        'yellow' => '注意連絡',
                                        'red' => '中止連絡'
                                    );
                                    ?>
                                    <span class="tsn-color-badge <?php echo esc_attr($notification['color']); ?>">
                                        <?php echo $color_labels[$notification['color']]; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $created_timestamp = get_date_from_gmt($notification['created_at'], 'U');
                                    echo date_i18n('Y/m/d H:i', $created_timestamp);
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=tennis-notification-add&edit=' . $notification['id']); ?>"
                                       class="button button-small">
                                        編集
                                    </a>
                                    <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=tennis-notification&delete=' . $notification['id']), 'delete_notification_' . $notification['id']); ?>"
                                       class="button button-small delete-notification"
                                       onclick="return confirm('この開催連絡を削除してもよろしいですか？');">
                                        削除
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($total_pages > 1) : ?>
                    <div class="tablenav bottom">
                        <div class="tablenav-pages">
                            <span class="displaying-num"><?php printf('%s件', number_format_i18n($total_items)); ?></span>
                            <?php
                            echo paginate_links(array(
                                'base' => add_query_arg('paged', '%#%'),
                                'format' => '',
                                'prev_text' => '&laquo; 前へ',
                                'next_text' => '次へ &raquo;',
                                'total' => $total_pages,
                                'current' => $current_page,
                                'type' => 'plain'
                            ));
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="tsn-info-box">
                <h3>ショートコードの使い方</h3>
                <p>開催連絡を表示したいページや投稿に以下のショートコードを挿入してください：</p>
                <code>[tennis_notification]</code>
                <p>特定の日付の通知を表示する場合：</p>
                <code>[tennis_notification date="2024-01-01"]</code>
                <p>表示日数を指定する場合（デフォルト: 7日）：</p>
                <code>[tennis_notification days="14"]</code>
            </div>
        </div>
        <?php
    }

    /**
     * 通知の保存処理
     */
    public function save_notification() {
        // nonceチェック
        if (!isset($_POST['tsn_nonce']) || !wp_verify_nonce($_POST['tsn_nonce'], 'tsn_save_notification')) {
            wp_die('Security check failed');
        }

        // 権限チェック
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }

        // データの準備
        $data = array(
            'notification_date' => sanitize_text_field($_POST['notification_date']),
            'message' => wp_kses_post($_POST['message']),
            'color' => sanitize_text_field($_POST['color'])
        );

        // IDがある場合は更新
        $edit_id = 0;
        if (isset($_POST['id']) && $_POST['id']) {
            $data['id'] = intval($_POST['id']);
            $edit_id = intval($_POST['id']);
        }

        // 同じ日付のデータが既に存在するかチェック
        $existing = TSN_Database::get_notification_by_date($data['notification_date']);

        // 既存データがあり、かつ編集中のデータと異なる場合はエラー
        if ($existing && (!$edit_id || $existing['id'] != $edit_id)) {
            $redirect_url = add_query_arg(
                array(
                    'page' => 'tennis-notification-add',
                    'message' => 'duplicate',
                    'edit' => $edit_id
                ),
                admin_url('admin.php')
            );
            wp_redirect($redirect_url);
            exit;
        }

        // 保存
        $result = TSN_Database::save_notification($data);

        // リダイレクト
        if ($result) {
            $redirect_url = add_query_arg(
                array(
                    'page' => 'tennis-notification',
                    'message' => 'saved'
                ),
                admin_url('admin.php')
            );
        } else {
            $redirect_url = add_query_arg(
                array(
                    'page' => 'tennis-notification-add',
                    'message' => 'error'
                ),
                admin_url('admin.php')
            );
        }

        wp_redirect($redirect_url);
        exit;
    }
}