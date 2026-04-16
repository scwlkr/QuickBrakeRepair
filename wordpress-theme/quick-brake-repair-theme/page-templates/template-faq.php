<?php
/**
 * Template Name: FAQ Page
 *
 * Dedicated FAQ template for the WordPress rebuild.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();

$faq = qbr_get_faq_page_data();

qbr_render_page_hero(
    '',
    isset($faq['heroTitle']) ? (string) $faq['heroTitle'] : get_the_title(),
    isset($faq['heroSummary']) ? (string) $faq['heroSummary'] : '',
    array(
        array(
            'value' => __('Quick answers', 'quick-brake-repair-theme'),
            'label' => __('for common service questions', 'quick-brake-repair-theme'),
        ),
        array(
            'value' => __('Dallas area', 'quick-brake-repair-theme'),
            'label' => __('mobile support', 'quick-brake-repair-theme'),
        ),
    )
);

if (! empty($faq['introHeading'])) {
    qbr_render_text_section((string) $faq['introHeading'], isset($faq['introParagraphs']) ? (array) $faq['introParagraphs'] : array());
}
?>
<section class="panel shell">
    <div class="content-stack">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php if (trim((string) get_the_content())) : ?>
                    <div class="content-stack">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php qbr_render_faq_items(isset($faq['items']) ? (array) $faq['items'] : array()); ?>
    </div>
</section>
<?php
get_footer();
