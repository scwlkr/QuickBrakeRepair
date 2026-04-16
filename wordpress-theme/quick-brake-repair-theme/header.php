<?php
/**
 * Theme header.
 *
 * @package QuickBrakeRepairTheme
 */

if (! defined('ABSPATH')) {
    exit;
}

$site = qbr_get_site_data();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="qbr-skip-link" href="#qbr-main"><?php esc_html_e('Skip to content', 'quick-brake-repair-theme'); ?></a>
<div class="qbr-site-shell">
    <header class="qbr-header" data-site-header>
        <div class="qbr-shell qbr-header__inner">
            <a class="qbr-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Quick Brake Repair home', 'quick-brake-repair-theme'); ?>">
                <?php echo wp_kses_post(qbr_get_brand_markup()); ?>
                <span class="qbr-brand__text">
                    <strong><?php bloginfo('name'); ?></strong>
                    <span><?php echo esc_html(isset($site['brandTagline']) ? (string) $site['brandTagline'] : get_bloginfo('description')); ?></span>
                </span>
            </a>
            <button class="qbr-nav-toggle" type="button" aria-expanded="false" aria-controls="qbr-primary-nav" data-nav-toggle>
                <span></span>
                <span></span>
                <span></span>
                <span class="screen-reader-text"><?php esc_html_e('Toggle navigation', 'quick-brake-repair-theme'); ?></span>
            </button>
            <nav id="qbr-primary-nav" class="qbr-nav" aria-label="<?php esc_attr_e('Primary navigation', 'quick-brake-repair-theme'); ?>" data-nav-panel>
                <?php qbr_render_primary_navigation(); ?>
            </nav>
            <a class="qbr-call-pill" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>">
                <?php echo esc_html(isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : ''); ?>
            </a>
        </div>
    </header>
    <main id="qbr-main">
        <?php qbr_render_breadcrumbs(); ?>

