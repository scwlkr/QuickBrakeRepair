<?php
/**
 * Theme supports, content model, and body class helpers.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Register the service area content type used to preserve `/service-area/...` URLs.
 *
 * @return void
 */
function qbr_register_post_types()
{
    $labels = array(
        'name'               => __('Service Areas', 'quick-brake-repair-theme'),
        'singular_name'      => __('Service Area', 'quick-brake-repair-theme'),
        'menu_name'          => __('Service Areas', 'quick-brake-repair-theme'),
        'add_new'            => __('Add New', 'quick-brake-repair-theme'),
        'add_new_item'       => __('Add New Service Area', 'quick-brake-repair-theme'),
        'edit_item'          => __('Edit Service Area', 'quick-brake-repair-theme'),
        'new_item'           => __('New Service Area', 'quick-brake-repair-theme'),
        'view_item'          => __('View Service Area', 'quick-brake-repair-theme'),
        'search_items'       => __('Search Service Areas', 'quick-brake-repair-theme'),
        'not_found'          => __('No service areas found.', 'quick-brake-repair-theme'),
        'not_found_in_trash' => __('No service areas found in Trash.', 'quick-brake-repair-theme'),
    );

    register_post_type(
        'qbr_service_area',
        array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_rest'      => true,
            'has_archive'       => false,
            'rewrite'           => array(
                'slug'       => 'service-area',
                'with_front' => false,
            ),
            'menu_icon'         => 'dashicons-location-alt',
            'supports'          => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
            'publicly_queryable'=> true,
            'show_in_nav_menus' => true,
        )
    );
}
add_action('init', 'qbr_register_post_types');

/**
 * Add body classes tied to mapped content families.
 *
 * @param array<int, string> $classes Existing classes.
 * @return array<int, string>
 */
function qbr_filter_body_classes($classes)
{
    if (is_front_page()) {
        $classes[] = 'page-home';
    }

    if (is_page()) {
        $slug = get_post_field('post_name', get_queried_object_id());
        $page = qbr_get_core_page($slug);

        if (is_array($page) && ! empty($page['template']) && 'contact' === (string) $page['template']) {
            $classes[] = 'page-contact';
        }
    }

    return $classes;
}
add_filter('body_class', 'qbr_filter_body_classes');
