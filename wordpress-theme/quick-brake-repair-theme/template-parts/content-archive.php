<?php
/**
 * Archive loop template.
 *
 * @package QuickBrakeRepairTheme
 */

$eyebrow = isset($args['eyebrow']) ? (string) $args['eyebrow'] : __('Resources', 'quick-brake-repair-theme');
$title   = isset($args['title']) ? (string) $args['title'] : __('Browse content', 'quick-brake-repair-theme');
$summary = isset($args['summary']) ? (string) $args['summary'] : __('Browse articles, updates, and related content.', 'quick-brake-repair-theme');

qbr_render_page_hero($eyebrow, $title, $summary);
?>
<section class="panel shell">
    <div class="section-heading">
        <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
        <h2><?php echo esc_html($title); ?></h2>
        <p><?php echo esc_html($summary); ?></p>
    </div>
    <?php if (have_posts()) : ?>
        <div class="card-grid card-grid--three">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('card card--resource'); ?>>
                    <p class="card__meta"><?php echo esc_html(get_the_date()); ?></p>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                    <a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'quick-brake-repair-theme'); ?></a>
                </article>
            <?php endwhile; ?>
        </div>
        <div class="content-section shell">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>
</section>
