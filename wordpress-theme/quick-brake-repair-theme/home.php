<?php
/**
 * Blog index template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();
get_template_part(
    'template-parts/content',
    'archive',
    array(
        'eyebrow' => __('Quick Brake Repair Journal', 'quick-brake-repair-theme'),
        'title'   => __('Latest resource articles and updates', 'quick-brake-repair-theme'),
        'summary' => __('Browse the latest brake repair articles, service updates, and practical guidance from Quick Brake Repair.', 'quick-brake-repair-theme'),
    )
);
get_footer();
