<?php
/**
 * Asset loading for the theme.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue front-end assets.
 *
 * @return void
 */
function qbr_enqueue_assets()
{
    $theme = wp_get_theme();

    wp_enqueue_style(
        'qbr-fonts',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'qbr-theme',
        get_theme_file_uri('/assets/css/theme.css'),
        array(),
        $theme->get('Version')
    );

    wp_enqueue_script(
        'qbr-theme',
        get_theme_file_uri('/assets/js/theme.js'),
        array(),
        $theme->get('Version'),
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'qbr_enqueue_assets');
