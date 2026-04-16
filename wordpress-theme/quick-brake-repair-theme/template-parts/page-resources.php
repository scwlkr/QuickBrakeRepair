<?php
/**
 * Resources landing page template part.
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
            <p class="qbr-eyebrow"><?php esc_html_e('Article Library', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Browse brake repair guides by topic', 'quick-brake-repair-theme'); ?></h2>
        </div>
        <?php qbr_render_card_grid(qbr_get_article_card_items(), __('Read resource', 'quick-brake-repair-theme')); ?>
    </div>
</section>
<section class="qbr-section qbr-section--faq">
    <div class="qbr-shell">
        <div class="qbr-section-heading">
            <p class="qbr-eyebrow"><?php esc_html_e('FAQ', 'quick-brake-repair-theme'); ?></p>
            <h2><?php esc_html_e('Common mobile brake service questions', 'quick-brake-repair-theme'); ?></h2>
            <p><?php esc_html_e('Use these quick answers to understand what to expect before scheduling an on-site appointment.', 'quick-brake-repair-theme'); ?></p>
        </div>
        <?php qbr_render_faq_items(isset($page['faqItems']) ? (array) $page['faqItems'] : array()); ?>
    </div>
</section>

