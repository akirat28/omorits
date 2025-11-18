<?php
/**
 * Template Name: お問い合わせページ
 * Description: Contact Form 7を使用したお問い合わせページ
 */

// カスタムスタイルをheadに追加
function contact_page_styles() {
    if (is_page_template('page-contact.php')) {
        ?>
        <style>
        /* お問い合わせページ専用スタイル */
        .contact-page-header {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            overflow: hidden;
        }

        .contact-page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .contact-header-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .contact-page-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-page-description {
            font-size: 1.2rem;
            line-height: 1.8;
            opacity: 0.95;
        }

        .contact-form-section {
            padding: 5rem 2rem;
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        }

        .contact-form-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .contact-form-wrapper {
            background: white;
            padding: 0;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            margin-bottom: 4rem;
            overflow: hidden;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .form-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            padding: 2.5rem 3rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-subtitle {
            color: #718096;
            line-height: 1.6;
            margin: 0;
        }

        /* Contact Form 7 モダンスタイル */
        .contact-form-wrapper .wpcf7 {
            margin: 0;
        }

        .contact-form-wrapper .wpcf7-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            padding: 3rem;
        }

        .contact-form-wrapper .wpcf7-form p {
            margin: 0 !important;
            position: relative;
        }

        .contact-form-wrapper .wpcf7-form label {
            display: block !important;
            font-weight: 700 !important;
            margin-bottom: 0.75rem !important;
            color: #2d3748 !important;
            font-size: 0.95rem !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .contact-form-wrapper .wpcf7-form-control-wrap {
            display: block;
            position: relative;
        }

        .contact-form-wrapper input[type="text"],
        .contact-form-wrapper input[type="email"],
        .contact-form-wrapper input[type="tel"],
        .contact-form-wrapper input[type="url"],
        .contact-form-wrapper input[type="number"],
        .contact-form-wrapper textarea,
        .contact-form-wrapper select,
        .contact-form-wrapper .wpcf7-text,
        .contact-form-wrapper .wpcf7-email,
        .contact-form-wrapper .wpcf7-tel,
        .contact-form-wrapper .wpcf7-textarea,
        .contact-form-wrapper .wpcf7-select {
            width: 100% !important;
            padding: 1.25rem 1.5rem !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 12px !important;
            font-size: 1rem !important;
            font-family: inherit !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            background: #f7fafc !important;
            box-sizing: border-box !important;
        }

        .contact-form-wrapper input[type="text"]:hover,
        .contact-form-wrapper input[type="email"]:hover,
        .contact-form-wrapper input[type="tel"]:hover,
        .contact-form-wrapper textarea:hover,
        .contact-form-wrapper select:hover,
        .contact-form-wrapper .wpcf7-text:hover,
        .contact-form-wrapper .wpcf7-email:hover,
        .contact-form-wrapper .wpcf7-tel:hover,
        .contact-form-wrapper .wpcf7-textarea:hover,
        .contact-form-wrapper .wpcf7-select:hover {
            border-color: #cbd5e0 !important;
            background: white !important;
        }

        .contact-form-wrapper input[type="text"]:focus,
        .contact-form-wrapper input[type="email"]:focus,
        .contact-form-wrapper input[type="tel"]:focus,
        .contact-form-wrapper textarea:focus,
        .contact-form-wrapper select:focus,
        .contact-form-wrapper .wpcf7-text:focus,
        .contact-form-wrapper .wpcf7-email:focus,
        .contact-form-wrapper .wpcf7-tel:focus,
        .contact-form-wrapper .wpcf7-textarea:focus,
        .contact-form-wrapper .wpcf7-select:focus {
            outline: none !important;
            border-color: #667eea !important;
            background: white !important;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 8px 16px rgba(102, 126, 234, 0.15) !important;
            transform: translateY(-1px);
        }

        .contact-form-wrapper textarea,
        .contact-form-wrapper .wpcf7-textarea {
            min-height: 180px !important;
            resize: vertical !important;
            line-height: 1.6 !important;
        }

        .contact-form-wrapper select,
        .contact-form-wrapper .wpcf7-select {
            cursor: pointer !important;
            appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 1rem center !important;
            background-size: 20px !important;
            padding-right: 3rem !important;
        }

        .contact-form-wrapper .wpcf7-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            padding: 1.5rem 4rem !important;
            border: none !important;
            border-radius: 14px !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3) !important;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .contact-form-wrapper .wpcf7-submit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .contact-form-wrapper .wpcf7-submit:hover::before {
            width: 300px;
            height: 300px;
        }

        .contact-form-wrapper .wpcf7-submit:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4) !important;
        }

        .contact-form-wrapper .wpcf7-submit:active {
            transform: translateY(-1px) !important;
        }

        .contact-form-wrapper .wpcf7-not-valid-tip {
            color: #f56565 !important;
            font-size: 0.85rem !important;
            margin-top: 0.5rem !important;
            display: flex !important;
            align-items: center;
            gap: 0.5rem;
            animation: shake 0.3s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .contact-form-wrapper .wpcf7-not-valid-tip::before {
            content: '⚠';
            font-size: 1rem;
        }

        .contact-form-wrapper .wpcf7-response-output {
            margin: 1.5rem 0 0 !important;
            padding: 1.25rem 1.5rem !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
            border: none !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact-form-wrapper .wpcf7-mail-sent-ok {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important;
            border: 2px solid #48bb78 !important;
            color: #22543d !important;
        }

        .contact-form-wrapper .wpcf7-mail-sent-ok::before {
            content: '✓';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: #48bb78;
            color: white;
            border-radius: 50%;
            font-weight: 700;
        }

        .contact-form-wrapper .wpcf7-validation-errors {
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%) !important;
            border: 2px solid #fc8181 !important;
            color: #742a2a !important;
        }

        .contact-form-wrapper .wpcf7-validation-errors::before {
            content: '✕';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: #fc8181;
            color: white;
            border-radius: 50%;
            font-weight: 700;
        }

        /* スピナーアニメーション */
        .contact-form-wrapper .wpcf7-spinner {
            border: 3px solid rgba(102, 126, 234, 0.2) !important;
            border-top-color: #667eea !important;
            border-radius: 50% !important;
            width: 30px !important;
            height: 30px !important;
            animation: spin 0.8s linear infinite !important;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* 補足情報 */
        .contact-info-section {
            margin-bottom: 4rem;
        }

        .contact-info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .contact-info-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .contact-info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .contact-info-card:hover::before {
            transform: scaleX(1);
        }

        .contact-info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .info-icon {
            color: #667eea;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .contact-info-card:hover .info-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .contact-info-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1rem;
        }

        .contact-info-card p {
            color: #4a5568;
            line-height: 1.8;
            margin-bottom: 0.5rem;
        }

        .contact-phone a {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-phone a:hover {
            color: #764ba2;
        }

        .contact-hours {
            font-size: 0.9rem;
            color: #718096;
        }

        .contact-info-card a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .contact-info-card a:hover {
            color: #764ba2;
        }

        /* FAQ */
        .faq-section {
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .faq-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1a202c;
            text-align: center;
            margin-bottom: 2.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .faq-item {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
        }

        .faq-item:hover {
            border-color: #667eea;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
            transform: translateX(5px);
            background: white;
        }

        .faq-question {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .faq-answer {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding-left: 2.5rem;
        }

        .faq-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .faq-answer p {
            color: #4a5568;
            line-height: 1.8;
            margin: 0;
        }

        /* レスポンシブ */
        @media (max-width: 768px) {
            .contact-page-header {
                padding: 3rem 1.5rem;
            }

            .contact-page-title {
                font-size: 2rem;
            }

            .contact-page-description {
                font-size: 1rem;
            }

            .contact-form-section {
                padding: 3rem 1rem;
            }

            .form-header {
                padding: 2rem 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .contact-form-wrapper .wpcf7-form {
                padding: 1rem;
                gap: 1.75rem;
            }

            .contact-form-wrapper .wpcf7-form label {
                font-size: 0.85rem !important;
            }

            .contact-form-wrapper input[type="text"],
            .contact-form-wrapper input[type="email"],
            .contact-form-wrapper input[type="tel"],
            .contact-form-wrapper textarea,
            .contact-form-wrapper select,
            .contact-form-wrapper .wpcf7-text,
            .contact-form-wrapper .wpcf7-email,
            .contact-form-wrapper .wpcf7-tel,
            .contact-form-wrapper .wpcf7-textarea,
            .contact-form-wrapper .wpcf7-select {
                padding: 1rem 1.25rem !important;
                font-size: 1rem !important;
            }

            .contact-form-wrapper .wpcf7-submit {
                width: 100%;
                padding: 1.25rem 2rem !important;
                font-size: 1rem !important;
            }

            .contact-info-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .contact-info-card {
                padding: 2rem;
            }

            .faq-section {
                padding: 2rem 1.5rem;
            }

            .faq-title {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .faq-item {
                padding: 1.5rem;
            }

            .faq-question {
                font-size: 1.05rem;
            }

            .faq-answer {
                padding-left: 0;
                margin-top: 0.5rem;
            }

            .faq-icon {
                min-width: 32px;
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
        }
        </style>
        <?php
    }
}
add_action('wp_head', 'contact_page_styles');

get_header();
?>

<main class="site-main">
    <!-- ページヘッダー -->
    <section class="contact-page-header">
        <div class="contact-header-container">
            <h1 class="contact-page-title">お問い合わせ</h1>
            <p class="contact-page-description">
                入会や見学をご希望の方、その他ご質問がございましたら、<br>
                お気軽にお問い合わせください。
            </p>
        </div>
    </section>

    <!-- お問い合わせフォーム -->
    <section class="contact-form-section">
        <div class="contact-form-container">
            <!-- Contact Form 7 ショートコード -->
            <div class="contact-form-wrapper">
                <div class="form-header">
                    <h2 class="form-title">お問い合わせフォーム</h2>
                    <p class="form-subtitle">以下のフォームにご記入の上、送信してください。<br>2営業日以内にご返信いたします。</p>
                </div>
                <?php
                // Contact Form 7のショートコードを表示
                // 管理画面で作成したフォームのIDまたはタイトルを指定
                echo do_shortcode('[contact-form-7 id="1" title="お問い合わせフォーム"]');
                ?>
            </div>

            <!-- 補足情報 -->
            <div class="contact-info-section">
                <div class="contact-info-grid">
                    <div class="contact-info-card">
                        <div class="info-icon">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M12 14h24l-12 10-12-10zM12 14v20h24V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>メールでのお問い合わせ</h3>
                        <p>通常、2営業日以内にご返信いたします。</p>
                    </div>

                    <div class="contact-info-card">
                        <div class="info-icon">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M14 10h8l2 6-3 3c2 4 6 8 10 10l3-3 6 2v8a4 4 0 01-4 4C20 40 8 28 8 12a4 4 0 014-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>お電話でのお問い合わせ</h3>
                        <p class="contact-phone">
                            <a href="tel:03-3775-9711">03-3775-9711</a>
                        </p>
                        <p class="contact-hours">受付時間：平日 9:00-18:00</p>
                    </div>

                    <div class="contact-info-card">
                        <div class="info-icon">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M24 8C17.373 8 12 13.373 12 20c0 10.5 12 24 12 24s12-13.5 12-24c0-6.627-5.373-12-12-12z" stroke="currentColor" stroke-width="2"/>
                                <circle cx="24" cy="20" r="4" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3>所在地</h3>
                        <p>
                            〒143-0016<br>
                            東京都大田区大森北1-2-3
                        </p>
                        <p><a href="<?php echo esc_url(home_url('/#access')); ?>">アクセス情報を見る →</a></p>
                    </div>
                </div>
            </div>

            <!-- よくある質問 -->
            <div class="faq-section">
                <h2 class="faq-title">よくある質問</h2>
                <div class="faq-list">
                    <div class="faq-item">
                        <h3 class="faq-question">
                            <span class="faq-icon">Q</span>
                            見学や体験レッスンは可能ですか？
                        </h3>
                        <div class="faq-answer">
                            <span class="faq-icon">A</span>
                            <p>はい、可能です。体験レッスンは1,100円で実施しており、体験後1ヶ月以内の入会で体験料が全額返金されます。見学は無料ですので、お気軽にお問い合わせください。</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <h3 class="faq-question">
                            <span class="faq-icon">Q</span>
                            初心者でも大丈夫ですか？
                        </h3>
                        <div class="faq-answer">
                            <span class="faq-icon">A</span>
                            <p>もちろんです。ラケットの握り方から丁寧に指導する「はじめてクラス」をご用意しています。経験豊富なコーチがレベルに合わせて指導いたします。</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <h3 class="faq-question">
                            <span class="faq-icon">Q</span>
                            ラケットやシューズのレンタルはありますか？
                        </h3>
                        <div class="faq-answer">
                            <span class="faq-icon">A</span>
                            <p>はい、ございます。体験レッスン時は無料でレンタルしていただけます。入会後のレンタルについては、お問い合わせください。</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <h3 class="faq-question">
                            <span class="faq-icon">Q</span>
                            駐車場はありますか？
                        </h3>
                        <div class="faq-answer">
                            <span class="faq-icon">A</span>
                            <p>はい、27台分の専用駐車場をご用意しています。会員様は無料でご利用いただけます。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
