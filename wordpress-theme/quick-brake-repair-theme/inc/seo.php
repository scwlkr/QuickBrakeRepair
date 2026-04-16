<?php
/**
 * Lightweight SEO and schema output.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Check whether a major SEO plugin is already responsible for metadata.
 *
 * @return bool
 */
function qbr_has_external_seo_plugin()
{
    return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('SEOPRESS_VERSION');
}

/**
 * Resolve the current meta description.
 *
 * @return string
 */
function qbr_get_meta_description()
{
    $mapped = qbr_get_current_mapped_content();

    if (is_array($mapped) && ! empty($mapped['metaDescription'])) {
        return (string) $mapped['metaDescription'];
    }

    if (is_singular()) {
        $excerpt = trim(wp_strip_all_tags(get_the_excerpt()));

        if ($excerpt) {
            return $excerpt;
        }
    }

    return get_bloginfo('description');
}

/**
 * Print meta tags and schema.
 *
 * @return void
 */
function qbr_print_meta_tags()
{
    if (qbr_has_external_seo_plugin()) {
        return;
    }

    $site        = qbr_get_site_data();
    $mapped      = qbr_get_current_mapped_content();
    $description = qbr_get_meta_description();
    $canonical   = '';
    $title       = wp_get_document_title();
    $og_type     = is_singular('post') ? 'article' : 'website';

    if (is_singular()) {
        $canonical = wp_get_canonical_url();
    } elseif (is_front_page()) {
        $canonical = home_url('/');
    } elseif (is_home()) {
        $canonical = get_permalink(get_option('page_for_posts'));
    }

    if (is_array($mapped) && ! empty($mapped['title'])) {
        $title = (string) $mapped['title'];
    }

    echo '<meta name="theme-color" content="#081a37">' . "\n";
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";

    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($canonical) . '">' . "\n";
    }

    $schema = null;

    if (is_singular('post') && is_array($mapped)) {
        $schema = array(
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $mapped['title'],
            'datePublished'    => $mapped['lastmod'],
            'dateModified'     => $mapped['lastmod'],
            'author'           => array(
                '@type' => 'Organization',
                'name'  => $site['name'],
            ),
            'publisher'        => array(
                '@type' => 'Organization',
                'name'  => $site['name'],
            ),
            'description'      => $description,
            'mainEntityOfPage' => $canonical,
        );
    } elseif ((is_front_page() || is_page() || is_singular('qbr_service_area')) && ! empty($site)) {
        $schema = array(
            '@context'                 => 'https://schema.org',
            '@type'                    => 'AutoRepair',
            'name'                     => $site['name'],
            'url'                      => $canonical ? $canonical : home_url('/'),
            'telephone'                => $site['phoneDisplay'],
            'address'                  => array(
                '@type'           => 'PostalAddress',
                'addressLocality' => $site['city'],
                'addressRegion'   => 'TX',
                'postalCode'      => $site['postalCode'],
                'addressCountry'  => 'US',
            ),
            'areaServed'               => array_map('trim', explode(',', (string) $site['serviceAreaLabel'])),
            'openingHoursSpecification'=> array(
                array(
                    '@type'    => 'OpeningHoursSpecification',
                    'dayOfWeek'=> array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
                    'opens'    => '08:00',
                    'closes'   => '19:00',
                ),
            ),
        );
    }

    if (is_page('resources')) {
        $resources = qbr_get_core_page('resources');

        if (! empty($resources['faqItems']) && is_array($resources['faqItems'])) {
            $schema = array(
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => array_map(
                    static function ($item) {
                        return array(
                            '@type'          => 'Question',
                            'name'           => $item['question'],
                            'acceptedAnswer' => array(
                                '@type' => 'Answer',
                                'text'  => $item['answer'],
                            ),
                        );
                    },
                    $resources['faqItems']
                ),
            );
        }
    }

    if ($schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'qbr_print_meta_tags', 1);
