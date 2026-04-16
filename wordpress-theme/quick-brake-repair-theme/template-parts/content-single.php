<?php
/**
 * Single post content template.
 *
 * @package QuickBrakeRepairTheme
 */

$article = isset($args['article']) && is_array($args['article']) ? $args['article'] : null;

if (is_array($article)) :
    $related = qbr_get_related_service_area_for_article($article);

    qbr_render_page_hero(
        isset($article['eyebrow']) ? (string) $article['eyebrow'] : __('Resource Article', 'quick-brake-repair-theme'),
        isset($article['heroTitle']) ? (string) $article['heroTitle'] : get_the_title(),
        isset($article['heroSummary']) ? (string) $article['heroSummary'] : '',
        array(
            array('value' => isset($article['publishedLabel']) ? (string) $article['publishedLabel'] : '', 'label' => __('published date', 'quick-brake-repair-theme')),
            array('value' => __('Resource', 'quick-brake-repair-theme'), 'label' => __('on-site brake guide', 'quick-brake-repair-theme')),
            array('value' => __('Dallas area', 'quick-brake-repair-theme'), 'label' => __('on-site brake service', 'quick-brake-repair-theme')),
        )
    );
    ?>
    <section class="qbr-section">
        <div class="qbr-shell qbr-section__grid">
            <div class="qbr-section__heading">
                <h2><?php echo esc_html((string) $article['title']); ?></h2>
            </div>
            <div class="qbr-rich-text">
                <p><?php echo esc_html((string) $article['intro']); ?></p>
            </div>
        </div>
    </section>
    <section class="qbr-section qbr-section--article">
        <div class="qbr-shell qbr-article-layout">
            <div class="qbr-article-copy">
                <?php foreach ((array) $article['sections'] as $section) : ?>
                    <article class="qbr-article-block">
                        <h2><?php echo esc_html((string) $section['question']); ?></h2>
                        <div class="qbr-rich-text">
                            <?php qbr_render_paragraphs((array) $section['answer']); ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <aside class="qbr-article-sidebar">
                <div class="qbr-panel qbr-panel--accent">
                    <h2><?php esc_html_e('Get a mobile quote first', 'quick-brake-repair-theme'); ?></h2>
                    <p><?php echo esc_html((string) $article['closing']); ?></p>
                    <a class="qbr-button qbr-button--primary" href="<?php echo esc_url(qbr_get_site_value('phoneHref')); ?>"><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), qbr_get_site_value('phoneDisplay'))); ?></a>
                </div>
                <?php if (is_array($related)) : ?>
                    <div class="qbr-panel">
                        <h2><?php echo esc_html((string) $related['title']); ?></h2>
                        <p><?php echo esc_html((string) $related['metaDescription']); ?></p>
                        <a class="qbr-text-link" href="<?php echo esc_url(qbr_get_mapped_permalink((string) $related['slug'], 'service_area')); ?>"><?php echo esc_html(sprintf(__('Visit %s', 'quick-brake-repair-theme'), (string) $related['title'])); ?></a>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </section>
<?php else : ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('qbr-entry'); ?>>
                <section class="qbr-hero qbr-hero--simple">
                    <div class="qbr-shell qbr-hero__grid qbr-hero__grid--simple">
                        <div class="qbr-hero__content">
                            <p class="qbr-eyebrow"><?php esc_html_e('Article', 'quick-brake-repair-theme'); ?></p>
                            <h1><?php the_title(); ?></h1>
                            <p class="qbr-hero__summary"><?php echo esc_html(get_the_excerpt()); ?></p>
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
                <?php comments_template(); ?>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
<?php endif; ?>

