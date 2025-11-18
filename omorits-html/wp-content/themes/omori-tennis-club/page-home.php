<?php
/**
 * Template Name: HOMEページ
 * Description: 大森テニスクラブのトップページ専用テンプレート
 */

get_header();
?>

<main class="site-main">
    <!-- ヒーローセクション -->
    <?php
    // デフォルトの背景画像を設定
    $default_hero_image = get_template_directory_uri() . '/images/kv01.jpg';

    // カスタマイザーから設定を取得（デフォルト画像を指定）
    $hero_bg_image = get_theme_mod('hero_background_image', $default_hero_image);
    $overlay_opacity = get_theme_mod('hero_overlay_opacity', '20');
    $overlay_type = get_theme_mod('hero_overlay_type', 'gradient');

    // オーバーレイスタイルを設定
    $overlay_style = '';
    switch($overlay_type) {
        case 'none':
            $overlay_style = 'background: transparent;';
            break;
        case 'dark':
            $opacity_decimal = $overlay_opacity / 100;
            $overlay_style = 'background: rgba(0, 0, 0, ' . $opacity_decimal . ');';
            break;
        case 'gradient':
            $opacity_decimal = $overlay_opacity / 100;
            $overlay_style = 'background: linear-gradient(135deg, rgba(102, 126, 234, ' . $opacity_decimal . ') 0%, rgba(118, 75, 162, ' . $opacity_decimal . ') 100%);';
            break;
        case 'blue':
            $opacity_decimal = $overlay_opacity / 100;
            $overlay_style = 'background: linear-gradient(135deg, rgba(30, 60, 114, ' . $opacity_decimal . ') 0%, rgba(42, 82, 152, ' . $opacity_decimal . ') 100%);';
            break;
    }

    // 背景スタイル（デフォルトまたはカスタム画像を使用）
    $bg_style = 'background-image: url(\'' . esc_url($hero_bg_image) . '\');';
    ?>
    <section class="home-hero" style="<?php echo esc_attr($bg_style); ?>">
        <div class="hero-overlay" style="<?php echo esc_attr($overlay_style); ?>"></div>
        <div class="hero-content">
            <span class="hero-label"> Omori Tennis Club Since 1923</span>
            <h1 class="hero-title">
                <span class="title-line gradient-text">あなたのテニスを次のレベルに！</span>
            </h1>
            <p class="hero-description">はじめての一歩も、勝利への挑戦も。<br />みんなが主役のコートで最高の一打を。</p>
            <div class="hero-notification">
                <?php echo do_shortcode('[tennis_notification]'); ?>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- スクール紹介セクション -->
    <section id="school-intro" class="school-intro-section">
        <div class="school-intro-container">
            <!-- ヘッダー -->
            <div class="section-header">
                <span class="section-label">About Our School</span>
                <h2 class="section-title">スクール紹介</h2>
                <p class="section-description">最高のコートで、新しい「楽しい」を見つけませんか？</p>
            </div>

            <!-- イントロダクション -->
            <div class="intro-welcome" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/school_img01.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.3);"></div>
                <div class="welcome-content" style="position: relative; z-index: 1;">
                    <h3 class="welcome-title">大森テニススクールへようこそ！</h3>
                    <p class="welcome-text">
                        「何か新しいことを始めたい」「体を動かしたいけど、どうせなら楽しくなくちゃ！」<br>
                        もしあなたが今そう思っているなら、ぜひ一度、大森テニススクールに遊びに来ませんか？
                    </p>
                    <p class="welcome-message">
                        私たちは、テニスに興味を持つ「あなた」を心から歓迎します！<br>
                        ラケットを握るのが初めての方も、久しぶりにプレーする方も、もっと上達したい経験者の方も、大歓迎です。
                    </p>
                    <p class="welcome-cta">私たちと一緒に、テニスのある充実した毎日をスタートしましょう！</p>
                </div>
            </div>

            <!-- 特徴グリッド -->
            <div class="school-features-grid">
                <!-- 1. コート環境 -->
                <div class="school-feature-card highlight">
                    <div class="feature-number">01</div>
                    <div class="feature-icon-bg">
                        <svg class="feature-icon" width="48" height="48" viewBox="0 0 48 48" fill="none">
                            <rect x="8" y="8" width="32" height="32" rx="4" stroke="currentColor" stroke-width="2"/>
                            <line x1="24" y1="8" x2="24" y2="40" stroke="currentColor" stroke-width="2"/>
                            <circle cx="24" cy="24" r="4" fill="currentColor"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">都内屈指のコート環境</h3>
                    <p class="feature-card-description">
                        <strong>観覧席のある砂入り人工芝のメインコート3面と、隣接する砂入り人工芝のコート6面の計9面</strong>を誇ります！
                    </p>
                    <ul class="feature-list">
                        <li>人工芝コート9面（スクール２～４面使用）</li>
                        <li>足腰への負担が少ない砂入り人工芝</li>
                        <li>ナイター照明完備で仕事帰りも安心</li>
                    </ul>
                </div>

                <!-- 2. クラス紹介 -->
                <div class="school-feature-card">
                    <div class="feature-number">02</div>
                    <div class="feature-icon-bg">
                        <svg class="feature-icon" width="48" height="48" viewBox="0 0 48 48" fill="none">
                            <circle cx="16" cy="16" r="6" stroke="currentColor" stroke-width="2"/>
                            <circle cx="32" cy="16" r="6" stroke="currentColor" stroke-width="2"/>
                            <circle cx="24" cy="32" r="6" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">レベル別クラス</h3>
                    <p class="feature-card-description">
                        あなたのレベルに必ず合うクラスがあります。「できるかな…」その不安、私たちが解消します。
                    </p>
                    <ul class="feature-list">
                        <li><strong>はじめてクラス</strong> - ラケットの握り方から丁寧にサポート</li>
                        <li><strong>初級～上級クラス</strong> - あなたの「もっと！」に全力で応える</li>
                        <li><strong>ジュニアクラス</strong> - お子様の習い事に最適</li>
                    </ul>
                </div>

                <!-- 3. プライベートレッスン -->
                <div class="school-feature-card">
                    <div class="feature-number">03</div>
                    <div class="feature-icon-bg">
                        <svg class="feature-icon" width="48" height="48" viewBox="0 0 48 48" fill="none">
                            <path d="M24 8L28 20H40L30 28L34 40L24 32L14 40L18 28L8 20H20L24 8Z" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">プライベートレッスン</h3>
                    <p class="feature-card-description">
                        あなたの「苦手」を「得意」に変える魔法。マンツーマンで徹底指導します。
                    </p>
                    <ul class="feature-list">
                        <li>あなただけの特別メニュー</li>
                        <li>コーチがマンツーマンで徹底指導</li>
                        <li>苦手克服から試合対策まで</li>
                    </ul>
                </div>

                <!-- 4. 体験・入会案内 -->
                <div class="school-feature-card special">
                    <div class="feature-number">04</div>
                    <div class="feature-icon-bg">
                        <svg class="feature-icon" width="48" height="48" viewBox="0 0 48 48" fill="none">
                            <rect x="8" y="12" width="32" height="24" rx="2" stroke="currentColor" stroke-width="2"/>
                            <path d="M16 20L22 26L32 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">お得な体験レッスン</h3>
                    <p class="feature-card-description">
                        まずは一度、このコートの素晴らしさとスクールの雰囲気を「体感」しに来てください。
                    </p>
                    <div class="trial-offer">
                        <div class="trial-price">
                            <span class="price-label">体験レッスン</span>
                            <span class="price-value">¥1,100</span>
                        </div>
                        <ul class="feature-list">
                            <li>ラケット・シューズのレンタルあり</li>
                            <li>体験後1ヶ月以内の入会で体験料全額返金</li>
                            <li>初めての入会で入会金無料</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- スクールの特徴セクション -->
    <section id="features" class="features-section">
        <div class="section-header">
            <span class="section-label">Features</span>
            <h2 class="section-title">スクールの特徴</h2>
            <p class="section-description">最高の環境で、テニスを楽しむ</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon-wrapper" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/subcoat.jpg'); background-size: cover; background-position: center; width: calc(100% + 5rem); height: 250px; margin: -2.5rem -2.5rem 2rem -2.5rem; border-radius: 15px 15px 0 0;">
                </div>
                <h3>充実した施設</h3>
                <p>砂入り人工芝コート9面を完備。全天候型で快適なプレー環境を提供します。ナイター設備も充実しており、仕事帰りの練習も可能です。</p>
                <a href="充実した施設" class="feature-link">詳しく見る →</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/経験豊富なコーチ陣.jpg'); background-size: cover; background-position: center; width: calc(100% + 5rem); height: 250px; margin: -2.5rem -2.5rem 2rem -2.5rem; border-radius: 15px 15px 0 0;">
                </div>
                <h3>経験豊富なコーチ陣</h3>
                <p>プロテニスプレーヤー経験者を含む、経験豊富なコーチ陣が丁寧に指導。初心者から上級者まで、レベルに合わせたレッスンを提供します。</p>
                <a href="経験豊富なコーチ陣" class="feature-link">詳しく見る →</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/class.jpg'); background-size: cover; background-position: center; width: calc(100% + 5rem); height: 250px; margin: -2.5rem -2.5rem 2rem -2.5rem; border-radius: 15px 15px 0 0;">
                </div>
                <h3>多様なクラスとジュニア</h3>
                <p>初級、中級、上級などニーズに合わせた多様なプランをご用意。小学生から大人まで無理なく続けられるクラス体系です。</p>
                <a href="多様なクラスとジュニア" class="feature-link">詳しく見る →</a>
            </div>
        </div>
    </section>

    <!-- 施設案内セクション -->
    <section id="facilities" class="facilities-section">
        <div class="facilities-container">
            <!-- ヘッダー -->
            <div class="section-header">
                <span class="section-label">Facilities</span>
                <h2 class="section-title">施設案内</h2>
                <p class="section-description">充実した設備で快適なテニスライフを</p>
            </div>

            <!-- カルーセル -->
            <div class="facilities-carousel-wrapper">
                <div class="facilities-carousel">
                    <div class="carousel-track">
                        <!-- 施設1: メインコート -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/maincoat.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>メインコート（砂入り人工芝 3面）</h3>
                                    <p>観覧席を備えた広々としたメインコート</p>
                                </div>
                            </div>
                        </div>

                        <!-- 施設2: サブコート -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/subcoat.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>サブコート（砂入り人工芝 6面）</h3>
                                    <p>全天候型で快適にプレーできます</p>
                                </div>
                            </div>
                        </div>

                        <!-- 施設3: クラブハウス -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/clubhouse.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>クラブハウス</h3>
                                    <p>快適な空間でリラックスできます</p>
                                </div>
                            </div>
                        </div>

                        <!-- 施設4: シャワールーム -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/shower.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>シャワールーム</h3>
                                    <p>清潔なシャワー設備完備</p>
                                </div>
                            </div>
                        </div>

                        <!-- 施設5: ロッカールーム -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/ロッカールーム.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>ロッカールーム</h3>
                                    <p>広々としたロッカー完備</p>
                                </div>
                            </div>
                        </div>

                        <!-- 施設6: ラウンジ -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/lounge.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>ラウンジ</h3>
                                    <p>くつろぎの空間でリフレッシュ</p>
                                </div>
                            </div>
                        </div>

                        <!-- 施設7: 駐車場 -->
                        <div class="facility-slide">
                            <div class="facility-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/駐車場.jpg'); background-size: cover; background-position: center;">
                                <div class="facility-caption">
                                    <h3>駐車場（27台完備）</h3>
                                    <p>会員様は無料でご利用いただけます</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ナビゲーションボタン -->
                <button class="carousel-btn prev" aria-label="前へ">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="carousel-btn next" aria-label="次へ">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- インジケーター -->
                <div class="carousel-indicators">
                    <button class="indicator active" data-slide="0"></button>
                    <button class="indicator" data-slide="1"></button>
                    <button class="indicator" data-slide="2"></button>
                    <button class="indicator" data-slide="3"></button>
                    <button class="indicator" data-slide="4"></button>
                    <button class="indicator" data-slide="5"></button>
                    <button class="indicator" data-slide="6"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- クラスの種類とジュニアセクション -->
    <section id="classes" class="classes-section">
        <div class="classes-container">
            <div class="section-header">
                <span class="section-label">Classes</span>
                <h2 class="section-title">クラスの種類とジュニア</h2>
                <p class="section-description">レベルに合わせた多彩なクラスをご用意</p>
            </div>

            <!-- 一般クラス -->
            <div class="class-category">
                <h3 class="category-title">一般クラス</h3>
                <div class="class-table">
                    <div class="class-row">
                        <div class="class-level">初級</div>
                        <div class="class-description">初心者の方。数回程度経験のある方。各ショットの基本を覚えていただきます。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">初中級</div>
                        <div class="class-description">各ショットを理解しており、ラリーの繋げる方。各ショットの安定と雁行陣の動きを身につけていただきます。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">中級</div>
                        <div class="class-description">雁行陣を理解し、各ショットにある程度安定感のある方。並行陣の動きを覚えていただきます。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">中上級</div>
                        <div class="class-description">ある程度、ボールのスピードに対応ができ、安定している方。並行陣の動き、ゲームの組み立てを目指します。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">上級</div>
                        <div class="class-description">各ショットに安定感があり、ボールのスピードコントロールができる方。より高度なゲームを目指します。</div>
                    </div>
                </div>
            </div>

            <!-- ジュニアクラス -->
            <div class="class-category">
                <h3 class="category-title">ジュニアクラス</h3>
                <div class="class-table">
                    <div class="class-row">
                        <div class="class-level">J1</div>
                        <div class="class-description">小学校1年生から6年生の初心者</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">J2</div>
                        <div class="class-description">小学校1年生から6年生の初級者　※見極めテストあり。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">J3</div>
                        <div class="class-description">小学校1年生から6年生の初中級者　※見極めテストあり。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">J4</div>
                        <div class="class-description">中・高校生までの初級者</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">J5</div>
                        <div class="class-description">中・高校生までの中級者　※見極めテストあり。</div>
                    </div>
                    <div class="class-row">
                        <div class="class-level">選抜Jr</div>
                        <div class="class-description">中・高校生までの上級者、定員1面6人まで　※見極めテストあり。</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 体験レッスンセクション -->
    <section id="trial" class="trial-section">
        <div class="trial-container">
            <div class="section-header">
                <span class="section-label">Trial Lesson</span>
                <h2 class="section-title">体験レッスン</h2>
                <p class="section-description">まずは体験レッスンからスタート</p>
            </div>

            <div class="trial-content">
                <div class="trial-price-box">
                    <div class="price-highlight">
                        <span class="price-label">体験料</span>
                        <span class="price-amount">¥1,100</span>
                    </div>
                    <div class="trial-apply-link">
                        <p class="apply-text">お申し込みはこちら</p>
                        <a href="#contact" class="apply-link">入会＆体験レッスンの申込</a>
                    </div>
                </div>

                <div class="trial-info-grid">
                    <div class="trial-info-card">
                        <div class="info-icon">🎾</div>
                        <h4>体験レッスンについて</h4>
                        <p>スクール入会前に希望クラスにて実際に体験できます。クラス時間割の中より希望クラスを選んでいただき、フロントにてお申し込みください。</p>
                        <p class="highlight-text">体験後1か月以内に入会される場合は、体験料は返金し、初めて入会される場合に限り入会金は無料と致します。</p>
                    </div>

                    <div class="trial-info-card">
                        <div class="info-icon">👕</div>
                        <h4>レンタルあり</h4>
                        <p>貸しラケット、貸しシューズもありますのでお気軽にご参加ください。</p>
                    </div>

                    <div class="trial-info-card">
                        <div class="info-icon">📝</div>
                        <h4>レッスン受講料</h4>
                        <div class="fee-table">
                            <div class="fee-header">
                                <p><strong>入会金</strong> ¥5,500</p>
                            </div>
                            <div class="fee-section">
                                <h5>一般（1期4回）</h5>
                                <div class="fee-row">
                                    <span>平日昼間</span>
                                    <span>¥11,000</span>
                                </div>
                                <div class="fee-row">
                                    <span>土・日</span>
                                    <span>¥12,200</span>
                                </div>
                                <div class="fee-row">
                                    <span>ナイター</span>
                                    <span>¥12,200</span>
                                </div>
                            </div>
                            <div class="fee-section">
                                <h5>ジュニア（1期4回）</h5>
                                <div class="fee-row">
                                    <span>J1・J2・J3</span>
                                    <span>¥9,200</span>
                                </div>
                                <div class="fee-row">
                                    <span>J4・J5</span>
                                    <span>¥11,600</span>
                                </div>
                                <div class="fee-row">
                                    <span>選抜Jr</span>
                                    <span>¥12,200</span>
                                </div>
                            </div>
                            <p class="fee-note">※2クラス以上お申し込みの場合、2,200円からの割引制度があります</p>
                        </div>
                    </div>

                    <div class="trial-info-card">
                        <div class="info-icon">📋</div>
                        <h4>入会手続き</h4>
                        <p>当スクール所定の申込用紙に記入の上、定期的に受講が可能なクラスにご登録ください。</p>
                        <p class="small-text">※クラスの登録状況により、ご希望のクラスに登録できない場合もございますのでご了承ください。</p>
                        <p>受講料は口座振替になりますので、当スクール所定の「集金代行依頼書」に必要事項をご記入ならびに金融機関届け印を押印の上、受講料2ヶ月分(再入会の場合は入会金）を添えて、フロント迄お申込ください。</p>

                        <div class="required-items">
                            <h5>お手続きに必要なもの</h5>
                            <ul>
                                <li>振替預金口座の金融機関名、支店名、口座番号、預金者名義</li>
                                <li>金融機関のお届け印</li>
                            </ul>
                            <p class="small-text">受講料は、ご入会後3ヶ月目より、前月27日に口座振替させて頂きます。尚、27日が休業日の場合は翌営業日とさせて頂きます。</p>
                            <p class="small-text">※入会申込書などの記載事項に変更が生じた場合はお早めにご連絡ください。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (get_theme_mod('campaign_section_enable', true)): ?>
    <!-- 新規入会案内セクション -->
    <section id="campaign" class="campaign-section">
        <div class="campaign-container">
            <div class="campaign-badge">期間限定</div>
            <div class="section-header">
                <span class="section-label">Campaign</span>
                <h2 class="section-title">新規入会キャンペーン</h2>
                <p class="deadline">申込期限：<?php echo esc_html(get_theme_mod('campaign_deadline', '11/22日まで')); ?></p>
            </div>

            <div class="campaign-content">
                <div class="campaign-main">
                    <div class="campaign-offer">
                        <div class="offer-item highlight">
                            <div class="offer-icon">🎉</div>
                            <h3>入会金・初月受講料無料</h3>
                            <p class="offer-note">※土日クラスの空き は少なめですのでご了承ください。</p>
                        </div>

                        <div class="offer-item special">
                            <div class="offer-icon">🎁</div>
                            <h3>ジュニアJ1・J2・J3クラス入会の方</h3>
                            <p><strong>入会金無料 ＋ ラケット・シューズプレゼント！</strong></p>
                            <p class="offer-note">※ジュニアクラス入会の方でラケット・シューズお持ちの方は初月受講料無料に変更することが出来ます。</p>
                        </div>
                    </div>

                    <div class="campaign-conditions">
                        <h4>適用条件</h4>
                        <ul class="conditions-list">
                            <li>入会希望クラスに空きがある場合にキャンペーン適用となります</li>
                            <li>スクールに初めてご入会される方、退会後一年以上の方を対象とさせて頂きます</li>
                            <li>お一人様1クラスに限らせて頂きます</li>
                            <li>入会時に2ヶ月目の受講料を頂きます</li>
                        </ul>
                    </div>
                </div>

                <div class="campaign-cta">
                    <p class="cta-text">お申込み・お問い合わせは受付までお願いいたします。</p>
                    <div class="cta-buttons">
                        <a href="#contact" class="btn btn-primary btn-large">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" fill="currentColor"/>
                            </svg>
                            <span>今すぐお申し込み</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- アクセスセクション（バランス改良版） -->
    <section id="access" class="access-section">
        <div class="section-header text-center">
            <span class="section-label">Access</span>
            <h2 class="section-title">アクセス</h2>
            <p class="section-description">大森テニスクラブへのアクセス方法</p>
        </div>

        <div class="access-container">
            <!-- 左側：地図 -->
            <div class="access-map-wrapper">
                <div class="map-container">
                    <!-- Google Maps埋め込み -->
                    <iframe
                        src="https://maps.google.com/maps?q=大森テニスクラブ、テニススクール/@35.5876932,139.7234519,17z&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- 右側：アクセス情報 -->
            <div class="access-info-wrapper">
                <div class="access-info">
                    <!-- 交通アクセス -->
                        <h3 class="info-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4 8h12M4 8l-2 8h16l-2-8M4 8V4a2 2 0 012-2h8a2 2 0 012 2v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            交通アクセス
                        </h3>
                        <div class="access-method">
                            <h4>🗺️ 住所</h4>
                            <ul>
                                <li>〒143-0023 東京都大田区山王2-24-12</li>
                                <li>TEL <a href="tel:03-3775-9711">03-3775-9711</a></li>
                            </ul>
                        </div>
                        <div class="access-method">
                            <h4>🚃 電車でお越しの方</h4>
                            <ul>
                                <li>JR大森駅山王西口から５分、天祖神社への階段を上がり、フラワーデザインスクールを右に曲がり３つめの角を左へ</li>
                            </ul>
                        </div>
                        <div class="access-method">
                            <h4>🚗 お車でお越しの方</h4>
                            <ul>
                                <li>車では２方向からクラブに行くことができます。</li>
                                <li>補助40号から「うなぎ屋」の横の路を入り突き当たりを左に300ｍ</li>
                                <li>大森駅から池上通り沿いに３つめの信号を右折、坂を道なりに200ｍ進み右折。</li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </section>

    <!-- お問い合わせセクション -->
    <section id="contact" class="contact-section">
        <div class="contact-container">
            <div class="contact-content">
                <div class="section-header">
                    <span class="section-label">Contact</span>
                    <h2 class="section-title">入会＆体験レッスンの申込</h2>
                </div>

                <p class="contact-description">
                    当スクールに興味をお持ちいただきありがとうございます。テニスを通じて健康づくりや技術向上を目指していきたいと思います。どうぞよろしくお願いいたします。
                </p>


                <p class="contact-description">
                    お問合せにつきましては下記フォーム、または<a href="tel:03-3775-9711">お電話</a>にてお願い致します。
                </p>

                <!-- 2カラムレイアウト -->
                <div class="contact-form-wrapper">
                        <form id="home-contact-form" class="home-contact-form">
                            <div class="form-group">
                                <label for="contact-name">
                                    お名前<span class="required-badge">必須</span>
                                </label>
                                <input type="text" id="contact-name" name="name" required placeholder="例：山田 太郎">
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
                                <label for="contact-address">住所</label>
                                <input type="text" id="contact-address" name="address" placeholder="例：東京都大田区大森北1-2-3">
                            </div>

                            <div class="form-group">
                                <label for="contact-phone">電話番号</label>
                                <input type="tel" id="contact-phone" name="phone" placeholder="例：03-1234-5678">
                            </div>

                            <div class="form-group">
                                <label for="contact-email">
                                    メールアドレス<span class="required-badge">必須</span>
                                </label>
                                <input type="email" id="contact-email" name="email" required placeholder="例：example@email.com">
                            </div>

                            <div class="form-group">
                                <label for="contact-comment">コメント</label>
                                <textarea id="contact-comment" name="comment" rows="5" placeholder="お問い合わせ内容をご記入ください"></textarea>
                            </div>

                            <div class="form-submit">
                                <button type="submit" class="btn btn-primary btn-large" id="contact-submit-btn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" fill="currentColor"/>
                                    </svg>
                                    <span>送信する</span>
                                </button>
                            </div>

                            <div id="form-message" class="form-message" style="display: none;"></div>
                        </form>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- スクロールアニメーション用スクリプト -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // スムーススクロール
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // パララックス効果を削除（不要になったためコメントアウト）
    // window.addEventListener('scroll', function() {
    //     const scrolled = window.pageYOffset;
    //     const parallax = document.querySelector('[data-parallax]');
    //     if (parallax) {
    //         const speed = 0.5;
    //         parallax.style.transform = 'translateY(' + (scrolled * speed) + 'px)';
    //     }
    // });

    // AOSアニメーションは削除済み

    // 施設案内カルーセル
    const carousel = document.querySelector('.facilities-carousel');
    if (carousel) {
        const track = carousel.querySelector('.carousel-track');
        const slides = Array.from(track.querySelectorAll('.facility-slide'));
        const prevBtn = document.querySelector('.carousel-btn.prev');
        const nextBtn = document.querySelector('.carousel-btn.next');
        const indicators = Array.from(document.querySelectorAll('.indicator'));

        let currentIndex = 0;
        let autoSlideInterval;
        const slideInterval = 5000; // 5秒ごとに自動スクロール

        // スライドを移動
        function goToSlide(index) {
            if (index < 0) {
                currentIndex = slides.length - 1;
            } else if (index >= slides.length) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }

            const slideWidth = slides[0].getBoundingClientRect().width;
            track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

            // インジケーターの更新
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === currentIndex);
            });
        }

        // 次のスライドへ
        function nextSlide() {
            goToSlide(currentIndex + 1);
        }

        // 前のスライドへ
        function prevSlide() {
            goToSlide(currentIndex - 1);
        }

        // 自動スクロールを開始
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, slideInterval);
        }

        // 自動スクロールを停止
        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // イベントリスナー
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoSlide();
            startAutoSlide(); // 再開
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoSlide();
            startAutoSlide(); // 再開
        });

        // インジケーターをクリック
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                goToSlide(index);
                stopAutoSlide();
                startAutoSlide(); // 再開
            });
        });

        // マウスホバーで一時停止
        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);

        // ウィンドウリサイズ時に位置を再計算
        window.addEventListener('resize', () => {
            goToSlide(currentIndex);
        });

        // 自動スクロール開始
        startAutoSlide();
    }

    // お問い合わせフォームの送信処理
    const contactForm = document.getElementById('home-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('contact-submit-btn');
            const formMessage = document.getElementById('form-message');
            const originalBtnText = submitBtn.innerHTML;

            // ボタンを無効化してローディング表示
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>送信中...</span>';
            formMessage.style.display = 'none';

            // フォームデータを収集
            const formData = new FormData(contactForm);
            formData.append('action', 'omori_contact_form');
            formData.append('nonce', '<?php echo wp_create_nonce('omori_contact_nonce'); ?>');

            // AJAXでフォーム送信
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    formMessage.className = 'form-message success';
                    formMessage.textContent = data.data.message;
                    formMessage.style.display = 'block';
                    contactForm.reset();
                } else {
                    formMessage.className = 'form-message error';
                    formMessage.textContent = data.data.message || 'エラーが発生しました。もう一度お試しください。';
                    formMessage.style.display = 'block';
                }
            })
            .catch(error => {
                formMessage.className = 'form-message error';
                formMessage.textContent = '送信に失敗しました。もう一度お試しください。';
                formMessage.style.display = 'block';
            })
            .finally(() => {
                // ボタンを再度有効化
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }
});
</script>

<?php get_footer(); ?>