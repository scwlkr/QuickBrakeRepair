<?php
/**
 * Home page template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page          = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$site          = qbr_get_site_data();
$service_areas = qbr_get_service_area_card_items();
$articles      = qbr_get_article_card_items(6);

qbr_render_page_hero(
    isset($page['eyebrow']) ? (string) $page['eyebrow'] : '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_bloginfo('name'),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : '',
    array(
        array('value' => isset($site['yearsServing']) ? (string) $site['yearsServing'] : '', 'label' => __('serving Dallas drivers', 'quick-brake-repair-theme')),
        array('value' => __('Service area', 'quick-brake-repair-theme'), 'label' => __('Dallas and surrounding communities', 'quick-brake-repair-theme')),
        array('value' => __('Same-day', 'quick-brake-repair-theme'), 'label' => __('mobile scheduling when available', 'quick-brake-repair-theme')),
    ),
    true
);
?>
<section class="qbr-section qbr-section--intro">
    <div class="qbr-shell qbr-section__grid qbr-section__grid--media">
        <div class="qbr-section__heading">
            <h2><?php echo esc_html(isset($page['introHeading']) ? (string) $page['introHeading'] : ''); ?></h2>
        </div>
        <div class="qbr-rich-text">
            <?php qbr_render_paragraphs(isset($page['introParagraphs']) ? (array) $page['introParagraphs'] : array()); ?>
        </div>
        <figure class="qbr-media-card qbr-media-card--badge">
            <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/ase-certified.svg')); ?>" alt="<?php esc_attr_e('ASE-certified badge', 'quick-brake-repair-theme'); ?>">
        </figure>
    </div>
</section>
<section class="qbr-section qbr-section--service-comparison">
    <div class="qbr-shell">
        <div class="qbr-section-heading">
            <p class="qbr-eyebrow"><?php esc_html_e('Service Options', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Optimal brakes for optimal performance', 'quick-brake-repair-theme'); ?></h2>
        </div>
        <div class="qbr-service-pane-grid">
            <article class="qbr-service-pane">
                <div class="qbr-service-pane__copy">
                    <p class="qbr-eyebrow"><?php esc_html_e('Premium', 'quick-brake-repair-theme'); ?></p>
                    <h3><?php echo esc_html((string) $page['serviceCards'][0]['title']); ?></h3>
                    <p><?php echo esc_html((string) $page['serviceCards'][0]['body']); ?></p>
                    <a class="qbr-text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('premium', 'page')); ?>"><?php esc_html_e('Explore premium service', 'quick-brake-repair-theme'); ?></a>
                </div>
                <figure class="qbr-service-pane__media">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/service-premium.jpeg')); ?>" alt="<?php esc_attr_e('Premium brake service components', 'quick-brake-repair-theme'); ?>">
                    <figcaption><?php esc_html_e('Premium-grade parts and cleaning', 'quick-brake-repair-theme'); ?></figcaption>
                </figure>
            </article>
            <article class="qbr-service-pane">
                <div class="qbr-service-pane__copy">
                    <p class="qbr-eyebrow"><?php esc_html_e('Standard', 'quick-brake-repair-theme'); ?></p>
                    <h3><?php echo esc_html((string) $page['serviceCards'][1]['title']); ?></h3>
                    <p><?php echo esc_html((string) $page['serviceCards'][1]['body']); ?></p>
                    <a class="qbr-text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('standard', 'page')); ?>"><?php esc_html_e('Explore standard service', 'quick-brake-repair-theme'); ?></a>
                </div>
                <figure class="qbr-service-pane__media">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/service-standard.jpeg')); ?>" alt="<?php esc_attr_e('Standard brake service work', 'quick-brake-repair-theme'); ?>">
                    <figcaption><?php esc_html_e('Pads, rotors, calipers, and hoses', 'quick-brake-repair-theme'); ?></figcaption>
                </figure>
            </article>
        </div>
    </div>
</section>
<section class="qbr-section qbr-section--split">
    <div class="qbr-shell qbr-two-column">
        <article class="qbr-panel">
            <p class="qbr-eyebrow"><?php esc_html_e('Convenience', 'quick-brake-repair-theme'); ?></p>
            <h2><?php echo esc_html(isset($page['convenienceHeading']) ? (string) $page['convenienceHeading'] : ''); ?></h2>
            <div class="qbr-rich-text">
                <?php qbr_render_paragraphs(isset($page['convenienceParagraphs']) ? (array) $page['convenienceParagraphs'] : array()); ?>
                <?php qbr_render_checklist(isset($page['convenienceBullets']) ? (array) $page['convenienceBullets'] : array()); ?>
            </div>
        </article>
        <article class="qbr-panel qbr-panel--dark">
            <p class="qbr-eyebrow"><?php esc_html_e('Safety', 'quick-brake-repair-theme'); ?></p>
            <h2><?php echo esc_html(isset($page['safetyHeading']) ? (string) $page['safetyHeading'] : ''); ?></h2>
            <div class="qbr-rich-text">
                <?php qbr_render_paragraphs(isset($page['safetyParagraphs']) ? (array) $page['safetyParagraphs'] : array()); ?>
            </div>
        </article>
    </div>
</section>
<section class="qbr-section qbr-section--coverage">
    <div class="qbr-shell">
        <div class="qbr-section-heading">
            <p class="qbr-eyebrow"><?php esc_html_e('Coverage', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Serving drivers where the vehicle already is', 'quick-brake-repair-theme'); ?></h2>
        </div>
        <?php qbr_render_card_grid($service_areas, __('View city page', 'quick-brake-repair-theme'), 'qbr-card-grid--coverage'); ?>
    </div>
</section>
<section class="qbr-section qbr-section--reviews">
    <div class="qbr-shell qbr-review-layout">
        <div class="qbr-review-summary">
            <p class="qbr-eyebrow"><?php echo esc_html(isset($site['reviewHeading']) ? (string) $site['reviewHeading'] : ''); ?></p>
            <h2><?php esc_html_e('Drivers already trust the mobile model', 'quick-brake-repair-theme'); ?></h2>
            <p><?php esc_html_e('Read recent feedback from Dallas-area customers, then open the Google profile to leave a review after service.', 'quick-brake-repair-theme'); ?></p>
            <div class="qbr-review-score">
                <strong><?php echo esc_html(isset($site['reviewRating']) ? (string) $site['reviewRating'] : '5.0'); ?></strong>
                <span aria-hidden="true">★★★★★</span>
            </div>
            <p><?php echo esc_html(isset($site['reviewSummary']) ? (string) $site['reviewSummary'] : ''); ?></p>
            <?php qbr_render_checklist(isset($site['reviewPoints']) ? (array) $site['reviewPoints'] : array()); ?>
            <a class="qbr-button qbr-button--secondary" href="<?php echo esc_url(isset($site['reviewLink']) ? (string) $site['reviewLink'] : '#'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Leave a Google review', 'quick-brake-repair-theme'); ?></a>
        </div>
        <div class="qbr-quote-grid">
            <?php foreach ((array) (isset($site['testimonials']) ? $site['testimonials'] : array()) as $testimonial) : ?>
                <blockquote class="qbr-quote-card">
                    <p><?php echo esc_html('“' . (string) $testimonial['quote'] . '”'); ?></p>
                    <footer><?php echo esc_html((string) $testimonial['author']); ?></footer>
                </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="qbr-section qbr-section--resources">
    <div class="qbr-shell">
        <div class="qbr-section-heading">
            <p class="qbr-eyebrow"><?php esc_html_e('Resources', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Readable answers to common brake questions', 'quick-brake-repair-theme'); ?></h2>
        </div>
        <?php qbr_render_card_grid($articles, __('Read article', 'quick-brake-repair-theme')); ?>
    </div>
</section>

