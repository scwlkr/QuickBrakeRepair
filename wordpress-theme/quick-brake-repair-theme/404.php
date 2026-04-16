<?php
/**
 * 404 template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();
?>
<section class="qbr-hero qbr-hero--simple">
    <div class="qbr-shell qbr-hero__grid qbr-hero__grid--simple">
        <div class="qbr-hero__content">
            <p class="qbr-eyebrow"><?php esc_html_e('404', 'quick-brake-repair-theme'); ?></p>
            <h1><?php esc_html_e('This page is not available.', 'quick-brake-repair-theme'); ?></h1>
            <p class="qbr-hero__summary"><?php esc_html_e('Use the main service links below or call Quick Brake Repair directly if you were trying to reach a service page or resource article.', 'quick-brake-repair-theme'); ?></p>
            <div class="qbr-hero__actions">
                <a class="qbr-button qbr-button--primary" href="<?php echo esc_url(qbr_get_site_value('phoneHref')); ?>"><?php esc_html_e('Call Now', 'quick-brake-repair-theme'); ?></a>
                <a class="qbr-button qbr-button--secondary" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Return Home', 'quick-brake-repair-theme'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="qbr-section">
    <div class="qbr-shell">
        <div class="qbr-card-grid">
            <article class="qbr-card">
                <h2><?php esc_html_e('Core Pages', 'quick-brake-repair-theme'); ?></h2>
                <p><?php esc_html_e('Jump back to the primary business pages.', 'quick-brake-repair-theme'); ?></p>
                <a class="qbr-text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('areas-we-serve', 'page')); ?>"><?php esc_html_e('View Areas We Serve', 'quick-brake-repair-theme'); ?></a>
            </article>
            <article class="qbr-card">
                <h2><?php esc_html_e('Resources', 'quick-brake-repair-theme'); ?></h2>
                <p><?php esc_html_e('Browse the brake repair guides preserved from the current site.', 'quick-brake-repair-theme'); ?></p>
                <a class="qbr-text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('resources', 'page')); ?>"><?php esc_html_e('View Resources', 'quick-brake-repair-theme'); ?></a>
            </article>
            <article class="qbr-card">
                <h2><?php esc_html_e('Contact', 'quick-brake-repair-theme'); ?></h2>
                <p><?php esc_html_e('Reach out for a quote or fast service availability.', 'quick-brake-repair-theme'); ?></p>
                <a class="qbr-text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Open Contact Page', 'quick-brake-repair-theme'); ?></a>
            </article>
        </div>
    </div>
</section>
<?php
get_footer();

