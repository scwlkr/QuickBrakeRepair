<?php
/**
 * Home page template part.
 *
 * @package QuickBrakeRepairTheme
 */

$page          = isset($args['page']) && is_array($args['page']) ? $args['page'] : array();
$site          = qbr_get_site_data();
$service_areas = qbr_get_service_area_pages();
$articles      = qbr_get_article_pages();
$hero_poster   = qbr_get_theme_image_uri('hero-poster.jpg');
$hero_video    = qbr_get_theme_image_uri('hero-loop.mp4');
$intro_badge   = qbr_get_theme_image_uri('ase-certified-1.svg');
$premium_image = qbr_get_theme_image_uri('img-premium.jpeg');
$standard_image = qbr_get_theme_image_uri('img-standard.jpeg');
?>
<section class="hero hero--home">
    <div class="hero__media" aria-hidden="true">
        <video class="hero-video" autoplay muted loop playsinline poster="<?php echo esc_url($hero_poster); ?>">
            <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
        </video>
        <div class="hero__art-mask"></div>
        <div class="hero__art-rotor-glint"></div>
        <div class="hero__art-rotor"></div>
    </div>
    <div class="shell hero__layout">
        <div class="hero__content">
            <h1><?php echo esc_html(isset($page['heroTitle']) ? (string) $page['heroTitle'] : get_bloginfo('name')); ?></h1>
            <p class="hero__summary"><?php echo esc_html(isset($page['heroSummary']) ? (string) $page['heroSummary'] : ''); ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php esc_html_e('Call Now', 'quick-brake-repair-theme'); ?></a>
                <a class="button button--secondary button--home-quote" href="<?php echo esc_url(qbr_get_mapped_permalink('contact', 'page')); ?>"><?php esc_html_e('Free Quote', 'quick-brake-repair-theme'); ?></a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong><?php echo esc_html(isset($site['yearsServing']) ? (string) $site['yearsServing'] : ''); ?></strong>
                    <span><?php esc_html_e('serving Dallas drivers', 'quick-brake-repair-theme'); ?></span>
                </div>
                <div class="hero-stat">
                    <strong><?php esc_html_e('Service area', 'quick-brake-repair-theme'); ?></strong>
                    <span><?php esc_html_e('Dallas and surrounding communities', 'quick-brake-repair-theme'); ?></span>
                </div>
                <div class="hero-stat">
                    <strong><?php esc_html_e('Same-day', 'quick-brake-repair-theme'); ?></strong>
                    <span><?php esc_html_e('mobile scheduling when available', 'quick-brake-repair-theme'); ?></span>
                </div>
            </div>
        </div>
        <aside class="hero__support">
            <p class="hero__support-title"><?php esc_html_e('On-site diagnostics and repair', 'quick-brake-repair-theme'); ?></p>
            <p class="hero__support-copy"><?php esc_html_e('Brake pads, rotors, calipers, hoses, fluid service, and inspection support without the tow or waiting room.', 'quick-brake-repair-theme'); ?></p>
            <dl class="hero__details">
                <div>
                    <dt><?php esc_html_e('Coverage', 'quick-brake-repair-theme'); ?></dt>
                    <dd><?php esc_html_e('Dallas and surrounding service areas', 'quick-brake-repair-theme'); ?></dd>
                </div>
                <div>
                    <dt><?php esc_html_e('Hours', 'quick-brake-repair-theme'); ?></dt>
                    <dd><?php esc_html_e('Mon - Sat, 8:00 am - 7:00 pm', 'quick-brake-repair-theme'); ?></dd>
                </div>
                <div>
                    <dt><?php esc_html_e('Need help fast?', 'quick-brake-repair-theme'); ?></dt>
                    <dd><a href="<?php echo esc_url(isset($site['phoneHref']) ? (string) $site['phoneHref'] : '#'); ?>"><?php echo esc_html(isset($site['phoneDisplay']) ? (string) $site['phoneDisplay'] : ''); ?></a></dd>
                </div>
            </dl>
        </aside>
    </div>
</section>
<section class="panel section--reviews shell">
    <div class="reviews-showcase">
        <div class="reviews-summary">
            <div class="section-heading">
                <span class="eyebrow"><?php echo esc_html(isset($site['reviewHeading']) ? (string) $site['reviewHeading'] : ''); ?></span>
                <h2><?php esc_html_e('Drivers already trust the mobile model', 'quick-brake-repair-theme'); ?></h2>
                <p><?php esc_html_e('Read recent feedback from Dallas-area customers, then open our Google profile to leave a review after your service.', 'quick-brake-repair-theme'); ?></p>
            </div>
            <div class="reviews-score" aria-label="<?php esc_attr_e('Five out of five stars from Google reviews', 'quick-brake-repair-theme'); ?>">
                <span class="reviews-score__eyebrow"><?php esc_html_e('Google rating', 'quick-brake-repair-theme'); ?></span>
                <div class="reviews-score__headline">
                    <strong><?php echo esc_html(isset($site['reviewRating']) ? (string) $site['reviewRating'] : '5.0'); ?></strong>
                    <span class="reviews-score__stars" aria-hidden="true">★★★★★</span>
                </div>
                <p><?php echo esc_html(isset($site['reviewSummary']) ? (string) $site['reviewSummary'] : ''); ?></p>
            </div>
            <ul class="reviews-points" aria-label="<?php esc_attr_e('Reasons customers mention in reviews', 'quick-brake-repair-theme'); ?>">
                <?php foreach ((array) (isset($site['reviewPoints']) ? $site['reviewPoints'] : array()) as $point) : ?>
                    <li><?php echo esc_html((string) $point); ?></li>
                <?php endforeach; ?>
            </ul>
            <a class="button button--secondary reviews-link" href="<?php echo esc_url(isset($site['reviewLink']) ? (string) $site['reviewLink'] : '#'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Leave a Google review', 'quick-brake-repair-theme'); ?></a>
        </div>
        <div class="testimonial-grid">
            <?php foreach ((array) (isset($site['testimonials']) ? $site['testimonials'] : array()) as $index => $testimonial) : ?>
                <blockquote class="testimonial<?php echo 0 === $index ? ' testimonial--lead' : ''; ?>">
                    <p><?php echo esc_html('“' . (isset($testimonial['quote']) ? (string) $testimonial['quote'] : '') . '”'); ?></p>
                    <footer><?php echo esc_html(isset($testimonial['author']) ? (string) $testimonial['author'] : ''); ?></footer>
                </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="content-section section--intro shell">
    <div class="section-layout section-layout--intro-visual">
        <div class="section-heading">
            <h2><?php echo esc_html(isset($page['introHeading']) ? (string) $page['introHeading'] : ''); ?></h2>
        </div>
        <div class="content-stack">
            <?php qbr_render_paragraphs(isset($page['introParagraphs']) ? (array) $page['introParagraphs'] : array()); ?>
        </div>
        <figure class="section-visual section-visual--intro section-visual--badge">
            <img class="section-visual__image section-visual__image--intro section-visual__image--badge" src="<?php echo esc_url($intro_badge); ?>" alt="<?php esc_attr_e('ASE-certified badge', 'quick-brake-repair-theme'); ?>" loading="lazy" width="2500" height="2500">
        </figure>
    </div>
</section>
<section class="panel section--services shell">
    <div class="section-heading">
        <h2><?php esc_html_e('Optimal brakes for optimal performance', 'quick-brake-repair-theme'); ?></h2>
    </div>
    <div class="service-grid">
        <article class="service-pane">
            <div class="service-pane__layout">
                <div class="service-pane__copy">
                    <h3><?php echo esc_html(isset($page['serviceCards'][0]['title']) ? (string) $page['serviceCards'][0]['title'] : ''); ?></h3>
                    <p><?php echo esc_html(isset($page['serviceCards'][0]['body']) ? (string) $page['serviceCards'][0]['body'] : ''); ?></p>
                    <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('premium', 'page')); ?>"><?php esc_html_e('Learn more', 'quick-brake-repair-theme'); ?></a>
                </div>
                <figure class="service-pane__visual service-pane__visual--premium">
                    <img class="service-pane__image service-pane__image--premium" src="<?php echo esc_url($premium_image); ?>" alt="<?php esc_attr_e('Premium brake rotor and blue caliper during service', 'quick-brake-repair-theme'); ?>" loading="lazy" width="1000" height="667">
                    <figcaption><?php esc_html_e('Premium-grade parts and cleaning', 'quick-brake-repair-theme'); ?></figcaption>
                </figure>
            </div>
        </article>
        <article class="service-pane">
            <div class="service-pane__layout">
                <div class="service-pane__copy">
                    <h3><?php echo esc_html(isset($page['serviceCards'][1]['title']) ? (string) $page['serviceCards'][1]['title'] : ''); ?></h3>
                    <p><?php echo esc_html(isset($page['serviceCards'][1]['body']) ? (string) $page['serviceCards'][1]['body'] : ''); ?></p>
                    <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink('standard', 'page')); ?>"><?php esc_html_e('Learn more', 'quick-brake-repair-theme'); ?></a>
                </div>
                <figure class="service-pane__visual service-pane__visual--standard">
                    <img class="service-pane__image service-pane__image--standard" src="<?php echo esc_url($standard_image); ?>" alt="<?php esc_attr_e('Technician servicing a standard brake rotor and caliper', 'quick-brake-repair-theme'); ?>" loading="lazy" width="1000" height="668">
                    <figcaption><?php esc_html_e('Pads, rotors, calipers, hoses', 'quick-brake-repair-theme'); ?></figcaption>
                </figure>
            </div>
        </article>
    </div>
</section>
<section class="content-section section--trust shell">
    <div class="section-layout">
        <div class="section-heading">
            <h2><?php echo esc_html(isset($page['convenienceHeading']) ? (string) $page['convenienceHeading'] : ''); ?></h2>
        </div>
        <div class="content-stack">
            <?php qbr_render_paragraphs(isset($page['convenienceParagraphs']) ? (array) $page['convenienceParagraphs'] : array()); ?>
            <?php qbr_render_checklist(isset($page['convenienceBullets']) ? (array) $page['convenienceBullets'] : array()); ?>
        </div>
    </div>
</section>
<section class="content-section section--safety shell">
    <div class="section-layout">
        <div class="section-heading">
            <h2><?php echo esc_html(isset($page['safetyHeading']) ? (string) $page['safetyHeading'] : ''); ?></h2>
        </div>
        <div class="content-stack">
            <?php qbr_render_paragraphs(isset($page['safetyParagraphs']) ? (array) $page['safetyParagraphs'] : array()); ?>
        </div>
    </div>
</section>
<section class="panel section--coverage shell">
    <div class="coverage-block">
        <div class="section-heading">
            <h2><?php esc_html_e('Serving drivers where the vehicle already is', 'quick-brake-repair-theme'); ?></h2>
        </div>
        <div class="coverage-grid">
            <?php foreach ($service_areas as $service_area) : ?>
                <a class="coverage-link" href="<?php echo esc_url(qbr_get_mapped_permalink((string) $service_area['slug'], 'service_area')); ?>">
                    <span class="coverage-link__eyebrow"><?php echo esc_html(isset($service_area['eyebrow']) ? (string) $service_area['eyebrow'] : ''); ?></span>
                    <strong><?php echo esc_html(isset($service_area['heroTitle']) ? (string) $service_area['heroTitle'] : ''); ?></strong>
                    <span><?php echo esc_html(isset($service_area['heroSummary']) ? (string) $service_area['heroSummary'] : ''); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="panel section--resources shell">
    <div class="section-heading">
        <h2><?php esc_html_e('Readable answers to common brake questions', 'quick-brake-repair-theme'); ?></h2>
    </div>
    <div class="card-grid card-grid--three">
        <?php foreach (array_slice($articles, 0, 6) as $article) : ?>
            <article class="card card--resource">
                <p class="card__meta"><?php echo esc_html(isset($article['publishedLabel']) ? (string) $article['publishedLabel'] : ''); ?></p>
                <h3><?php echo esc_html(isset($article['title']) ? (string) $article['title'] : ''); ?></h3>
                <p><?php echo esc_html(isset($article['metaDescription']) ? (string) $article['metaDescription'] : ''); ?></p>
                <a class="text-link" href="<?php echo esc_url(qbr_get_mapped_permalink((string) $article['slug'], 'post')); ?>"><?php esc_html_e('Read article', 'quick-brake-repair-theme'); ?></a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
