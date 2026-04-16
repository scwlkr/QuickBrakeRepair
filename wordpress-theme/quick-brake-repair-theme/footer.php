<?php
/**
 * Theme footer.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

$site           = qbr_get_site_data();
$service_areas  = qbr_get_service_area_pages();
$resource_items = qbr_get_article_pages();
?>
    </main>
    <footer class="qbr-footer">
        <div class="qbr-shell qbr-footer__grid">
            <section>
                <p class="qbr-eyebrow"><?php esc_html_e('Mobile Brake Repair', 'quick-brake-repair-theme'); ?></p>
                <h2><?php esc_html_e('Mobile brake service designed around your day.', 'quick-brake-repair-theme'); ?></h2>
                <p><?php esc_html_e('ASE-certified technicians, on-site repair support, and clear next steps before you drive again.', 'quick-brake-repair-theme'); ?></p>
            </section>
            <section>
                <h2><?php esc_html_e('Contact', 'quick-brake-repair-theme'); ?></h2>
                <ul class="qbr-footer__list">
                    <li><a href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php echo esc_html(isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : ''); ?></a></li>
                    <li><a href="mailto:<?php echo esc_attr(isset($site['emails'][0]) ? (string) $site['emails'][0] : ''); ?>"><?php echo esc_html(isset($site['emails'][0]) ? (string) $site['emails'][0] : ''); ?></a></li>
                    <li><?php echo esc_html(trim((isset($site['city']) ? (string) $site['city'] : '') . ' ' . (isset($site['postalCode']) ? (string) $site['postalCode'] : ''))); ?></li>
                </ul>
            </section>
            <section>
                <h2><?php esc_html_e('Service Areas', 'quick-brake-repair-theme'); ?></h2>
                <ul class="qbr-footer__list">
                    <?php foreach ($service_areas as $service_area) : ?>
                        <li>
                            <a href="<?php echo esc_url(qbr_get_mapped_permalink((string) $service_area['slug'], 'service_area')); ?>">
                                <?php echo esc_html(str_replace(', TX', '', (string) $service_area['title'])); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section>
                <h2><?php esc_html_e('Resources', 'quick-brake-repair-theme'); ?></h2>
                <ul class="qbr-footer__list">
                    <?php foreach (array_slice($resource_items, 0, 4) as $article) : ?>
                        <li>
                            <a href="<?php echo esc_url(qbr_get_mapped_permalink((string) $article['slug'], 'post')); ?>">
                                <?php echo esc_html((string) $article['title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
        <div class="qbr-shell qbr-footer__meta">
            <p><?php esc_html_e('Mon - Sat: 8:00 am - 7:00 pm | Sunday: Closed | Overnight and weekend appointments available', 'quick-brake-repair-theme'); ?></p>
            <p><?php echo esc_html(sprintf(__('Copyright %1$s %2$s. All Rights Reserved.', 'quick-brake-repair-theme'), '©', get_bloginfo('name'))); ?></p>
        </div>
        <a class="qbr-floating-call" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>" aria-label="<?php echo esc_attr(sprintf(__('Call %s', 'quick-brake-repair-theme'), isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '')); ?>">
            <span class="qbr-floating-call__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" focusable="false">
                    <path d="M6.62 10.79a15.06 15.06 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.11.37 2.3.56 3.51.56a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.21.19 2.4.56 3.51a1 1 0 0 1-.24 1.02l-2.2 2.26Z" fill="currentColor"></path>
                </svg>
            </span>
            <span><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '')); ?></span>
        </a>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>

