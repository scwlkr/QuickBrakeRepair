<?php
/**
 * Contact page template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$site = qbr_get_site_data();
?>
<section class="qbr-hero qbr-hero--contact">
    <div class="qbr-shell qbr-contact-hero">
        <div class="qbr-contact-hero__main">
            <p class="qbr-eyebrow"><?php echo esc_html((string) $page['eyebrow']); ?></p>
            <h1><?php echo esc_html((string) $page['heroTitle']); ?></h1>
            <p class="qbr-hero__summary"><?php echo esc_html((string) $page['heroSummary']); ?></p>
            <div class="qbr-hero__actions">
                <a class="qbr-button qbr-button--primary" href="<?php echo esc_url((string) $site['phoneHref']); ?>"><?php esc_html_e('Call Now', 'quick-brake-repair-theme'); ?></a>
                <a class="qbr-button qbr-button--secondary" href="#qbr-contact-form"><?php esc_html_e('Free Quote', 'quick-brake-repair-theme'); ?></a>
            </div>
            <?php
            qbr_render_hero_stats(
                array(
                    array('value' => __('Free quote', 'quick-brake-repair-theme'), 'label' => __('before scheduling', 'quick-brake-repair-theme')),
                    array('value' => __('Mon - Sat', 'quick-brake-repair-theme'), 'label' => __('8:00 am - 7:00 pm', 'quick-brake-repair-theme')),
                    array('value' => __('Mobile-first', 'quick-brake-repair-theme'), 'label' => __('appointments at your location', 'quick-brake-repair-theme')),
                )
            );
            ?>
            <article class="qbr-panel qbr-panel--contact-direct">
                <h2><?php esc_html_e('Talk to Quick Brake Repair', 'quick-brake-repair-theme'); ?></h2>
                <ul class="qbr-contact-list">
                    <li><strong><?php esc_html_e('Call', 'quick-brake-repair-theme'); ?></strong><a href="<?php echo esc_url((string) $site['phoneHref']); ?>"><?php echo esc_html((string) $site['phoneDisplay']); ?></a></li>
                    <li><strong><?php esc_html_e('Email', 'quick-brake-repair-theme'); ?></strong><span><?php echo esc_html(implode(' / ', (array) $site['emails'])); ?></span></li>
                    <li><strong><?php esc_html_e('Location', 'quick-brake-repair-theme'); ?></strong><span><?php echo esc_html((string) $site['city'] . ' ' . (string) $site['postalCode']); ?></span></li>
                    <li><strong><?php esc_html_e('Hours', 'quick-brake-repair-theme'); ?></strong><span><?php esc_html_e('Mon - Sat: 8:00 am - 7:00 pm | Sunday: Closed', 'quick-brake-repair-theme'); ?></span></li>
                </ul>
            </article>
        </div>
        <aside id="qbr-contact-form" class="qbr-panel qbr-panel--form">
            <p class="qbr-eyebrow"><?php esc_html_e('Request a quote', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Share the vehicle issue first', 'quick-brake-repair-theme'); ?></h2>
            <p><?php echo esc_html(isset($page['formNotice']) ? (string) $page['formNotice'] : ''); ?></p>
            <div class="qbr-form-slot">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php if (trim((string) get_the_content())) : ?>
                            <div class="qbr-rich-text">
                                <?php the_content(); ?>
                            </div>
                        <?php else : ?>
                            <div class="qbr-form-placeholder">
                                <p><?php esc_html_e('Add a WordPress.com Form block, shortcode, or embedded form to the Contact page content after upload. This panel is the intended slot for the production form.', 'quick-brake-repair-theme'); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</section>
<section class="qbr-section">
    <div class="qbr-shell qbr-section__grid qbr-section__grid--media">
        <div class="qbr-section__heading">
            <h2><?php echo esc_html((string) $page['introHeading']); ?></h2>
        </div>
        <div class="qbr-rich-text">
            <?php qbr_render_paragraphs((array) $page['introParagraphs']); ?>
        </div>
        <figure class="qbr-media-card">
            <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/contact-tech.jpeg')); ?>" alt="<?php esc_attr_e('Quick Brake Repair technician working at a customer location', 'quick-brake-repair-theme'); ?>">
        </figure>
    </div>
</section>

