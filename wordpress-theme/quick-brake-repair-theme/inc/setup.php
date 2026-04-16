<?php
/**
 * Theme setup callbacks.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Register theme supports and menus.
 *
 * @return void
 */
function qbr_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 96,
            'width'       => 96,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'quick-brake-repair-theme'),
            'footer'  => __('Footer Menu', 'quick-brake-repair-theme'),
        )
    );
}
add_action('after_setup_theme', 'qbr_theme_setup');

