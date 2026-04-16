<?php
/**
 * Archive template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();
get_template_part(
    'template-parts/content',
    'archive',
    array(
        'eyebrow' => __('Archive', 'quick-brake-repair-theme'),
        'title'   => get_the_archive_title(),
        'summary' => get_the_archive_description() ? wp_strip_all_tags(get_the_archive_description()) : __('Browse published content and service information from Quick Brake Repair.', 'quick-brake-repair-theme'),
    )
);
get_footer();

