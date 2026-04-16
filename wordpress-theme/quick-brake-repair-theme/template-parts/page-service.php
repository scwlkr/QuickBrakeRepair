<?php
/**
 * Premium and standard service template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();

qbr_render_page_hero(
    isset($page['eyebrow']) ? (string) $page['eyebrow'] : '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : '',
    array(
        array('value' => __('On-site', 'quick-brake-repair-theme'), 'label' => __('appointments across Dallas', 'quick-brake-repair-theme')),
        array('value' => __('All vehicle types', 'quick-brake-repair-theme'), 'label' => __('cars, trucks, SUVs, and vans', 'quick-brake-repair-theme')),
        array('value' => __('Quote first', 'quick-brake-repair-theme'), 'label' => __('before scheduling', 'quick-brake-repair-theme')),
    )
);

qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
?>
<section class="qbr-section">
    <div class="qbr-shell qbr-two-column">
        <article class="qbr-panel">
            <p class="qbr-eyebrow"><?php esc_html_e('Included', 'quick-brake-repair-theme'); ?></p>
            <h2><?php echo esc_html((string) $page['includedHeading']); ?></h2>
            <div class="qbr-rich-text">
                <?php qbr_render_paragraphs((array) $page['includedParagraphs']); ?>
                <?php qbr_render_checklist((array) $page['standardList']); ?>
            </div>
        </article>
        <article class="qbr-panel qbr-panel--accent">
            <p class="qbr-eyebrow"><?php echo esc_html('premium' === $page['slug'] ? __('Premium extras', 'quick-brake-repair-theme') : __('What to expect', 'quick-brake-repair-theme')); ?></p>
            <h2><?php echo esc_html((string) $page['heroTitle']); ?></h2>
            <div class="qbr-rich-text">
                <p><?php echo esc_html((string) $page['outro']); ?></p>
                <?php qbr_render_checklist((array) $page['premiumList']); ?>
            </div>
        </article>
    </div>
</section>
<?php
qbr_render_cta_band(
    __('Book mobile brake service without the shop delay.', 'quick-brake-repair-theme'),
    __('Call first for a quote, then confirm the service path that fits your vehicle symptoms and schedule.', 'quick-brake-repair-theme')
);

