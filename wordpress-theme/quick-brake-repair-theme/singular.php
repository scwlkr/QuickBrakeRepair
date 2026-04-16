<?php
/**
 * Generic singular fallback.
 *
 * @package QuickBrakeRepairTheme
 */

if (is_page()) {
    require get_theme_file_path('/page.php');
    return;
}

require get_theme_file_path('/single.php');

