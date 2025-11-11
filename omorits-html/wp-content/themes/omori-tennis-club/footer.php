<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-info">
            <h3 style="margin-bottom: 1rem; font-size: 1.3rem;"><?php bloginfo('name'); ?></h3>
            <p style="margin-bottom: 0.5rem; opacity: 0.9;">〒143-0016 東京都大田区山王2-24-12</p>
            <p style="margin-bottom: 0.5rem; opacity: 0.9;">TEL/FAX: 03-3775-9711</p>
            <p style="margin-bottom: 0.5rem; opacity: 0.9;">営業時間: 9:00-17:00</p>
        </div>

        <?php
        if (is_active_sidebar('footer-1')) :
            ?>
            <div class="footer-widgets" style="margin-top: 2rem;">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        <?php endif; ?>

        <div class="footer-bottom" style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.2);">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
