<?php
/**
 * Plugin Name: 大森テニスクラブ 入会＆体験レッスン申込フォーム
 * Plugin URI: https://omori-tennis-club.jp
 * Description: 入会＆体験レッスンの申込フォームをショートコードで提供し、申込データをデータベースに保存します。
 * Version: 1.0.0
 * Author: 大森テニスクラブ
 * Author URI: https://omori-tennis-club.jp
 * Text Domain: omori-contact-form
 * Domain Path: /languages
 */

// 直接アクセスを防止
if (!defined('ABSPATH')) {
    exit;
}

// プラグインの定数定義
define('OMORI_CONTACT_FORM_VERSION', '1.0.0');
define('OMORI_CONTACT_FORM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('OMORI_CONTACT_FORM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * プラグイン有効化時の処理
 */
function omori_contact_form_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'omori_contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        inquiry_type varchar(100) NOT NULL,
        address varchar(255) DEFAULT NULL,
        phone varchar(50) DEFAULT NULL,
        email varchar(255) NOT NULL,
        comment text DEFAULT NULL,
        ip_address varchar(100) DEFAULT NULL,
        user_agent text DEFAULT NULL,
        submitted_at datetime NOT NULL,
        PRIMARY KEY (id),
        KEY submitted_at (submitted_at),
        KEY email (email)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // バージョン番号を保存
    add_option('omori_contact_form_version', OMORI_CONTACT_FORM_VERSION);
}
register_activation_hook(__FILE__, 'omori_contact_form_activate');

/**
 * プラグイン無効化時の処理
 */
function omori_contact_form_deactivate() {
    // 必要に応じて処理を追加
}
register_deactivation_hook(__FILE__, 'omori_contact_form_deactivate');

/**
 * 管理画面メニューの追加
 */
function omori_contact_form_admin_menu() {
    add_menu_page(
        '申込一覧',
        '申込一覧',
        'manage_options',
        'omori-contact-submissions',
        'omori_contact_form_submissions_page',
        'dashicons-email',
        30
    );

    add_submenu_page(
        'omori-contact-submissions',
        '申込詳細',
        null, // メニューに表示しない
        'manage_options',
        'omori-contact-submission-detail',
        'omori_contact_form_submission_detail_page'
    );
}
add_action('admin_menu', 'omori_contact_form_admin_menu');

/**
 * 申込一覧ページの表示
 */
function omori_contact_form_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'omori_contact_submissions';

    // ページング設定
    $per_page = 20;
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    // 総件数を取得
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_pages = ceil($total_items / $per_page);

    // データを取得
    $submissions = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY submitted_at DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        )
    );

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">入会＆体験レッスン申込一覧</h1>
        <hr class="wp-header-end">

        <?php if ($total_items > 0): ?>
            <p>全 <?php echo esc_html(number_format($total_items)); ?> 件</p>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>申込日時</th>
                        <th>お名前</th>
                        <th>種別</th>
                        <th>メールアドレス</th>
                        <th>電話番号</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?php echo esc_html($submission->id); ?></td>
                            <td><?php echo esc_html(date('Y/m/d H:i', strtotime($submission->submitted_at))); ?></td>
                            <td><strong><?php echo esc_html($submission->name); ?></strong></td>
                            <td><?php echo esc_html($submission->inquiry_type); ?></td>
                            <td><?php echo esc_html($submission->email); ?></td>
                            <td><?php echo esc_html($submission->phone ?: '－'); ?></td>
                            <td>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=omori-contact-submission-detail&id=' . $submission->id)); ?>" class="button button-small">
                                    詳細
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="tablenav bottom">
                    <div class="tablenav-pages">
                        <?php
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '',
                            'prev_text' => '&laquo;',
                            'next_text' => '&raquo;',
                            'total' => $total_pages,
                            'current' => $current_page
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <p>申込データがまだありません。</p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * 申込詳細ページの表示
 */
function omori_contact_form_submission_detail_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'omori_contact_submissions';

    $submission_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if (!$submission_id) {
        wp_die('無効なIDです。');
    }

    $submission = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $submission_id)
    );

    if (!$submission) {
        wp_die('申込データが見つかりません。');
    }

    ?>
    <div class="wrap">
        <h1>申込詳細 #<?php echo esc_html($submission->id); ?></h1>
        <a href="<?php echo esc_url(admin_url('admin.php?page=omori-contact-submissions')); ?>" class="page-title-action">← 一覧に戻る</a>
        <hr class="wp-header-end">

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">申込日時</th>
                    <td><?php echo esc_html(date('Y年m月d日 H:i:s', strtotime($submission->submitted_at))); ?></td>
                </tr>
                <tr>
                    <th scope="row">お名前</th>
                    <td><strong><?php echo esc_html($submission->name); ?></strong></td>
                </tr>
                <tr>
                    <th scope="row">お問い合わせ種別</th>
                    <td><?php echo esc_html($submission->inquiry_type); ?></td>
                </tr>
                <tr>
                    <th scope="row">住所</th>
                    <td><?php echo esc_html($submission->address ?: '－'); ?></td>
                </tr>
                <tr>
                    <th scope="row">電話番号</th>
                    <td><?php echo esc_html($submission->phone ?: '－'); ?></td>
                </tr>
                <tr>
                    <th scope="row">メールアドレス</th>
                    <td><a href="mailto:<?php echo esc_attr($submission->email); ?>"><?php echo esc_html($submission->email); ?></a></td>
                </tr>
                <tr>
                    <th scope="row">コメント</th>
                    <td><?php echo nl2br(esc_html($submission->comment ?: '－')); ?></td>
                </tr>
                <tr>
                    <th scope="row">IPアドレス</th>
                    <td><?php echo esc_html($submission->ip_address ?: '－'); ?></td>
                </tr>
                <tr>
                    <th scope="row">ユーザーエージェント</th>
                    <td><?php echo esc_html($submission->user_agent ?: '－'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * ショートコード: [omori_contact_form]
 */
function omori_contact_form_shortcode() {
    ob_start();
    ?>
    <!-- 入力画面 -->
    <div id="omori-form-input" class="omori-form-step">
        <form id="omori-contact-form" class="omori-contact-form home-contact-form">
            <div class="form-group">
                <label for="omori-contact-name">
                    お名前<span class="required-badge">必須</span>
                </label>
                <input type="text" id="omori-contact-name" name="name" required placeholder="例：山田 太郎">
            </div>

            <div class="form-group">
                <label>
                    お問い合わせ種別<span class="required-badge">必須</span>
                </label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="inquiry_type" value="入会のお問い合わせ" required>
                        <span>入会のお問い合わせ</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="inquiry_type" value="体験レッスンのお申し込み" required>
                        <span>体験レッスンのお申し込み</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="inquiry_type" value="その他" required>
                        <span>その他</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="omori-contact-address">住所</label>
                <input type="text" id="omori-contact-address" name="address" placeholder="例：東京都大田区大森北1-2-3">
            </div>

            <div class="form-group">
                <label for="omori-contact-phone">電話番号</label>
                <input type="tel" id="omori-contact-phone" name="phone" placeholder="例：03-1234-5678">
            </div>

            <div class="form-group">
                <label for="omori-contact-email">
                    メールアドレス<span class="required-badge">必須</span>
                </label>
                <input type="email" id="omori-contact-email" name="email" required placeholder="例：example@email.com">
            </div>

            <div class="form-group">
                <label for="omori-contact-comment">コメント</label>
                <textarea id="omori-contact-comment" name="comment" rows="5" placeholder="お問い合わせ内容をご記入ください"></textarea>
            </div>

            <div class="form-submit">
                <button type="submit" class="btn btn-primary btn-large" id="omori-contact-submit-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>確認画面へ</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 確認画面 -->
    <div id="omori-form-confirm" class="omori-form-step" style="display: none;">
        <div class="omori-confirm-container">
            <h3 class="omori-confirm-title">入力内容のご確認</h3>
            <p class="omori-confirm-description">以下の内容でよろしければ「登録する」ボタンを押してください。</p>

            <table class="omori-confirm-table">
                <tbody>
                    <tr>
                        <th>お名前</th>
                        <td id="confirm-name"></td>
                    </tr>
                    <tr>
                        <th>お問い合わせ種別</th>
                        <td id="confirm-inquiry-type"></td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td id="confirm-address"></td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td id="confirm-phone"></td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td id="confirm-email"></td>
                    </tr>
                    <tr>
                        <th>コメント</th>
                        <td id="confirm-comment" style="white-space: pre-wrap;"></td>
                    </tr>
                </tbody>
            </table>

            <div class="omori-confirm-buttons">
                <button type="button" class="btn btn-secondary btn-large" id="omori-back-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11 17l-5-5m0 0l5-5m-5 5h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>戻る</span>
                </button>
                <button type="button" class="btn btn-primary btn-large" id="omori-register-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>登録する</span>
                </button>
            </div>
        </div>
    </div>

    <!-- サンクス画面 -->
    <div id="omori-form-thanks" class="omori-form-step" style="display: none;">
        <div class="omori-thanks-container">
            <div class="omori-thanks-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="38" stroke="#667eea" stroke-width="4"/>
                    <path d="M25 40l10 10L55 30" stroke="#667eea" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="omori-thanks-title">お申し込みありがとうございました</h3>
            <p class="omori-thanks-message">
                お申し込み内容を確認後、担当者よりご連絡させていただきます。<br>
                今しばらくお待ちくださいますようお願いいたします。
            </p>
            <div class="omori-thanks-note">
                <p>※ 2営業日以内にご連絡いたします。</p>
                <p>※ メールが届かない場合は、迷惑メールフォルダをご確認いただくか、<br>お電話にてお問い合わせください。</p>
            </div>
        </div>
    </div>

    <div id="omori-form-message" class="form-message" style="display: none;"></div>

    <style>
    .omori-form-step {
        transition: opacity 0.3s ease;
    }

    /* 確認画面 */
    .omori-confirm-container {
        background: white;
        border-radius: 16px;
        padding: 3rem;
    }

    .omori-confirm-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1rem;
        text-align: center;
    }

    .omori-confirm-description {
        text-align: center;
        color: #4a5568;
        margin-bottom: 2.5rem;
    }

    .omori-confirm-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2.5rem;
    }

    .omori-confirm-table th,
    .omori-confirm-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }

    .omori-confirm-table th {
        background: #f7fafc;
        font-weight: 700;
        color: #2d3748;
        width: 200px;
        white-space: nowrap;
    }

    .omori-confirm-table td {
        color: #4a5568;
        word-break: break-word;
    }

    .omori-confirm-table tr:last-child th,
    .omori-confirm-table tr:last-child td {
        border-bottom: none;
    }

    .omori-confirm-buttons {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
    }

    /* セカンダリーボタン（戻るボタン）のスタイル */
    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-secondary:hover {
        background: #667eea;
        color: white;
    }

    .btn-secondary svg {
        color: currentColor;
    }

    /* サンクス画面 */
    .omori-thanks-container {
        text-align: center;
        padding: 4rem 2rem;
    }

    .omori-thanks-icon {
        margin-bottom: 2rem;
        animation: scaleIn 0.5s ease;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .omori-thanks-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
    }

    .omori-thanks-message {
        font-size: 1.1rem;
        color: #4a5568;
        line-height: 1.8;
        margin-bottom: 2.5rem;
    }

    .omori-thanks-note {
        background: #f7fafc;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        border-radius: 8px;
        text-align: left;
        max-width: 600px;
        margin: 0 auto;
    }

    .omori-thanks-note p {
        margin: 0.5rem 0;
        color: #4a5568;
        font-size: 0.95rem;
    }

    /* レスポンシブ */
    @media (max-width: 768px) {
        .omori-confirm-container {
            padding: 2rem 1.5rem;
        }

        .omori-confirm-title {
            font-size: 1.5rem;
        }

        .omori-confirm-table {
            display: block;
        }

        .omori-confirm-table tbody,
        .omori-confirm-table tr,
        .omori-confirm-table th,
        .omori-confirm-table td {
            display: block;
        }

        .omori-confirm-table th {
            width: 100%;
            padding-bottom: 0.5rem;
            border-bottom: none;
        }

        .omori-confirm-table td {
            padding-top: 0;
            padding-bottom: 1.5rem;
        }

        .omori-confirm-buttons {
            flex-direction: column;
        }

        .omori-confirm-buttons .btn {
            width: 100%;
        }

        .omori-thanks-container {
            padding: 3rem 1.5rem;
        }

        .omori-thanks-title {
            font-size: 1.5rem;
        }

        .omori-thanks-message {
            font-size: 1rem;
        }

        .omori-thanks-note {
            padding: 1.25rem;
        }
    }
    </style>

    <script>
    (function() {
        const formInput = document.getElementById('omori-form-input');
        const formConfirm = document.getElementById('omori-form-confirm');
        const formThanks = document.getElementById('omori-form-thanks');
        const form = document.getElementById('omori-contact-form');
        const formMessage = document.getElementById('omori-form-message');

        if (!form) return;

        let formData = {};

        // 入力画面の送信（確認画面へ）
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // フォームデータを保存
            formData = {
                name: document.getElementById('omori-contact-name').value,
                inquiry_type: document.querySelector('input[name="inquiry_type"]:checked')?.value || '',
                address: document.getElementById('omori-contact-address').value,
                phone: document.getElementById('omori-contact-phone').value,
                email: document.getElementById('omori-contact-email').value,
                comment: document.getElementById('omori-contact-comment').value
            };

            // 確認画面に値を表示
            document.getElementById('confirm-name').textContent = formData.name;
            document.getElementById('confirm-inquiry-type').textContent = formData.inquiry_type;
            document.getElementById('confirm-address').textContent = formData.address || '－';
            document.getElementById('confirm-phone').textContent = formData.phone || '－';
            document.getElementById('confirm-email').textContent = formData.email;
            document.getElementById('confirm-comment').textContent = formData.comment || '－';

            // 画面切り替え
            formInput.style.display = 'none';
            formConfirm.style.display = 'block';
            formThanks.style.display = 'none';
            formMessage.style.display = 'none';
        });

        // 戻るボタン
        document.getElementById('omori-back-btn').addEventListener('click', function() {
            formInput.style.display = 'block';
            formConfirm.style.display = 'none';
            formThanks.style.display = 'none';
            formMessage.style.display = 'none';
        });

        // 登録ボタン
        document.getElementById('omori-register-btn').addEventListener('click', function() {
            const registerBtn = this;
            const originalBtnText = registerBtn.innerHTML;

            // ボタンを無効化してローディング表示
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<span>登録中...</span>';
            formMessage.style.display = 'none';

            // AJAXでフォーム送信
            const submitData = new FormData();
            submitData.append('action', 'omori_contact_form_submit');
            submitData.append('nonce', '<?php echo wp_create_nonce('omori_contact_form_nonce'); ?>');
            submitData.append('name', formData.name);
            submitData.append('inquiry_type', formData.inquiry_type);
            submitData.append('address', formData.address);
            submitData.append('phone', formData.phone);
            submitData.append('email', formData.email);
            submitData.append('comment', formData.comment);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: submitData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // サンクス画面を表示
                    formInput.style.display = 'none';
                    formConfirm.style.display = 'none';
                    formThanks.style.display = 'block';
                    formMessage.style.display = 'none';

                    // フォームをリセット
                    form.reset();
                    formData = {};
                } else {
                    formMessage.className = 'form-message error';
                    formMessage.textContent = data.data.message || 'エラーが発生しました。もう一度お試しください。';
                    formMessage.style.display = 'block';

                    // 確認画面の上にスクロール
                    formConfirm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            })
            .catch(error => {
                formMessage.className = 'form-message error';
                formMessage.textContent = '送信に失敗しました。もう一度お試しください。';
                formMessage.style.display = 'block';

                // 確認画面の上にスクロール
                formConfirm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .finally(() => {
                // ボタンを再度有効化
                registerBtn.disabled = false;
                registerBtn.innerHTML = originalBtnText;
            });
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('omori_contact_form', 'omori_contact_form_shortcode');

/**
 * AJAX: フォーム送信処理
 */
function omori_contact_form_submit_handler() {
    // ノンスの検証
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'omori_contact_form_nonce')) {
        wp_send_json_error(array('message' => '不正なリクエストです。'));
        return;
    }

    // フォームデータの取得とサニタイズ
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $inquiry_type = isset($_POST['inquiry_type']) ? sanitize_text_field($_POST['inquiry_type']) : '';
    $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $comment = isset($_POST['comment']) ? sanitize_textarea_field($_POST['comment']) : '';

    // バリデーション
    if (empty($name)) {
        wp_send_json_error(array('message' => 'お名前を入力してください。'));
        return;
    }

    if (empty($inquiry_type)) {
        wp_send_json_error(array('message' => 'お問い合わせ種別を選択してください。'));
        return;
    }

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array('message' => '有効なメールアドレスを入力してください。'));
        return;
    }

    // データベースに保存
    global $wpdb;
    $table_name = $wpdb->prefix . 'omori_contact_submissions';

    $result = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'inquiry_type' => $inquiry_type,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'comment' => $comment,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'submitted_at' => current_time('mysql')
        ),
        array(
            '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'
        )
    );

    if ($result === false) {
        wp_send_json_error(array('message' => 'データの保存に失敗しました。もう一度お試しください。'));
        return;
    }

    // 成功レスポンス
    wp_send_json_success(array('message' => 'お申し込みありがとうございます。内容を確認後、担当者よりご連絡させていただきます。'));
}
add_action('wp_ajax_omori_contact_form_submit', 'omori_contact_form_submit_handler');
add_action('wp_ajax_nopriv_omori_contact_form_submit', 'omori_contact_form_submit_handler');
