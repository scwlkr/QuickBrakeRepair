<?php
/**
 * Contact page template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$site = qbr_get_site_data();
$image_url = qbr_get_theme_image_uri('img-luke.jpeg');
$status_next_url = add_query_arg('submitted', '1', qbr_get_mapped_permalink('contact', 'page')) . '#contact-request';
?>
<section class="hero">
    <div class="shell hero__grid">
        <div class="contact-hero__primary">
            <div class="hero__content">
                <h1><?php echo esc_html(isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_the_title()); ?></h1>
                <p class="hero__summary"><?php echo esc_html(isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''); ?></p>
                <div class="hero__actions">
                    <a class="button button--primary" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php esc_html_e('Call Now', 'quick-brake-repair-theme'); ?></a>
                    <a class="button button--secondary" href="#contact-request"><?php esc_html_e('Free Quote', 'quick-brake-repair-theme'); ?></a>
                </div>
                <?php
                qbr_render_hero_stats(
                    array(
                        array('value' => __('Free quote', 'quick-brake-repair-theme'), 'label' => __('before scheduling', 'quick-brake-repair-theme')),
                        array('value' => __('Mon - Sat', 'quick-brake-repair-theme'), 'label' => __('8:00 am - 7:00 pm', 'quick-brake-repair-theme')),
                        array('value' => __('Mobile-first', 'quick-brake-repair-theme'), 'label' => __('appointments at your location', 'quick-brake-repair-theme')),
                    )
                );
                ?>
            </div>
            <article class="card card--contact-direct">
                <h2><?php esc_html_e('Talk to Quick Brake Repair', 'quick-brake-repair-theme'); ?></h2>
                <ul class="contact-list contact-list--direct">
                    <li><strong><?php esc_html_e('Call', 'quick-brake-repair-theme'); ?></strong><a href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php echo esc_html(isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : ''); ?></a></li>
                    <li>
                        <strong><?php esc_html_e('Email', 'quick-brake-repair-theme'); ?></strong>
                        <ul class="footer-list">
                            <?php foreach ((array) (isset($site['emails']) ? $site['emails'] : array()) as $email) : ?>
                                <li><a href="mailto:<?php echo esc_attr((string) $email); ?>"><?php echo esc_html((string) $email); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li><strong><?php esc_html_e('Location', 'quick-brake-repair-theme'); ?></strong><span><?php echo esc_html(trim((isset($site['city']) ? (string) $site['city'] : '') . ' ' . (isset($site['postalCode']) ? (string) $site['postalCode'] : ''))); ?></span></li>
                    <li><strong><?php esc_html_e('Hours', 'quick-brake-repair-theme'); ?></strong><span><?php esc_html_e('Mon - Sat: 8:00 am - 7:00 pm', 'quick-brake-repair-theme'); ?><br><?php esc_html_e('Sunday: Closed', 'quick-brake-repair-theme'); ?></span></li>
                </ul>
            </article>
        </div>
        <aside id="contact-request" class="card hero-form-card" aria-labelledby="contact-request-heading">
            <span class="eyebrow"><?php esc_html_e('Request a quote', 'quick-brake-repair-theme'); ?></span>
            <h2 id="contact-request-heading"><?php esc_html_e('Share the vehicle issue first', 'quick-brake-repair-theme'); ?></h2>
            <p class="contact-note"><?php echo esc_html(isset($page['formNotice']) ? (string) $page['formNotice'] : ''); ?></p>
            <div class="form-status" data-form-status hidden role="status" aria-live="polite"></div>
            <form class="contact-form" action="<?php echo esc_url(isset($site['contactForm']['action']) ? (string) $site['contactForm']['action'] : ''); ?>" method="post">
                <input type="hidden" name="_subject" value="<?php echo esc_attr(isset($site['contactForm']['subject']) ? (string) $site['contactForm']['subject'] : ''); ?>">
                <input type="hidden" name="_cc" value="<?php echo esc_attr(isset($site['contactForm']['cc']) ? (string) $site['contactForm']['cc'] : ''); ?>">
                <input type="hidden" name="_template" value="<?php echo esc_attr(isset($site['contactForm']['template']) ? (string) $site['contactForm']['template'] : ''); ?>">
                <input type="hidden" name="_next" value="<?php echo esc_attr($status_next_url); ?>">
                <label class="form-honeypot" aria-hidden="true"><span><?php esc_html_e('Leave this field empty', 'quick-brake-repair-theme'); ?></span><input type="text" name="_honey" tabindex="-1" autocomplete="off"></label>
                <div class="contact-form__grid">
                    <label class="contact-form__field"><span><?php esc_html_e('Name', 'quick-brake-repair-theme'); ?></span><input type="text" name="name" required></label>
                    <label class="contact-form__field"><span><?php esc_html_e('Phone', 'quick-brake-repair-theme'); ?></span><input type="tel" name="phone" required></label>
                    <label class="contact-form__field"><span><?php esc_html_e('Email', 'quick-brake-repair-theme'); ?></span><input type="email" name="email" required></label>
                    <label class="contact-form__field"><span><?php esc_html_e('Vehicle', 'quick-brake-repair-theme'); ?></span><input type="text" name="vehicle" placeholder="<?php esc_attr_e('Year, make, model', 'quick-brake-repair-theme'); ?>"></label>
                </div>
                <label class="contact-form__field contact-form__field--full"><span><?php esc_html_e('Service location', 'quick-brake-repair-theme'); ?></span><input type="text" name="service_location" placeholder="<?php esc_attr_e('City or address', 'quick-brake-repair-theme'); ?>"></label>
                <label class="contact-form__field contact-form__field--full"><span><?php esc_html_e('What are you noticing?', 'quick-brake-repair-theme'); ?></span><textarea name="symptoms" rows="5" placeholder="<?php esc_attr_e('Noise, pulling, warning light, soft pedal, grinding, etc.', 'quick-brake-repair-theme'); ?>"></textarea></label>
                <button class="button button--primary contact-form__submit" type="submit"><?php esc_html_e('Send Request', 'quick-brake-repair-theme'); ?></button>
            </form>
        </aside>
    </div>
</section>
<section class="content-section shell section--contact-intro">
    <div class="section-layout section-layout--contact-intro">
        <div class="contact-intro__copy">
            <div class="section-heading">
                <h2><?php echo esc_html(isset($page['introHeading']) ? (string) $page['introHeading'] : ''); ?></h2>
            </div>
            <div class="content-stack">
                <?php qbr_render_paragraphs(isset($page['introParagraphs']) ? (array) $page['introParagraphs'] : array()); ?>
            </div>
        </div>
        <figure class="contact-intro__media">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Quick Brake Repair technician removing a wheel at a customer location', 'quick-brake-repair-theme'); ?>" loading="lazy" width="4032" height="3024">
        </figure>
    </div>
</section>
