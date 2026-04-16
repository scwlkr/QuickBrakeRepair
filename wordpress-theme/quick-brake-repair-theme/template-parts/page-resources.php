<?php
/**
 * Resources landing page template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$articles = qbr_get_article_pages();

qbr_render_page_hero(
    '',
    isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title(),
    isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''
);

qbr_render_text_section((string) $page['introHeading'], (array) $page['introParagraphs']);
?>
<section class="panel shell">
    <div class="section-heading">
        <h2><?php esc_html_e('Browse brake repair guides by topic', 'quick-brake-repair-theme'); ?></h2>
    </div>
    <div class="card-grid card-grid--three">
        <?php foreach ($articles as $article) : ?>
            <article class="card card--resource">
                <p class="card__meta"><?php echo esc_html(isset($article['publishedLabel']) ? (string) $article['publishedLabel'] : ''); ?></p>
                <h3><?php echo esc_html(isset($article['title']) ? (string) $article['title'] : ''); ?></h3>
                <p><?php echo esc_html(isset($article['metaDescription']) ? (string) $article['metaDescription'] : ''); ?></p>
                <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink((string) $article['slug'], 'post')); ?>"><?php esc_html_e('Read resource', 'quick-brake-repair-theme'); ?></a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<section class="panel shell">
    <div class="section-heading">
        <span class="eyebrow"><?php esc_html_e('FAQ', 'quick-brake-repair-theme'); ?></span>
        <h2><?php esc_html_e('Common mobile brake service questions', 'quick-brake-repair-theme'); ?></h2>
        <p><?php esc_html_e('Use these quick answers to understand what to expect before scheduling an on-site appointment.', 'quick-brake-repair-theme'); ?></p>
    </div>
    <?php qbr_render_faq_items(isset($page['faqItems']) ? (array) $page['faqItems'] : array()); ?>
</section>
