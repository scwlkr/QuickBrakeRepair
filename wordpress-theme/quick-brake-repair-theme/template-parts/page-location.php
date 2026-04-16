<?php
/**
 * Service area template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$related = qbr_get_related_article_for_service_area($page);
$site = qbr_get_site_data();

qbr_render_page_hero(
    '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : '',
    array(
        array('value' => str_replace(', TX', '', isset($page['title']) ? (string) $page['title'] : ''), 'label' => __('on-site service area', 'quick-brake-repair-theme')),
        array('value' => __('On-site', 'quick-brake-repair-theme'), 'label' => __('repair and diagnostic work', 'quick-brake-repair-theme')),
        array('value' => __('Upfront', 'quick-brake-repair-theme'), 'label' => __('quote before scheduling', 'quick-brake-repair-theme')),
    )
);

qbr_render_text_section((string) $page['overviewHeading'], (array) $page['overviewParagraphs']);
qbr_render_text_section((string) $page['detailHeading'], (array) $page['detailParagraphs']);
?>
<section class="panel shell">
    <div class="split-grid">
        <article class="card">
            <h2><?php echo esc_html((string) $page['bulletHeading']); ?></h2>
            <?php qbr_render_checklist((array) $page['bullets']); ?>
        </article>
        <article class="card">
            <h2><?php esc_html_e('Talk through the symptoms before you drive farther', 'quick-brake-repair-theme'); ?></h2>
            <p><?php echo esc_html((string) $page['closing']); ?></p>
            <a class="button button--primary" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '')); ?></a>
            <?php if (is_array($related)) : ?>
                <div class="related-links">
                    <h3><?php esc_html_e('Related resources', 'quick-brake-repair-theme'); ?></h3>
                    <ul class="footer-list">
                        <li><a href="<?php echo esc_url(qbr_get_mapped_permalink((string) $related['slug'], 'post')); ?>"><?php echo esc_html((string) $related['title']); ?></a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </article>
    </div>
</section>
