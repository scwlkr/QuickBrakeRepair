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
$site_name = isset($site['name']) ? (string) $site['name'] : get_bloginfo('name');
$brand_tagline = isset($site['brandTagline']) ? (string) $site['brandTagline'] : get_bloginfo('description');
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e('Skip to content', 'quick-brake-repair-theme'); ?></a>
<div class="site-chrome">
    <header class="site-header">
        <div class="site-header__inner shell">
            <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($site_name . ' home'); ?>">
                <?php echo wp_kses_post(qbr_get_brand_markup()); ?>
                <span class="brand__text">
                    <strong><?php echo esc_html($site_name); ?></strong>
                    <span><?php echo esc_html($brand_tagline); ?></span>
                </span>
            </a>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="<?php esc_attr_e('Open navigation', 'quick-brake-repair-theme'); ?>">
                <span></span>
                <span></span>
                <span></span>
                <span class="sr-only"><?php esc_html_e('Toggle navigation', 'quick-brake-repair-theme'); ?></span>
            </button>
            <nav id="site-nav" class="site-nav" aria-label="<?php esc_attr_e('Primary', 'quick-brake-repair-theme'); ?>">
                <?php qbr_render_primary_navigation(); ?>
            </nav>
            <a class="call-pill" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>">
                <?php echo esc_html(isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : ''); ?>
            </a>
        </div>
    </header>
    <main id="main-content"<?php echo is_front_page() ? ' class="page-home__main"' : ''; ?>>
        <?php qbr_render_breadcrumbs(); ?>
