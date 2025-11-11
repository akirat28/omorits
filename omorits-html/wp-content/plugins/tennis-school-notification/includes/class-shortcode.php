<?php
/**
 * ショートコードクラス
 */
class TSN_Shortcode {

    /**
     * コンストラクタ
     */
    public function __construct() {
        add_shortcode('tennis_notification', array($this, 'render_notification'));
    }

    /**
     * ショートコードの出力
     */
    public function render_notification($atts) {
        // 属性の設定
        $atts = shortcode_atts(array(
            'date' => current_time('Y-m-d'),  // デフォルトは今日
            'days' => 7,                       // 表示する日数（今日から何日先まで）
            'show_all' => false                // すべての通知を表示するか
        ), $atts);

        // 出力バッファ開始
        ob_start();

        if ($atts['show_all']) {
            // すべての通知を取得
            $notifications = TSN_Database::get_notifications(array(
                'orderby' => 'notification_date',
                'order' => 'ASC'
            ));
        } else {
            // 当日の通知を取得（デフォルト動作）
            $notification = TSN_Database::get_notification_by_date($atts['date']);
            $notifications = $notification ? array($notification) : array();
        }

        // 通知がない場合は「掲載待ち」メッセージを表示
        if (empty($notifications)) {
            $this->render_waiting_message();
        } else {
            // 通知を表示
            foreach ($notifications as $notification) {
                $this->render_notification_item($notification);
            }
        }

        return ob_get_clean();
    }

    /**
     * 個別の通知を表示
     */
    private function render_notification_item($notification) {
        // 通知日のフォーマット
        $date = new DateTime($notification['notification_date']);
        $weekday = array('日', '月', '火', '水', '木', '金', '土');
        $notification_date_formatted = $date->format('n月j日') . '（' . $weekday[$date->format('w')] . '）';

        // 最終更新日時のフォーマット（WordPressのタイムゾーンに変換）
        $updated_timestamp = get_date_from_gmt($notification['updated_at'], 'U');
        $updated_date_formatted = date_i18n('n/j H:i', $updated_timestamp) . ' 更新';

        // 色のクラス
        $color_class = 'tsn-' . esc_attr($notification['color']);

        // アイコンの選択
        $icon = '';
        switch ($notification['color']) {
            case 'green':
                $icon = '✓'; // チェックマーク
                break;
            case 'yellow':
                $icon = '⚠'; // 警告マーク
                break;
            case 'red':
                $icon = '✕'; // バツマーク
                break;
        }

        // 本日かどうかをチェック
        $is_today = ($notification['notification_date'] == current_time('Y-m-d'));

        ?>
        <div class="tsn-notification <?php echo $color_class; ?> <?php echo $is_today ? 'tsn-today' : ''; ?>" data-date="<?php echo esc_attr($notification['notification_date']); ?>">
            <div class="tsn-notification-header">
                <span class="tsn-icon"><?php echo $icon; ?></span>
                <span class="tsn-label"><?php echo $notification_date_formatted; ?>のテニススクール開催連絡</span>
                <span class="tsn-date"><?php echo $updated_date_formatted; ?></span>
            </div>
            <div class="tsn-notification-content">
                <p><span class="tsn-mobile-date"><?php echo $notification_date_formatted; ?>：</span><?php echo wp_kses_post($notification['message']); ?></p>
            </div>
        </div>
        <?php
    }

    /**
     * 掲載待ちメッセージの表示
     */
    private function render_waiting_message() {
        // 今日の日付を取得
        $date = new DateTime(current_time('Y-m-d'));
        $weekday = array('日', '月', '火', '水', '木', '金', '土');
        $formatted_date = $date->format('n月j日') . '（' . $weekday[$date->format('w')] . '）';

        ?>
        <div class="tsn-notification tsn-waiting">
            <div class="tsn-notification-header">
                <span class="tsn-icon">📝</span>
                <span class="tsn-label"><?php echo $formatted_date; ?>のテニススクール開催連絡</span>
                <span class="tsn-date">掲載待ち</span>
            </div>
            <div class="tsn-notification-content">
                <p class="tsn-waiting-message"><span class="tsn-mobile-date"><?php echo $formatted_date; ?>：</span>本日のスクール開催は掲載待ち</p>
            </div>
        </div>
        <?php
    }

    /**
     * ウィジェット用の表示関数（将来の拡張用）
     */
    public static function display_widget($args = array()) {
        $shortcode = new self();
        return $shortcode->render_notification($args);
    }
}