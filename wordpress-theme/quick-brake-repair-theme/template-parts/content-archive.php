<?php
/**
 * Archive loop template.
 *
 * @package QuickBrakeRepairTheme
 */

$eyebrow = isset($args['eyebrow']) ? (string) $args['eyebrow'] : __('Resources', 'quick-brake-repair-theme');
$title   = isset($args['title']) ? (string) $args['title'] : __('Browse content', 'quick-brake-repair-theme');
$summary = isset($args['summary']) ? (string) $args['summary'] : __('Browse articles, updates, and related content.', 'quick-brake-repair-theme');
?>
<section class="qbr-hero qbr-hero--simple">
    <div class="qbr-shell qbr-hero__grid qbr-hero__grid--simple">
        <div class="qbr-hero__content">
            <p class="qbr-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h1><?php echo esc_html($title); ?></h1>
            <p class="qbr-hero__summary"><?php echo esc_html($summary); ?></p>
        </div>
    </div>
</section>
<section class="qbr-section">
    <div class="qbr-shell">
        <?php if (have_posts()) : ?>
            <div class="qbr-card-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article <?php post_class('qbr-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a class="qbr-card__image" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
                        <?php endif; ?>
                        <p class="qbr-card__eyebrow"><?php echo esc_html(get_the_date()); ?></p>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html(get_the_excerpt()); ?></p>
                        <a class="qbr-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'quick-brake-repair-theme'); ?></a>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="qbr-pagination">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <?php get_template_part('template-parts/content', 'none'); ?>
        <?php endif; ?>
    </div>
</section>

