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
        'summary' => __('Use the blog index for ongoing article publishing. The mapped resources page remains the primary SEO landing page for the existing article set.', 'quick-brake-repair-theme'),
    )
);
get_footer();

