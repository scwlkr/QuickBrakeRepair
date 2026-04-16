<?php
/**
 * Comments template.
 *
 * @package QuickBrakeRepairTheme
 */

if (post_password_required()) {
    return;
}
?>
<section class="qbr-section qbr-section--comments">
    <div class="qbr-shell">
        <?php if (have_comments()) : ?>
            <h2><?php esc_html_e('Comments', 'quick-brake-repair-theme'); ?></h2>
            <ol class="comment-list">
                <?php wp_list_comments(array('style' => 'ol', 'short_ping' => true)); ?>
            </ol>
            <?php the_comments_navigation(); ?>
        <?php endif; ?>
        <?php comment_form(); ?>
    </div>
</section>

