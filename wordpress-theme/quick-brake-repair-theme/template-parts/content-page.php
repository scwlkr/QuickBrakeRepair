<?php
/**
 * Generic page content template.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : null;

if (is_array($page)) {
    qbr_render_page_hero(
        '',
        isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
        isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''
    );
    qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
    return;
}
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php qbr_render_page_hero('', get_the_title(), has_excerpt() ? get_the_excerpt() : ''); ?>
        <section class="content-section shell">
            <div class="content-stack">
                <?php the_content(); ?>
            </div>
        </section>
    <?php endwhile; ?>
<?php endif; ?>
