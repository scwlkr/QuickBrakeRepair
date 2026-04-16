<?php
/**
 * Single post content template.
 *
 * @package QuickBrakeRepairTheme
 */

$article = isset($args['article']) && is_array($args['article']) ? $args['article'] : null;
$site = qbr_get_site_data();

if (is_array($article)) :
    $related = qbr_get_related_service_area_for_article($article);

    qbr_render_page_hero(
        '',
        isset($article['heroTitle']) ? (string) $article['heroTitle'] : get_the_title(),
        isset($article['heroSummary']) ? (string) $article['heroSummary'] : '',
        array(
            array('value' => isset($article['publishedLabel']) ? (string) $article['publishedLabel'] : '', 'label' => __('published date', 'quick-brake-repair-theme')),
            array('value' => __('Resource', 'quick-brake-repair-theme'), 'label' => __('on-site brake guide', 'quick-brake-repair-theme')),
            array('value' => __('Dallas area', 'quick-brake-repair-theme'), 'label' => __('on-site brake service', 'quick-brake-repair-theme')),
        )
    );
    ?>
    <section class="content-section shell">
        <div class="section-heading">
            <h2><?php echo esc_html((string) $article['title']); ?></h2>
        </div>
        <div class="content-stack">
            <p><?php echo esc_html((string) $article['intro']); ?></p>
        </div>
    </section>
    <section class="article-layout shell">
        <div class="article-copy">
            <?php foreach ((array) $article['sections'] as $section) : ?>
                <article class="article-block">
                    <h2><?php echo esc_html(isset($section['question']) ? (string) $section['question'] : ''); ?></h2>
                    <?php qbr_render_paragraphs(isset($section['answer']) ? (array) $section['answer'] : array()); ?>
                </article>
            <?php endforeach; ?>
        </div>
        <aside class="article-sidebar">
            <div class="card">
                <h2><?php esc_html_e('Get a mobile quote first', 'quick-brake-repair-theme'); ?></h2>
                <p><?php echo esc_html((string) $article['closing']); ?></p>
                <a class="button button--primary" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : '')); ?></a>
            </div>
            <?php if (is_array($related)) : ?>
                <div class="card">
                    <h2><?php echo esc_html((string) $related['title']); ?></h2>
                    <p><?php echo esc_html((string) $related['metaDescription']); ?></p>
                    <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink((string) $related['slug'], 'service_area')); ?>"><?php echo esc_html(sprintf(__('Visit %s', 'quick-brake-repair-theme'), (string) $related['title'])); ?></a>
                </div>
            <?php endif; ?>
        </aside>
    </section>
<?php else : ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php
            qbr_render_page_hero('', get_the_title(), has_excerpt() ? get_the_excerpt() : '');
            ?>
            <section class="content-section shell">
                <div class="content-stack">
                    <?php the_content(); ?>
                </div>
            </section>
            <?php comments_template(); ?>
        <?php endwhile; ?>
    <?php endif; ?>
<?php endif; ?>
