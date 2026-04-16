<?php
/**
 * Search results template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();
get_template_part(
    'template-parts/content',
    'archive',
    array(
        'eyebrow' => __('Search', 'quick-brake-repair-theme'),
        'title'   => sprintf(__('Search results for "%s"', 'quick-brake-repair-theme'), get_search_query()),
        'summary' => __('Search across Quick Brake Repair pages, service areas, and resource articles.', 'quick-brake-repair-theme'),
    )
);
get_footer();
