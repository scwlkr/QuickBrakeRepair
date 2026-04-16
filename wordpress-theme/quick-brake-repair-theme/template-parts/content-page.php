<?php
/**
 * Generic page content template.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : null;

if (is_array($page)) {
    qbr_render_page_hero(
        isset($page['eyebrow']) ? (string) $page['eyebrow'] : '',
        isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
        isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''
    );
    qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
    return;
}
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('qbr-entry'); ?>>
            <section class="qbr-hero qbr-hero--simple">
                <div class="qbr-shell qbr-hero__grid qbr-hero__grid--simple">
                    <div class="qbr-hero__content">
                        <p class="qbr-eyebrow"><?php esc_html_e('Page', 'quick-brake-repair-theme'); ?></p>
                        <h1><?php the_title(); ?></h1>
                        <?php if (has_excerpt()) : ?>
                            <p class="qbr-hero__summary"><?php echo esc_html(get_the_excerpt()); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <section class="qbr-section">
                <div class="qbr-shell">
                    <div class="qbr-rich-text qbr-rich-text--narrow">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        </article>
    <?php endwhile; ?>
<?php endif; ?>

