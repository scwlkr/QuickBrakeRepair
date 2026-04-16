<?php
/**
 * Presentation helpers for the Quick Brake Repair theme.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Get a theme image asset URI.
 *
 * @param string $filename Image filename relative to /assets/images.
 * @return string
 */
function qbr_get_theme_image_uri($filename)
{
    return get_theme_file_uri('/assets/images/' . ltrim((string) $filename, '/'));
}

/**
 * Get the theme logo URL.
 *
 * @return string
 */
function qbr_get_logo_url()
{
    $custom_logo_id = get_theme_mod('custom_logo');

    if ($custom_logo_id) {
        $image = wp_get_attachment_image_src($custom_logo_id, 'full');

        if (is_array($image) && ! empty($image[0])) {
            return $image[0];
        }
    }

    return qbr_get_theme_image_uri('logo.png');
}

/**
 * Render the branded mark.
 *
 * @return string
 */
function qbr_get_brand_markup()
{
    return sprintf(
        '<div class="brand-mark" aria-hidden="true" style="background-image:url(\'%1$s\')"><span class="brand-mark__core"></span><span class="brand-mark__ring brand-mark__ring--one"></span><span class="brand-mark__ring brand-mark__ring--two"></span><span class="brand-mark__slice"></span></div>',
        esc_url(qbr_get_logo_url())
    );
}

/**
 * Check whether a nav item is active.
 *
 * @param string $slug Intended slug.
 * @return bool
 */
function qbr_is_nav_active($slug)
{
    $slug = qbr_normalize_slug($slug);

    if ('' === $slug) {
        return is_front_page();
    }

    if ('areas-we-serve' === $slug) {
        return is_page('areas-we-serve') || is_singular('qbr_service_area');
    }

    if ('resources' === $slug) {
        return is_page('resources') || is_singular('post') || is_home() || is_archive() || is_search();
    }

    return is_page($slug);
}

/**
 * Render the primary navigation markup.
 *
 * @return void
 */
function qbr_render_primary_navigation()
{
    foreach (qbr_get_navigation_items() as $item) {
        $slug   = isset($item['slug']) ? (string) $item['slug'] : '';
        $label  = isset($item['label']) ? (string) $item['label'] : qbr_slug_label($slug);
        $active = qbr_is_nav_active($slug) ? ' is-active' : '';

        printf(
            '<a class="site-nav__link%1$s" href="%2$s">%3$s</a>',
            esc_attr($active),
            esc_url(qbr_get_mapped_permalink($slug, 'page')),
            esc_html($label)
        );
    }
}

/**
 * Render generic hero stats.
 *
 * @param array<int, array<string, string>> $stats Stats array.
 * @return void
 */
function qbr_render_hero_stats($stats)
{
    if (empty($stats)) {
        return;
    }

    echo '<div class="hero-stats">';

    foreach ((array) $stats as $stat) {
        $value = isset($stat['value']) ? (string) $stat['value'] : '';
        $label = isset($stat['label']) ? (string) $stat['label'] : '';

        echo '<div class="hero-stat">';
        echo '<strong>' . esc_html($value) . '</strong>';
        echo '<span>' . esc_html($label) . '</span>';
        echo '</div>';
    }

    echo '</div>';
}

/**
 * Get the shared phone number or site value.
 *
 * @param string $key Data key.
 * @return string
 */
function qbr_get_site_value($key)
{
    $site = qbr_get_site_data();

    return isset($site[$key]) ? (string) $site[$key] : '';
}

/**
 * Render the shared hero support card for interior pages.
 *
 * @return void
 */
function qbr_render_support_card()
{
    ?>
    <aside class="hero-card">
        <?php echo wp_kses_post(qbr_get_brand_markup()); ?>
        <div class="hero-card__copy">
            <strong><?php esc_html_e('On-site diagnostics and repair', 'quick-brake-repair-theme'); ?></strong>
            <p><?php esc_html_e('Brake pads, rotors, calipers, hoses, fluid service, and inspection support without the tow or waiting room.', 'quick-brake-repair-theme'); ?></p>
        </div>
        <dl class="hero-card__facts">
            <div>
                <dt><?php esc_html_e('Coverage', 'quick-brake-repair-theme'); ?></dt>
                <dd><?php echo esc_html(qbr_get_site_value('serviceAreaLabel')); ?></dd>
            </div>
            <div>
                <dt><?php esc_html_e('Hours', 'quick-brake-repair-theme'); ?></dt>
                <dd><?php esc_html_e('Mon - Sat, 8:00 am - 7:00 pm', 'quick-brake-repair-theme'); ?></dd>
            </div>
            <div>
                <dt><?php esc_html_e('Need help fast?', 'quick-brake-repair-theme'); ?></dt>
                <dd><a href="<?php echo esc_url(qbr_get_site_value('phoneHref')); ?>"><?php echo esc_html(qbr_get_site_value('phoneDisplay')); ?></a></dd>
            </div>
        </dl>
    </aside>
    <?php
}

/**
 * Render paragraphs from a mapped array.
 *
 * @param array<int, string> $paragraphs Paragraphs.
 * @return void
 */
function qbr_render_paragraphs($paragraphs)
{
    foreach ((array) $paragraphs as $paragraph) {
        echo '<p>' . esc_html((string) $paragraph) . '</p>';
    }
}

/**
 * Render a checklist.
 *
 * @param array<int, string> $items List items.
 * @return void
 */
function qbr_render_checklist($items)
{
    if (empty($items)) {
        return;
    }

    echo '<ul class="check-list">';

    foreach ((array) $items as $item) {
        echo '<li>' . esc_html((string) $item) . '</li>';
    }

    echo '</ul>';
}

/**
 * Render breadcrumb trail matching the static site.
 *
 * @return void
 */
function qbr_render_breadcrumbs()
{
    if (is_front_page()) {
        return;
    }

    $mapped = qbr_get_current_mapped_content();
    $title  = wp_get_document_title();

    if (is_array($mapped) && ! empty($mapped['heroTitle'])) {
        $title = (string) $mapped['heroTitle'];
    } elseif (is_singular()) {
        $title = get_the_title();
    } elseif (is_search()) {
        /* translators: %s search query */
        $title = sprintf(__('Search results for "%s"', 'quick-brake-repair-theme'), get_search_query());
    } elseif (is_archive()) {
        $title = get_the_archive_title();
    }

    echo '<nav class="breadcrumbs shell" aria-label="' . esc_attr__('Breadcrumbs', 'quick-brake-repair-theme') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'quick-brake-repair-theme') . '</a>';

    if (is_singular('qbr_service_area')) {
        echo '<span>/</span><span>' . esc_html__('Service Area', 'quick-brake-repair-theme') . '</span>';
    }

    echo '<span>/</span><span>' . esc_html($title) . '</span>';
    echo '</nav>';
}

/**
 * Render the standard interior hero.
 *
 * @param string                            $eyebrow Ignored to preserve literal static structure.
 * @param string                            $title   Hero title.
 * @param string                            $summary Hero summary.
 * @param array<int, array<string, string>> $stats   Hero stats.
 * @param bool                              $home    Whether this is the homepage.
 * @return void
 */
function qbr_render_page_hero($eyebrow, $title, $summary, $stats = array(), $home = false)
{
    $site = qbr_get_site_data();

    if ($home) {
        return;
    }
    ?>
    <section class="hero">
        <div class="shell hero__grid">
            <div class="hero__content">
                <h1><?php echo esc_html($title); ?></h1>
                <p class="hero__summary"><?php echo esc_html($summary); ?></p>
                <div class="hero__actions">
                    <a class="button button--primary" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php esc_html_e('Call Now', 'quick-brake-repair-theme'); ?></a>
                    <a class="button button--secondary" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Free Quote', 'quick-brake-repair-theme'); ?></a>
                </div>
                <?php qbr_render_hero_stats($stats); ?>
            </div>
            <?php qbr_render_support_card(); ?>
        </div>
    </section>
    <?php
}

/**
 * Render a generic content section.
 *
 * @param string      $heading    Heading text.
 * @param array<int, string> $paragraphs Paragraphs.
 * @param string      $extra_class Additional class.
 * @return void
 */
function qbr_render_text_section($heading, $paragraphs, $extra_class = '')
{
    $class_name = 'content-section shell';

    if ($extra_class) {
        $class_name .= ' ' . $extra_class;
    }
    ?>
    <section class="<?php echo esc_attr($class_name); ?>">
        <div class="section-layout">
            <div class="section-heading">
                <h2><?php echo esc_html($heading); ?></h2>
            </div>
            <div class="content-stack">
                <?php qbr_render_paragraphs($paragraphs); ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Prepare service area card items with resolved URLs.
 *
 * @return array<int, array<string, string>>
 */
function qbr_get_service_area_card_items()
{
    $items = array();

    foreach (qbr_get_service_area_pages() as $page) {
        $items[] = array(
            'title'           => isset($page['heroTitle']) ? (string) $page['heroTitle'] : '',
            'heroSummary'     => isset($page['heroSummary']) ? (string) $page['heroSummary'] : '',
            'metaDescription' => isset($page['metaDescription']) ? (string) $page['metaDescription'] : '',
            'url'             => qbr_get_mapped_permalink((string) $page['slug'], 'service_area'),
            'eyebrow'         => isset($page['eyebrow']) ? (string) $page['eyebrow'] : '',
            'label'           => isset($page['title']) ? (string) $page['title'] : '',
        );
    }

    return $items;
}

/**
 * Prepare article card items with resolved URLs.
 *
 * @param int $limit Optional limit.
 * @return array<int, array<string, string>>
 */
function qbr_get_article_card_items($limit = 0)
{
    $items = array();

    foreach (qbr_get_article_pages() as $article) {
        $items[] = array(
            'title'           => isset($article['title']) ? (string) $article['title'] : '',
            'heroSummary'     => isset($article['heroSummary']) ? (string) $article['heroSummary'] : '',
            'metaDescription' => isset($article['metaDescription']) ? (string) $article['metaDescription'] : '',
            'url'             => qbr_get_mapped_permalink((string) $article['slug'], 'post'),
            'eyebrow'         => isset($article['publishedLabel']) ? (string) $article['publishedLabel'] : '',
        );

        if ($limit > 0 && count($items) >= $limit) {
            break;
        }
    }

    return $items;
}

/**
 * Render a generic card grid in the ported visual language.
 *
 * @param array<int, array<string, string>> $items      Card items.
 * @param string                            $link_label Link label.
 * @param string                            $modifier   Additional grid class.
 * @return void
 */
function qbr_render_card_grid($items, $link_label, $modifier = '')
{
    $class_name = 'card-grid card-grid--three';

    if ($modifier) {
        $class_name .= ' ' . $modifier;
    }

    echo '<div class="' . esc_attr($class_name) . '">';

    foreach ((array) $items as $item) {
        echo '<article class="card card--resource">';

        if (! empty($item['eyebrow'])) {
            echo '<p class="card__meta">' . esc_html((string) $item['eyebrow']) . '</p>';
        }

        echo '<h3>' . esc_html((string) $item['title']) . '</h3>';

        if (! empty($item['metaDescription'])) {
            echo '<p>' . esc_html((string) $item['metaDescription']) . '</p>';
        } elseif (! empty($item['heroSummary'])) {
            echo '<p>' . esc_html((string) $item['heroSummary']) . '</p>';
        }

        echo '<a class="text-link" href="' . esc_url((string) $item['url']) . '">' . esc_html($link_label) . '</a>';
        echo '</article>';
    }

    echo '</div>';
}

/**
 * Render FAQ items.
 *
 * @param array<int, array<string, string>> $items FAQ items.
 * @return void
 */
function qbr_render_faq_items($items)
{
    if (empty($items)) {
        return;
    }

    echo '<div class="faq-list">';

    foreach ((array) $items as $item) {
        $question = isset($item['question']) ? (string) $item['question'] : '';
        $answer   = isset($item['answer']) ? (string) $item['answer'] : '';

        echo '<details class="faq-item">';
        echo '<summary>' . esc_html($question) . '</summary>';
        echo '<p>' . esc_html($answer) . '</p>';
        echo '</details>';
    }

    echo '</div>';
}

/**
 * Render a compact CTA band in the static card language.
 *
 * @param string $heading Heading text.
 * @param string $summary Summary text.
 * @return void
 */
function qbr_render_cta_band($heading, $summary)
{
    ?>
    <section class="panel shell">
        <div class="split-grid">
            <article class="card">
                <h2><?php echo esc_html($heading); ?></h2>
                <p><?php echo esc_html($summary); ?></p>
            </article>
            <article class="card">
                <h2><?php esc_html_e('Talk to Quick Brake Repair', 'quick-brake-repair-theme'); ?></h2>
                <p><?php esc_html_e('Call first for a quote, then confirm the service path that fits your vehicle symptoms and schedule.', 'quick-brake-repair-theme'); ?></p>
                <a class="button button--primary" href="<?php echo esc_url(qbr_get_site_value('phoneHref')); ?>"><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), qbr_get_site_value('phoneDisplay'))); ?></a>
            </article>
        </div>
    </section>
    <?php
}
