<?php
/**
 * Areas we serve template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$service_areas = qbr_get_service_area_pages();

qbr_render_page_hero(
    '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''
);

qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
?>
<section class="panel shell">
    <div class="section-heading">
        <h2><?php esc_html_e('Preserved city URLs, rebuilt with better internal navigation', 'quick-brake-repair-theme'); ?></h2>
    </div>
    <div class="card-grid card-grid--three">
        <?php foreach ($service_areas as $service_area) : ?>
            <article class="card card--city">
                <h3><?php echo esc_html(isset($service_area['heroTitle']) ? (string) $service_area['heroTitle'] : ''); ?></h3>
                <p><?php echo esc_html(isset($service_area['metaDescription']) ? (string) $service_area['metaDescription'] : ''); ?></p>
                <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink((string) $service_area['slug'], 'service_area')); ?>"><?php echo esc_html(sprintf(__('View %s', 'quick-brake-repair-theme'), isset($service_area['title']) ? (string) $service_area['title'] : '')); ?></a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
