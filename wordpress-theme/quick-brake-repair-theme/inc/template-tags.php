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

    return get_theme_file_uri('/assets/images/logo.png');
}

/**
 * Render the branded mark.
 *
 * @return string
 */
function qbr_get_brand_markup()
{
    return sprintf(
        '<span class="qbr-brand-mark"><img src="%1$s" alt="%2$s"></span>',
        esc_url(qbr_get_logo_url()),
        esc_attr__('Quick Brake Repair logo', 'quick-brake-repair-theme')
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
        return is_page('resources') || is_home() || is_archive() || is_search() || is_singular('post');
    }

    return is_page($slug);
}

/**
 * Output the fallback navigation menu.
 *
 * @return void
 */
function qbr_render_fallback_navigation()
{
    foreach (qbr_get_navigation_items() as $item) {
        $slug   = isset($item['slug']) ? (string) $item['slug'] : '';
        $label  = isset($item['label']) ? (string) $item['label'] : qbr_slug_label($slug);
        $active = qbr_is_nav_active($slug) ? ' is-active' : '';
        $url    = qbr_get_mapped_permalink($slug, 'page');

        printf(
            '<a class="qbr-nav__link%1$s" href="%2$s">%3$s</a>',
            esc_attr($active),
            esc_url($url),
            esc_html($label)
        );
    }
}

/**
 * Render the primary navigation markup.
 *
 * @return void
 */
function qbr_render_primary_navigation()
{
    if (has_nav_menu('primary')) {
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'qbr-nav__menu',
                'fallback_cb'    => false,
            )
        );
        return;
    }

    echo '<div class="qbr-nav__menu">';
    qbr_render_fallback_navigation();
    echo '</div>';
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

    echo '<div class="qbr-hero__stats">';

    foreach ($stats as $stat) {
        $value = isset($stat['value']) ? (string) $stat['value'] : '';
        $label = isset($stat['label']) ? (string) $stat['label'] : '';

        printf(
            '<div class="qbr-stat"><strong>%1$s</strong><span>%2$s</span></div>',
            esc_html($value),
            esc_html($label)
        );
    }

    echo '</div>';
}

/**
 * Get the shared phone number.
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
 * Render the shared service card used beside standard heroes.
 *
 * @return void
 */
function qbr_render_support_card()
{
    $site = qbr_get_site_data();

    ?>
    <aside class="qbr-support-card">
        <div class="qbr-support-card__logo"><?php echo wp_kses_post(qbr_get_brand_markup()); ?></div>
        <p class="qbr-support-card__eyebrow"><?php esc_html_e('On-site diagnostics and repair', 'quick-brake-repair-theme'); ?></p>
        <p class="qbr-support-card__copy"><?php esc_html_e('Brake pads, rotors, calipers, hoses, fluid service, and inspection support without the tow or waiting room.', 'quick-brake-repair-theme'); ?></p>
        <dl class="qbr-support-card__facts">
            <div>
                <dt><?php esc_html_e('Coverage', 'quick-brake-repair-theme'); ?></dt>
                <dd><?php echo esc_html(isset($site['serviceAreaLabel']) ? (string) $site['serviceAreaLabel'] : ''); ?></dd>
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
        printf('<p>%s</p>', esc_html((string) $paragraph));
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

    echo '<ul class="qbr-checklist">';

    foreach ((array) $items as $item) {
        printf('<li>%s</li>', esc_html((string) $item));
    }

    echo '</ul>';
}

/**
 * Render breadcrumb trail.
 *
 * @return void
 */
function qbr_render_breadcrumbs()
{
    if (is_front_page()) {
        return;
    }

    $items   = array(
        array(
            'label' => __('Home', 'quick-brake-repair-theme'),
            'url'   => home_url('/'),
        ),
    );
    $mapped  = qbr_get_current_mapped_content();
    $title   = wp_get_document_title();

    if (is_singular('qbr_service_area')) {
        $items[] = array(
            'label' => __('Areas We Serve', 'quick-brake-repair-theme'),
            'url'   => qbr_get_mapped_permalink('areas-we-serve', 'page'),
        );
    } elseif (is_singular('post') || is_home() || is_archive() || is_search()) {
        $items[] = array(
            'label' => __('Resources', 'quick-brake-repair-theme'),
            'url'   => qbr_get_mapped_permalink('resources', 'page'),
        );
    }

    if (is_array($mapped) && ! empty($mapped['heroTitle'])) {
        $title = (string) $mapped['heroTitle'];
    } elseif (is_singular()) {
        $title = get_the_title();
    } elseif (is_search()) {
        /* translators: %s search query */
        $title = sprintf(__('Search results for "%s"', 'quick-brake-repair-theme'), get_search_query());
    }

    echo '<nav class="qbr-breadcrumbs" aria-label="' . esc_attr__('Breadcrumbs', 'quick-brake-repair-theme') . '">';

    foreach ($items as $index => $item) {
        if ($index > 0) {
            echo '<span class="qbr-breadcrumbs__divider">/</span>';
        }

        printf(
            '<a href="%1$s">%2$s</a>',
            esc_url((string) $item['url']),
            esc_html((string) $item['label'])
        );
    }

    echo '<span class="qbr-breadcrumbs__divider">/</span>';
    echo '<span>' . esc_html($title) . '</span>';
    echo '</nav>';
}

/**
 * Render page heading group.
 *
 * @param string      $eyebrow Eyebrow text.
 * @param string      $title Title text.
 * @param string      $summary Summary text.
 * @param array<int, array<string, string>> $stats Hero stats.
 * @param bool        $home Whether this is the homepage.
 * @return void
 */
function qbr_render_page_hero($eyebrow, $title, $summary, $stats = array(), $home = false)
{
    $site = qbr_get_site_data();
    ?>
    <section class="qbr-hero<?php echo $home ? ' qbr-hero--home' : ''; ?>">
        <?php if ($home) : ?>
            <div class="qbr-hero__media" aria-hidden="true">
                <video class="qbr-hero__video" autoplay muted loop playsinline poster="<?php echo esc_url(get_theme_file_uri('/assets/images/hero-poster.jpg')); ?>">
                    <source src="<?php echo esc_url(get_theme_file_uri('/assets/images/hero-loop.mp4')); ?>" type="video/mp4">
                </video>
                <div class="qbr-hero__overlay"></div>
            </div>
        <?php endif; ?>
        <div class="qbr-shell qbr-hero__grid">
            <div class="qbr-hero__content">
                <?php if ($eyebrow) : ?>
                    <p class="qbr-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <h1><?php echo esc_html($title); ?></h1>
                <p class="qbr-hero__summary"><?php echo esc_html($summary); ?></p>
                <div class="qbr-hero__actions">
                    <a class="qbr-button qbr-button--primary" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php esc_html_e('Call Now', 'quick-brake-repair-theme'); ?></a>
                    <a class="qbr-button qbr-button--secondary" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Free Quote', 'quick-brake-repair-theme'); ?></a>
                </div>
                <?php qbr_render_hero_stats($stats); ?>
            </div>
            <?php qbr_render_support_card(); ?>
        </div>
    </section>
    <?php
}

/**
 * Render section intro content.
 *
 * @param string      $heading Heading text.
 * @param array<int, string> $paragraphs Paragraphs.
 * @param string      $extra_class Additional class.
 * @return void
 */
function qbr_render_text_section($heading, $paragraphs, $extra_class = '')
{
    $class_name = 'qbr-section';

    if ($extra_class) {
        $class_name .= ' ' . $extra_class;
    }
    ?>
    <section class="<?php echo esc_attr($class_name); ?>">
        <div class="qbr-shell qbr-section__grid">
            <div class="qbr-section__heading">
                <h2><?php echo esc_html($heading); ?></h2>
            </div>
            <div class="qbr-rich-text">
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
            'title'       => isset($page['heroTitle']) ? (string) $page['heroTitle'] : '',
            'summary'     => isset($page['heroSummary']) ? (string) $page['heroSummary'] : '',
            'description' => isset($page['metaDescription']) ? (string) $page['metaDescription'] : '',
            'url'         => qbr_get_mapped_permalink((string) $page['slug'], 'service_area'),
            'eyebrow'     => isset($page['eyebrow']) ? (string) $page['eyebrow'] : '',
            'label'       => isset($page['title']) ? (string) $page['title'] : '',
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
            'title'       => isset($article['title']) ? (string) $article['title'] : '',
            'summary'     => isset($article['metaDescription']) ? (string) $article['metaDescription'] : '',
            'description' => isset($article['heroSummary']) ? (string) $article['heroSummary'] : '',
            'url'         => qbr_get_mapped_permalink((string) $article['slug'], 'post'),
            'eyebrow'     => isset($article['publishedLabel']) ? (string) $article['publishedLabel'] : '',
        );

        if ($limit > 0 && count($items) >= $limit) {
            break;
        }
    }

    return $items;
}

/**
 * Render card grid.
 *
 * @param array<int, array<string, string>> $items Card items.
 * @param string                            $link_label Link label.
 * @param string                            $modifier Grid class modifier.
 * @return void
 */
function qbr_render_card_grid($items, $link_label, $modifier = '')
{
    $class_name = 'qbr-card-grid';

    if ($modifier) {
        $class_name .= ' ' . $modifier;
    }

    echo '<div class="' . esc_attr($class_name) . '">';

    foreach ((array) $items as $item) {
        echo '<article class="qbr-card">';

        if (! empty($item['eyebrow'])) {
            echo '<p class="qbr-card__eyebrow">' . esc_html((string) $item['eyebrow']) . '</p>';
        }

        echo '<h3>' . esc_html((string) $item['title']) . '</h3>';

        if (! empty($item['summary'])) {
            echo '<p>' . esc_html((string) $item['summary']) . '</p>';
        } elseif (! empty($item['description'])) {
            echo '<p>' . esc_html((string) $item['description']) . '</p>';
        }

        echo '<a class="qbr-text-link" href="' . esc_url((string) $item['url']) . '">' . esc_html($link_label) . '</a>';
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

    echo '<div class="qbr-faq">';

    foreach ((array) $items as $item) {
        $question = isset($item['question']) ? (string) $item['question'] : '';
        $answer   = isset($item['answer']) ? (string) $item['answer'] : '';

        echo '<details class="qbr-faq__item">';
        echo '<summary>' . esc_html($question) . '</summary>';
        echo '<p>' . esc_html($answer) . '</p>';
        echo '</details>';
    }

    echo '</div>';
}

/**
 * Render a compact CTA band.
 *
 * @param string $heading Heading text.
 * @param string $summary Summary text.
 * @return void
 */
function qbr_render_cta_band($heading, $summary)
{
    ?>
    <section class="qbr-cta-band">
        <div class="qbr-shell qbr-cta-band__grid">
            <div>
                <p class="qbr-eyebrow"><?php esc_html_e('Quick Brake Repair', 'quick-brake-repair-theme'); ?></p>
                <h2><?php echo esc_html($heading); ?></h2>
                <p><?php echo esc_html($summary); ?></p>
            </div>
            <div class="qbr-cta-band__actions">
                <a class="qbr-button qbr-button--primary" href="<?php echo esc_url(qbr_get_site_value('phoneHref')); ?>"><?php echo esc_html(sprintf(__('Call %s', 'quick-brake-repair-theme'), qbr_get_site_value('phoneDisplay'))); ?></a>
                <a class="qbr-button qbr-button--secondary" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Request a Quote', 'quick-brake-repair-theme'); ?></a>
            </div>
        </div>
    </section>
    <?php
}

