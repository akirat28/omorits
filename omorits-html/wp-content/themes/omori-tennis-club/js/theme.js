/**
 * テーマ用JavaScriptファイル
 * スムーススクロールとその他のインタラクション機能
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // スムーススクロール機能
    function initSmoothScroll() {
        // アンカーリンクをすべて取得
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    // ヘッダーの高さを考慮してオフセットを計算
                    const header = document.querySelector('.site-header');
                    const headerHeight = header ? header.offsetHeight : 80;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    // スムーススクロール実行
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // フォーカスを設定（アクセシビリティ対応）
                    setTimeout(() => {
                        targetElement.focus({ preventScroll: true });
                    }, 500);
                }
            });
        });
    }
    
    // ページ内リンク（#contactなど）のスムーススクロール
    function initPageSmoothScroll() {
        const pageLinks = document.querySelectorAll('a[href^="/#"]');
        
        pageLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // 現在のページと同じドメインの場合のみ処理
                const href = this.getAttribute('href');
                if (href.startsWith('/#')) {
                    e.preventDefault();
                    
                    const targetId = href.substring(2); // '/#' を除去
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        // ヘッダーの高さを考慮
                        const header = document.querySelector('.site-header');
                        const headerHeight = header ? header.offsetHeight : 80;
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        setTimeout(() => {
                            targetElement.focus({ preventScroll: true });
                        }, 500);
                    } else {
                        // 対象要素が見つからない場合はHOMEページに移動
                        window.location.href = href;
                    }
                }
            });
        });
    }
    
    // スクロールアニメーション効果
    function initScrollAnimations() {
        const animatedElements = document.querySelectorAll('.coach-card, .class-card, .benefit-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        // 初期状態を設定
        animatedElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 1.8s ease, transform 1.8s ease';
            observer.observe(element);
        });
    }
    
    // ホバーエフェクトの強化
    function initHoverEffects() {
        const cards = document.querySelectorAll('.coach-card, .class-card, .benefit-card');
        
        cards.forEach(card => {
            card.style.transition = 'transform 0.75s ease, box-shadow 0.75s ease';
            
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.2)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '';
            });
        });
    }
    
    // ページ読み込み時のアニメーション（ヘッダーを除外）
    function initPageLoadAnimation() {
        const mainContent = document.querySelector('.site-main');
        if (mainContent) {
            mainContent.style.opacity = '0';
            mainContent.style.transition = 'opacity 1.5s ease';

            setTimeout(() => {
                mainContent.style.opacity = '1';
            }, 300);
        }
    }
    
    // すべての機能を初期化
    initSmoothScroll();
    initPageSmoothScroll();
    initScrollAnimations();
    initHoverEffects();
    initPageLoadAnimation();
    
    // ページ遷移時のリロード防止（SPA風）
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
});

// 外部リンクのクリックアニメーション
document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (link && link.hostname !== window.location.hostname) {
        link.style.transition = 'opacity 0.75s ease';
        link.style.opacity = '0.7';
        
        setTimeout(() => {
            link.style.opacity = '1';
        }, 750);
    }
});
