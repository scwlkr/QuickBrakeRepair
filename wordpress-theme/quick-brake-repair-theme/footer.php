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
$site_name      = isset($site['name']) ? (string) $site['name'] : get_bloginfo('name');
$site_phone_display = isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '';
$site_phone_href    = isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#';
$site_email         = isset($site['emails'][0]) ? (string) $site['emails'][0] : '';
$site_address       = trim((isset($site['city']) ? (string) $site['city'] : '') . ' ' . (isset($site['postalCode']) ? (string) $site['postalCode'] : ''));
$footer_resource_limit = isset($site['footerResourceLimit']) ? absint($site['footerResourceLimit']) : 4;
$footer_service_labels = array(
    __('Brake Inspection', 'quick-brake-repair-theme'),
    __('Brake Pad Replacement', 'quick-brake-repair-theme'),
    __('Brake Caliper Replacement', 'quick-brake-repair-theme'),
    __('Brake Hose Replacement', 'quick-brake-repair-theme'),
    __('Mobile Brake Repair', 'quick-brake-repair-theme'),
);
$footer_resource_labels = array(
    'mobile-brake-repair-in-dallas-tx-fast-service-at-your-location' => __('Mobile Brake Repair', 'quick-brake-repair-theme'),
    'brake-pad-replacement-in-plano-tx-what-every-driver-should-know' => __('Brake Pad Replacement', 'quick-brake-repair-theme'),
    'brake-hose-replacement-in-irving-tx-ensuring-safe-fluid-flow' => __('Brake Hose Replacement', 'quick-brake-repair-theme'),
    'brake-caliper-replacement-in-richardson-tx-restoring-braking-power' => __('Brake Caliper Replacement', 'quick-brake-repair-theme'),
    'comprehensive-brake-inspection-services-in-garland-tx-for-vehicle-safety' => __('Brake Inspection Guide', 'quick-brake-repair-theme'),
    'brake-fluid-service-in-mesquite-tx-maintaining-hydraulic-performance' => __('Brake Fluid Service', 'quick-brake-repair-theme'),
);
$footer_resource_links = array();
$footer_hours_primary  = array();
$footer_hours_note     = '';
$footer_bottom_links   = array();
$call_button_label     = $site_phone_display ? sprintf(__('Call %s', 'quick-brake-repair-theme'), $site_phone_display) : __('Call Now', 'quick-brake-repair-theme');
$privacy_policy_url    = function_exists('get_privacy_policy_url') ? get_privacy_policy_url() : '';

foreach (array_slice($resource_items, 0, $footer_resource_limit) as $article) {
    $article_slug = isset($article['slug']) ? (string) $article['slug'] : '';

    if ('' === $article_slug) {
        continue;
    }

    $footer_resource_links[] = array(
        'label' => isset($footer_resource_labels[$article_slug]) ? $footer_resource_labels[$article_slug] : (isset($article['title']) ? (string) $article['title'] : qbr_slug_label($article_slug)),
        'url'   => qbr_get_mapped_permalink($article_slug, 'post'),
    );
}

if (isset($site['hours']) && is_array($site['hours'])) {
    foreach ($site['hours'] as $hour_item) {
        $hour_label = isset($hour_item['label']) ? trim((string) $hour_item['label']) : '';
        $hour_value = isset($hour_item['value']) ? trim((string) $hour_item['value']) : '';

        if ('' === $hour_value) {
            continue;
        }

        if ('special' === strtolower($hour_label)) {
            $footer_hours_note = $hour_value;
            continue;
        }

        $footer_hours_primary[] = $hour_label ? $hour_label . ': ' . $hour_value : $hour_value;
    }
}

if (! empty($privacy_policy_url)) {
    $footer_bottom_links[] = array(
        'label' => __('Privacy Policy', 'quick-brake-repair-theme'),
        'url'   => $privacy_policy_url,
    );
}

$footer_bottom_links[] = array(
    'label' => __('Contact', 'quick-brake-repair-theme'),
    'url'   => qbr_get_mapped_permalink('contact', 'page'),
);

if (function_exists('wp_sitemaps_get_server')) {
    $footer_bottom_links[] = array(
        'label' => __('Sitemap', 'quick-brake-repair-theme'),
        'url'   => home_url('/wp-sitemap.xml'),
    );
}
?>
    </main>
    <footer class="site-footer">
        <div class="shell site-footer__inner">
            <section class="site-footer__cta" aria-labelledby="footer-cta-title">
                <div class="site-footer__cta-content">
                    <h2 id="footer-cta-title" class="site-footer__cta-title"><?php echo esc_html($site_name); ?></h2>
                    <p class="site-footer__cta-copy"><?php esc_html_e('Mobile brake repair that comes to your home, workplace, or parking area across Dallas and nearby cities.', 'quick-brake-repair-theme'); ?></p>
                </div>
                <div class="site-footer__cta-actions">
                    <a class="button button--primary" href="<?php echo esc_url($site_phone_href); ?>"><?php echo esc_html($call_button_label); ?></a>
                    <a class="site-footer__cta-link" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Contact Us', 'quick-brake-repair-theme'); ?></a>
                </div>
            </section>

            <div class="site-footer__main">
                <section class="site-footer__column site-footer__column--brand">
                    <h3 class="site-footer__heading"><?php esc_html_e('About', 'quick-brake-repair-theme'); ?></h3>
                    <p class="site-footer__brand-name"><?php echo esc_html($site_name); ?></p>
                    <p class="site-footer__body-copy"><?php esc_html_e('ASE-certified mobile brake service focused on clear diagnosis, on-site repair, and convenient scheduling across the Dallas area.', 'quick-brake-repair-theme'); ?></p>
                </section>

                <section class="site-footer__column">
                    <h3 class="site-footer__heading"><?php esc_html_e('Contact', 'quick-brake-repair-theme'); ?></h3>
                    <ul class="site-footer__contact-list" role="list">
                        <?php if ($site_phone_display) : ?>
                            <li>
                                <span class="site-footer__meta-label"><?php esc_html_e('Phone', 'quick-brake-repair-theme'); ?></span>
                                <a class="site-footer__contact-value" href="<?php echo esc_url($site_phone_href); ?>"><?php echo esc_html($site_phone_display); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($site_email) : ?>
                            <li>
                                <span class="site-footer__meta-label"><?php esc_html_e('Email', 'quick-brake-repair-theme'); ?></span>
                                <a class="site-footer__contact-value" href="mailto:<?php echo esc_attr($site_email); ?>"><?php echo esc_html($site_email); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($site_address) : ?>
                            <li>
                                <span class="site-footer__meta-label"><?php esc_html_e('Location', 'quick-brake-repair-theme'); ?></span>
                                <span class="site-footer__contact-value"><?php echo esc_html($site_address); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if (! empty($footer_hours_primary) || $footer_hours_note) : ?>
                            <li>
                                <span class="site-footer__meta-label"><?php esc_html_e('Hours', 'quick-brake-repair-theme'); ?></span>
                                <div class="site-footer__hours">
                                    <?php foreach ($footer_hours_primary as $hours_line) : ?>
                                        <span class="site-footer__contact-value"><?php echo esc_html($hours_line); ?></span>
                                    <?php endforeach; ?>
                                    <?php if ($footer_hours_note) : ?>
                                        <span class="site-footer__hours-note"><?php echo esc_html($footer_hours_note); ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </section>

                <section class="site-footer__column">
                    <h3 class="site-footer__heading"><?php esc_html_e('Services', 'quick-brake-repair-theme'); ?></h3>
                    <ul class="site-footer__list site-footer__list--static" role="list">
                        <?php foreach ($footer_service_labels as $service_label) : ?>
                            <li><?php echo esc_html($service_label); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <section class="site-footer__column">
                    <h3 class="site-footer__heading"><?php esc_html_e('Areas We Serve', 'quick-brake-repair-theme'); ?></h3>
                    <ul class="site-footer__list" role="list">
                        <?php foreach ($service_areas as $service_area) : ?>
                            <li>
                                <a href="<?php echo esc_url(qbr_get_mapped_permalink((string) $service_area['slug'], 'service_area')); ?>">
                                    <?php echo esc_html(str_replace(', TX', '', (string) $service_area['title'])); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <section class="site-footer__column">
                    <h3 class="site-footer__heading"><?php esc_html_e('Resources', 'quick-brake-repair-theme'); ?></h3>
                    <ul class="site-footer__list" role="list">
                        <?php foreach ($footer_resource_links as $article_link) : ?>
                            <li>
                                <a href="<?php echo esc_url((string) $article_link['url']); ?>">
                                    <?php echo esc_html((string) $article_link['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </div>

            <div class="site-footer__bottom">
                <p class="site-footer__copyright"><?php echo esc_html(sprintf(__('Copyright %1$s %2$s. All rights reserved.', 'quick-brake-repair-theme'), '© ' . date_i18n('Y'), $site_name)); ?></p>
                <?php if (! empty($footer_bottom_links)) : ?>
                    <nav class="site-footer__bottom-nav" aria-label="<?php esc_attr_e('Footer utility links', 'quick-brake-repair-theme'); ?>">
                        <ul class="site-footer__bottom-links" role="list">
                            <?php foreach ($footer_bottom_links as $footer_link) : ?>
                                <li>
                                    <a href="<?php echo esc_url((string) $footer_link['url']); ?>">
                                        <?php echo esc_html((string) $footer_link['label']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
        <a class="floating-call" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>" aria-label="<?php echo esc_attr(sprintf(__('Call %s', 'quick-brake-repair-theme'), isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '')); ?>">
            <span class="floating-call__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" focusable="false">
                    <path d="M6.62 10.79a15.06 15.06 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.11.37 2.3.56 3.51.56a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.21.19 2.4.56 3.51a1 1 0 0 1-.24 1.02l-2.2 2.26Z" fill="currentColor"></path>
                </svg>
            </span>
            <span class="floating-call__text"><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '')); ?></span>
        </a>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
