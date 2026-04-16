<?php
/**
 * Areas we serve template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();

qbr_render_page_hero(
    isset($page['eyebrow']) ? (string) $page['eyebrow'] : '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''
);

qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
?>
<section class="qbr-section">
    <div class="qbr-shell">
        <div class="qbr-section-heading">
            <p class="qbr-eyebrow"><?php esc_html_e('Service Area Pages', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Preserved city URLs with cleaner navigation', 'quick-brake-repair-theme'); ?></h2>
        </div>
        <?php qbr_render_card_grid(qbr_get_service_area_card_items(), __('View service area', 'quick-brake-repair-theme')); ?>
    </div>
</section>

