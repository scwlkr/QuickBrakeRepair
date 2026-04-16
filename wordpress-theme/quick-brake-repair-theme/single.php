<?php
/**
 * Single template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();

if (is_singular('qbr_service_area')) {
    get_template_part(
        'template-parts/page',
        'location',
        array(
            'page' => qbr_get_service_area(get_post_field('post_name', get_queried_object_id())),
        )
    );
} else {
    get_template_part(
        'template-parts/content',
        'single',
        array(
            'article' => qbr_get_article(get_post_field('post_name', get_queried_object_id())),
        )
    );
}

get_footer();

