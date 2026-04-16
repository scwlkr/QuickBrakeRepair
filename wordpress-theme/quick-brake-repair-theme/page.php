<?php
/**
 * Page template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();

$slug = get_post_field('post_name', get_queried_object_id());
$page = qbr_get_core_page($slug);

if (is_array($page)) {
    $family = qbr_get_page_family($page);

    if (in_array($family, array('service', 'areas', 'resources', 'contact'), true)) {
        get_template_part('template-parts/page', $family, array('page' => $page));
    } else {
        get_template_part('template-parts/content', 'page', array('page' => $page));
    }
} else {
    get_template_part('template-parts/content', 'page');
}

get_footer();

