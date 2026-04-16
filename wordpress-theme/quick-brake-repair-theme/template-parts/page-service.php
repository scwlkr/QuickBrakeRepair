<?php
/**
 * Premium and standard service template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$secondary_title = (isset($page['slug']) ? (string) $page['slug'] : '') === 'premium'
    ? __('Premium extras', 'quick-brake-repair-theme')
    : __('What to expect', 'quick-brake-repair-theme');

qbr_render_page_hero(
    '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : '',
    array(
        array('value' => __('On-site', 'quick-brake-repair-theme'), 'label' => __('appointments across Dallas', 'quick-brake-repair-theme')),
        array('value' => __('All vehicle types', 'quick-brake-repair-theme'), 'label' => __('cars, trucks, SUVs, vans', 'quick-brake-repair-theme')),
        array('value' => __('Quote first', 'quick-brake-repair-theme'), 'label' => __('before scheduling', 'quick-brake-repair-theme')),
    )
);

qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
?>
<section class="panel shell">
    <div class="section-heading">
        <h2><?php echo esc_html((string) $page['includedHeading']); ?></h2>
    </div>
    <div class="split-grid">
        <article class="card">
            <h3><?php esc_html_e('Core repair work', 'quick-brake-repair-theme'); ?></h3>
            <p><?php echo esc_html(isset($page['includedParagraphs'][0]) ? (string) $page['includedParagraphs'][0] : ''); ?></p>
            <?php qbr_render_checklist((array) $page['standardList']); ?>
        </article>
        <article class="card">
            <h3><?php echo esc_html($secondary_title); ?></h3>
            <p><?php echo esc_html((string) $page['outro']); ?></p>
            <?php qbr_render_checklist((array) $page['premiumList']); ?>
        </article>
    </div>
</section>
