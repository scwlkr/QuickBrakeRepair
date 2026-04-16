<?php
/**
 * Theme content map helpers.
 *
 * The rebuild keeps key SEO copy in code so matching WordPress pages/posts
 * can reproduce the existing site intent without relying on page builders.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Load the theme's JSON content snapshot.
 *
 * @return array<string, mixed>
 */
function qbr_get_content_map()
{
    static $map = null;

    if (null !== $map) {
        return $map;
    }

    $path = get_theme_file_path('/inc/content-map.json');

    if (! file_exists($path)) {
        $map = array();
        return $map;
    }

    $contents = file_get_contents($path);
    $decoded  = json_decode((string) $contents, true);
    $map      = is_array($decoded) ? $decoded : array();

    return $map;
}

/**
 * Return site-level content data.
 *
 * @return array<string, mixed>
 */
function qbr_get_site_data()
{
    $map = qbr_get_content_map();

    return isset($map['site']) && is_array($map['site']) ? $map['site'] : array();
}

/**
 * Get primary navigation data.
 *
 * @return array<int, array<string, string>>
 */
function qbr_get_navigation_items()
{
    $map = qbr_get_content_map();

    return isset($map['navigation']) && is_array($map['navigation']) ? $map['navigation'] : array();
}

/**
 * Get FAQ page defaults.
 *
 * @return array<string, mixed>
 */
function qbr_get_faq_page_data()
{
    $map = qbr_get_content_map();

    return isset($map['faqPage']) && is_array($map['faqPage']) ? $map['faqPage'] : array();
}

/**
 * Return mapped core pages.
 *
 * @return array<int, array<string, mixed>>
 */
function qbr_get_core_pages()
{
    $map = qbr_get_content_map();

    return isset($map['corePages']) && is_array($map['corePages']) ? $map['corePages'] : array();
}

/**
 * Return mapped service area entries.
 *
 * @return array<int, array<string, mixed>>
 */
function qbr_get_service_area_pages()
{
    $map = qbr_get_content_map();

    return isset($map['serviceAreaPages']) && is_array($map['serviceAreaPages']) ? $map['serviceAreaPages'] : array();
}

/**
 * Return mapped resource articles.
 *
 * @return array<int, array<string, mixed>>
 */
function qbr_get_article_pages()
{
    $map = qbr_get_content_map();

    return isset($map['articlePages']) && is_array($map['articlePages']) ? $map['articlePages'] : array();
}

/**
 * Normalize a slug/path for array lookups.
 *
 * @param string $slug Slug or path.
 * @return string
 */
function qbr_normalize_slug($slug)
{
    $normalized = trim((string) $slug);

    if ('/' === $normalized) {
        return '';
    }

    return trim($normalized, '/');
}

/**
 * Find a mapped entry by slug in a list.
 *
 * @param string                                   $slug Target slug.
 * @param array<int, array<string, mixed>> $items Data set.
 * @return array<string, mixed>|null
 */
function qbr_find_mapped_item($slug, $items)
{
    $target = qbr_normalize_slug($slug);

    foreach ($items as $item) {
        if (! isset($item['slug'])) {
            continue;
        }

        if (qbr_normalize_slug((string) $item['slug']) === $target) {
            return $item;
        }
    }

    return null;
}

/**
 * Find a mapped core page by slug.
 *
 * @param string $slug Page slug.
 * @return array<string, mixed>|null
 */
function qbr_get_core_page($slug)
{
    return qbr_find_mapped_item($slug, qbr_get_core_pages());
}

/**
 * Get the homepage data.
 *
 * @return array<string, mixed>|null
 */
function qbr_get_homepage_data()
{
    return qbr_get_core_page('');
}

/**
 * Find a service area entry by full slug or post slug.
 *
 * @param string $slug Service area slug.
 * @return array<string, mixed>|null
 */
function qbr_get_service_area($slug)
{
    $normalized = qbr_normalize_slug($slug);

    if (0 !== strpos($normalized, 'service-area/') && '' !== $normalized) {
        $normalized = 'service-area/' . $normalized;
    }

    return qbr_find_mapped_item($normalized, qbr_get_service_area_pages());
}

/**
 * Find an article entry by slug.
 *
 * @param string $slug Article slug.
 * @return array<string, mixed>|null
 */
function qbr_get_article($slug)
{
    return qbr_find_mapped_item($slug, qbr_get_article_pages());
}

/**
 * Get the mapped content object for the current request.
 *
 * @return array<string, mixed>|null
 */
function qbr_get_current_mapped_content()
{
    if (is_front_page()) {
        return qbr_get_homepage_data();
    }

    if (is_singular('qbr_service_area')) {
        return qbr_get_service_area(get_post_field('post_name', get_queried_object_id()));
    }

    if (is_page()) {
        return qbr_get_core_page(get_post_field('post_name', get_queried_object_id()));
    }

    if (is_singular('post')) {
        return qbr_get_article(get_post_field('post_name', get_queried_object_id()));
    }

    return null;
}

/**
 * Build an intended front-end URL for a mapped slug.
 *
 * @param string $slug Intended slug.
 * @return string
 */
function qbr_get_intended_url($slug)
{
    $normalized = qbr_normalize_slug($slug);

    if ('' === $normalized) {
        return home_url('/');
    }

    return home_url(user_trailingslashit($normalized));
}

/**
 * Find a WordPress object by intended slug and type.
 *
 * @param string $slug Intended slug.
 * @param string $type page|post|service_area
 * @return WP_Post|null
 */
function qbr_find_object_by_slug($slug, $type = 'page')
{
    $normalized = qbr_normalize_slug($slug);

    if ('service_area' === $type) {
        $post_name = basename($normalized);
        $post      = get_page_by_path($post_name, OBJECT, 'qbr_service_area');

        return $post instanceof WP_Post ? $post : null;
    }

    if ('post' === $type) {
        $post = get_page_by_path($normalized, OBJECT, 'post');

        return $post instanceof WP_Post ? $post : null;
    }

    $post = get_page_by_path($normalized, OBJECT, 'page');

    return $post instanceof WP_Post ? $post : null;
}

/**
 * Resolve a permalink for a mapped slug, falling back to the intended path.
 *
 * @param string $slug Intended slug.
 * @param string $type page|post|service_area
 * @return string
 */
function qbr_get_mapped_permalink($slug, $type = 'page')
{
    $object = qbr_find_object_by_slug($slug, $type);

    if ($object instanceof WP_Post) {
        return get_permalink($object);
    }

    return qbr_get_intended_url($slug);
}

/**
 * Determine whether a mapped core page uses a special template family.
 *
 * @param array<string, mixed>|null $page Page data.
 * @return string
 */
function qbr_get_page_family($page)
{
    if (! is_array($page) || empty($page['template'])) {
        return 'generic';
    }

    return (string) $page['template'];
}

/**
 * Get related service area for an article entry.
 *
 * @param array<string, mixed> $article Article data.
 * @return array<string, mixed>|null
 */
function qbr_get_related_service_area_for_article($article)
{
    if (empty($article['relatedSlug'])) {
        return null;
    }

    return qbr_get_service_area((string) $article['relatedSlug']);
}

/**
 * Get the first related article for a service area entry.
 *
 * @param array<string, mixed> $service_area Service area data.
 * @return array<string, mixed>|null
 */
function qbr_get_related_article_for_service_area($service_area)
{
    if (empty($service_area['slug'])) {
        return null;
    }

    $service_slug = qbr_normalize_slug((string) $service_area['slug']);

    foreach (qbr_get_article_pages() as $article) {
        if (
            isset($article['relatedSlug']) &&
            qbr_normalize_slug((string) $article['relatedSlug']) === $service_slug
        ) {
            return $article;
        }
    }

    return null;
}

/**
 * Convert a mapped slug into a readable label.
 *
 * @param string $slug Intended slug.
 * @return string
 */
function qbr_slug_label($slug)
{
    $slug = qbr_normalize_slug($slug);

    if ('' === $slug) {
        return __('Home', 'quick-brake-repair-theme');
    }

    $label = str_replace(array('service-area/', '-tx', '-'), array('', '', ' '), $slug);

    return ucwords($label);
}

