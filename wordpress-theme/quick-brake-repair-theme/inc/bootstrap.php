<?php
/**
 * One-time theme activation bootstrap helpers.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Queue the bootstrap routine when the theme is activated.
 *
 * The actual inserts run later on `admin_init` so WordPress has already
 * registered post types and loaded the admin environment needed for safe
 * content creation.
 *
 * @return void
 */
function qbr_schedule_theme_bootstrap()
{
    update_option('qbr_theme_bootstrap_pending', 1, false);
}
add_action('after_switch_theme', 'qbr_schedule_theme_bootstrap');

/**
 * Run the queued bootstrap once on the first admin request after activation.
 *
 * @return void
 */
function qbr_run_theme_bootstrap()
{
    if (! is_admin() || ! current_user_can('manage_options')) {
        return;
    }

    if (! get_option('qbr_theme_bootstrap_pending')) {
        return;
    }

    delete_option('qbr_theme_bootstrap_pending');

    $report = qbr_bootstrap_site_content();

    update_option('qbr_theme_bootstrap_notice', $report, false);
}
add_action('admin_init', 'qbr_run_theme_bootstrap');

/**
 * Return the required core page seed definitions.
 *
 * These records are minimal WordPress routing objects. The theme renders the
 * preserved page experience from the code-driven content map by slug, so the
 * bootstrap only needs to create the matching records once.
 *
 * @return array<int, array<string, mixed>>
 */
function qbr_bootstrap_get_required_pages()
{
    $faq = qbr_get_faq_page_data();

    return array(
        array(
            'slug'  => 'home',
            'title' => 'Home',
        ),
        array(
            'slug'  => 'premium',
            'title' => 'Premium',
        ),
        array(
            'slug'  => 'standard',
            'title' => 'Standard',
        ),
        array(
            'slug'  => 'areas-we-serve',
            'title' => 'Areas We Serve',
        ),
        array(
            'slug'  => 'resources',
            'title' => 'Resources',
        ),
        array(
            'slug'  => 'contact',
            'title' => 'Contact',
        ),
        array(
            'slug'          => 'faq',
            'title'         => isset($faq['title']) ? (string) $faq['title'] : 'Frequently Asked Questions',
            'page_template' => 'page-templates/template-faq.php',
        ),
    );
}

/**
 * Find an existing post by exact slug across all statuses.
 *
 * Querying against `any` status keeps the bootstrap idempotent even if a
 * matching record is sitting in Draft, Private, or Trash. In those cases we
 * do not create a duplicate record with a `-2` suffix.
 *
 * @param string $slug Exact post slug.
 * @param string $post_type WordPress post type.
 * @return WP_Post|null
 */
function qbr_bootstrap_find_existing_post($slug, $post_type)
{
    $posts = get_posts(
        array(
            'name'              => sanitize_title($slug),
            'post_type'         => $post_type,
            'post_status'       => 'any',
            'posts_per_page'    => 1,
            'orderby'           => 'ID',
            'order'             => 'ASC',
            'no_found_rows'     => true,
            'suppress_filters'  => true,
        )
    );

    return ! empty($posts[0]) && $posts[0] instanceof WP_Post ? $posts[0] : null;
}

/**
 * Create a post only when the exact slug is missing.
 *
 * @param string               $post_type WordPress post type.
 * @param string               $slug Exact slug to preserve.
 * @param string               $title Title used for the admin record.
 * @param array<string, mixed> $extra Additional `wp_insert_post()` fields.
 * @return array<string, mixed>
 */
function qbr_bootstrap_ensure_post($post_type, $slug, $title, $extra = array())
{
    $existing = qbr_bootstrap_find_existing_post($slug, $post_type);

    if ($existing instanceof WP_Post) {
        return array(
            'created' => false,
            'post'    => $existing,
        );
    }

    $postarr = wp_parse_args(
        $extra,
        array(
            'post_type'    => $post_type,
            'post_status'  => 'publish',
            'post_title'   => $title,
            'post_name'    => sanitize_title($slug),
            'post_content' => '',
        )
    );

    $post_id = wp_insert_post($postarr, true);

    if (is_wp_error($post_id)) {
        return array(
            'created' => false,
            'error'   => $post_id->get_error_message(),
        );
    }

    return array(
        'created' => true,
        'post'    => get_post($post_id),
    );
}

/**
 * Assign the static front page when the target page is publishable.
 *
 * Existing custom front-page choices are left alone after the first activation
 * unless the install still has no usable static front page configured.
 *
 * @param WP_Post|null $page Candidate front page.
 * @return string assigned|already-configured|skipped
 */
function qbr_bootstrap_assign_front_page($page)
{
    if (! $page instanceof WP_Post || 'publish' !== $page->post_status) {
        return 'skipped';
    }

    $current_front = (int) get_option('page_on_front');

    if ('page' === get_option('show_on_front') && $current_front > 0) {
        return $current_front === (int) $page->ID ? 'already-configured' : 'skipped';
    }

    update_option('show_on_front', 'page');
    update_option('page_on_front', (int) $page->ID);

    return 'assigned';
}

/**
 * Seed the site records that the theme's main links depend on.
 *
 * The bootstrap creates the required pages, starter service-area entries, and
 * starter resource posts. The resource posts are included because the mapped
 * resources and service-area templates link directly to those slugs.
 *
 * @return array<string, mixed>
 */
function qbr_bootstrap_site_content()
{
    $report = array(
        'pages_created'         => array(),
        'service_areas_created' => array(),
        'resource_posts_created' => array(),
        'front_page_status'     => 'skipped',
        'notes'                 => array(),
        'errors'                => array(),
    );

    $home_page = null;

    foreach (qbr_bootstrap_get_required_pages() as $page) {
        $result = qbr_bootstrap_ensure_post(
            'page',
            (string) $page['slug'],
            (string) $page['title'],
            array(
                'meta_input' => ! empty($page['page_template'])
                    ? array('_wp_page_template' => (string) $page['page_template'])
                    : array(),
            )
        );

        if (! empty($result['error'])) {
            $report['errors'][] = sprintf('page:%s (%s)', (string) $page['slug'], (string) $result['error']);
            continue;
        }

        if (! empty($result['created'])) {
            $report['pages_created'][] = (string) $page['slug'];
        }

        if (
            isset($page['slug']) &&
            'home' === (string) $page['slug'] &&
            ! empty($result['post']) &&
            $result['post'] instanceof WP_Post
        ) {
            $home_page = $result['post'];
        }
    }

    $report['front_page_status'] = qbr_bootstrap_assign_front_page($home_page);

    if (post_type_exists('qbr_service_area')) {
        foreach (qbr_get_service_area_pages() as $service_area) {
            $full_slug = isset($service_area['slug']) ? (string) $service_area['slug'] : '';
            $slug      = basename(qbr_normalize_slug($full_slug));
            $title     = isset($service_area['title']) ? (string) $service_area['title'] : qbr_slug_label($slug);

            $result = qbr_bootstrap_ensure_post('qbr_service_area', $slug, $title);

            if (! empty($result['error'])) {
                $report['errors'][] = sprintf('service-area:%s (%s)', $slug, (string) $result['error']);
                continue;
            }

            if (! empty($result['created'])) {
                $report['service_areas_created'][] = $slug;
            }
        }
    } else {
        $report['notes'][] = 'Skipped service-area seeds because the qbr_service_area post type was not available.';
    }

    foreach (qbr_get_article_pages() as $article) {
        $slug  = isset($article['slug']) ? qbr_normalize_slug((string) $article['slug']) : '';
        $title = isset($article['title']) ? (string) $article['title'] : qbr_slug_label($slug);

        if ('' === $slug) {
            continue;
        }

        $result = qbr_bootstrap_ensure_post('post', $slug, $title);

        if (! empty($result['error'])) {
            $report['errors'][] = sprintf('post:%s (%s)', $slug, (string) $result['error']);
            continue;
        }

        if (! empty($result['created'])) {
            $report['resource_posts_created'][] = $slug;
        }
    }

    // `/resources/` stays a normal mapped page in this theme. Assigning it as
    // `page_for_posts` would replace that landing page with the generic blog
    // index, so the bootstrap intentionally leaves the posts page untouched.
    $report['notes'][] = 'Left the posts page unchanged so /resources/ keeps its mapped landing-page template.';

    flush_rewrite_rules();

    return $report;
}

/**
 * Format a slug list for the bootstrap admin notice.
 *
 * @param array<int, string> $items Slugs created during bootstrap.
 * @return string
 */
function qbr_bootstrap_format_notice_items($items)
{
    $formatted = array_map(
        static function ($item) {
            return '<code>' . esc_html((string) $item) . '</code>';
        },
        array_values((array) $items)
    );

    return implode(', ', $formatted);
}

/**
 * Show a one-time admin notice summarizing the bootstrap work.
 *
 * @return void
 */
function qbr_render_theme_bootstrap_notice()
{
    if (! current_user_can('manage_options')) {
        return;
    }

    $report = get_option('qbr_theme_bootstrap_notice');

    if (! is_array($report)) {
        return;
    }

    delete_option('qbr_theme_bootstrap_notice');

    $notice_class = empty($report['errors']) ? 'notice notice-success is-dismissible' : 'notice notice-warning is-dismissible';

    echo '<div class="' . esc_attr($notice_class) . '">';
    echo '<p><strong>Quick Brake Repair bootstrap completed.</strong></p>';

    if (! empty($report['pages_created'])) {
        echo '<p>Created pages: ' . wp_kses_post(qbr_bootstrap_format_notice_items((array) $report['pages_created'])) . '.</p>';
    }

    if (! empty($report['service_areas_created'])) {
        echo '<p>Created service areas: ' . wp_kses_post(qbr_bootstrap_format_notice_items((array) $report['service_areas_created'])) . '.</p>';
    }

    if (! empty($report['resource_posts_created'])) {
        echo '<p>Created resource posts: ' . wp_kses_post(qbr_bootstrap_format_notice_items((array) $report['resource_posts_created'])) . '.</p>';
    }

    if ('assigned' === (string) $report['front_page_status']) {
        echo '<p>Assigned the <code>home</code> page as the static front page.</p>';
    } elseif ('already-configured' === (string) $report['front_page_status']) {
        echo '<p>The static front page was already configured.</p>';
    }

    if (! empty($report['notes'])) {
        foreach ((array) $report['notes'] as $note) {
            echo '<p>' . esc_html((string) $note) . '</p>';
        }
    }

    if (! empty($report['errors'])) {
        echo '<p>Bootstrap warnings: ' . esc_html(implode('; ', (array) $report['errors'])) . '.</p>';
    }

    if (
        empty($report['pages_created']) &&
        empty($report['service_areas_created']) &&
        empty($report['resource_posts_created']) &&
        empty($report['errors'])
    ) {
        echo '<p>All required records were already present, so no duplicates were created.</p>';
    }

    echo '</div>';
}
add_action('admin_notices', 'qbr_render_theme_bootstrap_notice');
