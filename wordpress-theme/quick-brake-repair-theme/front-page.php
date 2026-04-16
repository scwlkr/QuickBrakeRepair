<?php
/**
 * Front page template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();
get_template_part('template-parts/page', 'home', array('page' => qbr_get_homepage_data()));
get_footer();

