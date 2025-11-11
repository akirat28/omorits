<?php
/**
 * データベース操作クラス
 */
class TSN_Database {

    /**
     * テーブル名を取得
     */
    private static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . 'tennis_notifications';
    }

    /**
     * データベーステーブルの作成
     */
    public static function create_table() {
        global $wpdb;

        $table_name = self::get_table_name();
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            notification_date date NOT NULL,
            message text NOT NULL,
            color varchar(20) NOT NULL DEFAULT 'green',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_date (notification_date)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * テーブルの削除
     */
    public static function drop_table() {
        global $wpdb;
        $table_name = self::get_table_name();
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    /**
     * 通知の保存または更新
     */
    public static function save_notification($data) {
        global $wpdb;
        $table_name = self::get_table_name();

        // データのサニタイズ
        $notification_data = array(
            'notification_date' => sanitize_text_field($data['notification_date']),
            'message' => wp_kses_post($data['message']),
            'color' => sanitize_text_field($data['color'])
        );

        if (isset($data['id']) && $data['id']) {
            // 更新
            $result = $wpdb->update(
                $table_name,
                $notification_data,
                array('id' => intval($data['id']))
            );
        } else {
            // 新規作成
            $result = $wpdb->insert($table_name, $notification_data);
        }

        return $result !== false;
    }

    /**
     * 通知の取得（単体）
     */
    public static function get_notification($id) {
        global $wpdb;
        $table_name = self::get_table_name();

        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $id
        );

        return $wpdb->get_row($query, ARRAY_A);
    }

    /**
     * 日付で通知を取得
     */
    public static function get_notification_by_date($date) {
        global $wpdb;
        $table_name = self::get_table_name();

        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE notification_date = %s",
            $date
        );

        return $wpdb->get_row($query, ARRAY_A);
    }

    /**
     * 今日の通知を取得
     */
    public static function get_today_notification() {
        return self::get_notification_by_date(current_time('Y-m-d'));
    }

    /**
     * 通知一覧の取得
     */
    public static function get_notifications($args = array()) {
        global $wpdb;
        $table_name = self::get_table_name();

        $defaults = array(
            'orderby' => 'notification_date',
            'order' => 'DESC',
            'limit' => -1,
            'offset' => 0,
            'date_from' => '',
            'date_to' => ''
        );

        $args = wp_parse_args($args, $defaults);

        $query = "SELECT * FROM $table_name WHERE 1=1";
        $query_args = array();

        // 日付範囲フィルタ
        if (!empty($args['date_from'])) {
            $query .= " AND notification_date >= %s";
            $query_args[] = $args['date_from'];
        }

        if (!empty($args['date_to'])) {
            $query .= " AND notification_date <= %s";
            $query_args[] = $args['date_to'];
        }

        // ソート
        $orderby = in_array($args['orderby'], array('notification_date', 'created_at', 'id')) ? $args['orderby'] : 'notification_date';
        $order = strtoupper($args['order']) === 'ASC' ? 'ASC' : 'DESC';
        $query .= " ORDER BY $orderby $order";

        // ページネーション
        if ($args['limit'] > 0) {
            $query .= " LIMIT %d OFFSET %d";
            $query_args[] = $args['limit'];
            $query_args[] = $args['offset'];
        }

        if (!empty($query_args)) {
            $query = $wpdb->prepare($query, $query_args);
        }

        return $wpdb->get_results($query, ARRAY_A);
    }

    /**
     * 最新の通知を取得（指定日数分）
     */
    public static function get_recent_notifications($days = 7) {
        return self::get_notifications(array(
            'date_from' => current_time('Y-m-d'),
            'date_to' => date('Y-m-d', strtotime("+$days days")),
            'orderby' => 'notification_date',
            'order' => 'ASC'
        ));
    }

    /**
     * 通知の削除
     */
    public static function delete_notification($id) {
        global $wpdb;
        $table_name = self::get_table_name();

        $result = $wpdb->delete($table_name, array('id' => intval($id)));

        return $result !== false;
    }

    /**
     * 古い通知の自動削除（オプション）
     */
    public static function cleanup_old_notifications($days = 365) {
        global $wpdb;
        $table_name = self::get_table_name();

        $date_threshold = date('Y-m-d', strtotime("-$days days"));

        $query = $wpdb->prepare(
            "DELETE FROM $table_name WHERE notification_date < %s",
            $date_threshold
        );

        return $wpdb->query($query);
    }

    /**
     * 通知の件数を取得
     */
    public static function get_notification_count($args = array()) {
        global $wpdb;
        $table_name = self::get_table_name();

        $query = "SELECT COUNT(*) FROM $table_name WHERE 1=1";
        $query_args = array();

        if (!empty($args['date_from'])) {
            $query .= " AND notification_date >= %s";
            $query_args[] = $args['date_from'];
        }

        if (!empty($args['date_to'])) {
            $query .= " AND notification_date <= %s";
            $query_args[] = $args['date_to'];
        }

        if (!empty($query_args)) {
            $query = $wpdb->prepare($query, $query_args);
        }

        return $wpdb->get_var($query);
    }
}