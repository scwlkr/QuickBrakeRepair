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
        'summary' => __('Search across pages, service areas, and resource posts inside the Quick Brake Repair WordPress rebuild.', 'quick-brake-repair-theme'),
    )
);
get_footer();

