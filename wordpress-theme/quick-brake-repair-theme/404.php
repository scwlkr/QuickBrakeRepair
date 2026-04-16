<?php
/**
 * 404 template.
 *
 * @package QuickBrakeRepairTheme
 */

get_header();

qbr_render_page_hero(
    '',
    __('This page is not available.', 'quick-brake-repair-theme'),
    __('Use the main service links below or call Quick Brake Repair directly if you were trying to reach a service page or resource article.', 'quick-brake-repair-theme')
);
?>
<section class="panel shell">
    <div class="card-grid card-grid--three">
        <article class="card">
            <h2><?php esc_html_e('Core Pages', 'quick-brake-repair-theme'); ?></h2>
            <p><?php esc_html_e('Jump back to the primary business pages.', 'quick-brake-repair-theme'); ?></p>
            <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('areas-we-serve', 'page')); ?>"><?php esc_html_e('View Areas We Serve', 'quick-brake-repair-theme'); ?></a>
        </article>
        <article class="card">
            <h2><?php esc_html_e('Resources', 'quick-brake-repair-theme'); ?></h2>
            <p><?php esc_html_e('Browse brake repair guides covering common symptoms, service questions, and maintenance topics.', 'quick-brake-repair-theme'); ?></p>
            <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('resources', 'page')); ?>"><?php esc_html_e('View Resources', 'quick-brake-repair-theme'); ?></a>
        </article>
        <article class="card">
            <h2><?php esc_html_e('Contact', 'quick-brake-repair-theme'); ?></h2>
            <p><?php esc_html_e('Reach out for a quote or fast service availability.', 'quick-brake-repair-theme'); ?></p>
            <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Open Contact Page', 'quick-brake-repair-theme'); ?></a>
        </article>
    </div>
</section>
<?php
get_footer();
