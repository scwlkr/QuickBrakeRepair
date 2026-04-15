import { collections, getPageBySlug } from "../data/index.mjs";
import { escapeHtml, renderParagraphs } from "../lib/html.mjs";
import { relativeAssetUrl, relativePageUrl } from "../lib/site-paths.mjs";
import { renderHeroCard } from "../partials/chrome.mjs";

function renderHeroStats(stats = []) {
  if (!stats.length) {
    return "";
  }

  return `<div class="hero-stats">${stats
    .map(
      (stat) =>
        `<div class="hero-stat"><strong>${escapeHtml(stat.value)}</strong><span>${escapeHtml(
          stat.label,
        )}</span></div>`,
    )
    .join("")}</div>`;
}

function renderStandardHero(page, site, options = {}) {
  const secondaryHref = options.secondaryHref ?? relativePageUrl(page.slug, "contact");

  return `<section class="hero">
    <div class="shell hero__grid">
      <div class="hero__content">
        <h1>${escapeHtml(page.hero.title)}</h1>
        <p class="hero__summary">${escapeHtml(page.hero.summary)}</p>
        <div class="hero__actions">
          <a class="button button--primary" href="${escapeHtml(site.phoneHref)}">Call Now</a>
          <a class="button button--secondary" href="${escapeHtml(secondaryHref)}">Request a Quote</a>
        </div>
        ${renderHeroStats(options.stats)}
      </div>
      ${renderHeroCard(page, site)}
    </div>
  </section>`;
}

function renderContentSection(title, paragraphs, className = "") {
  return `<section class="content-section shell${className ? ` ${className}` : ""}">
    <div class="section-heading">
      <h2>${escapeHtml(title)}</h2>
    </div>
    <div class="content-stack">${renderParagraphs(paragraphs)}</div>
  </section>`;
}

function renderArticleCards(page, linkLabel) {
  return collections.articlePages
    .map(
      (articlePage) => `<article class="card card--resource">
        <p class="card__meta">${escapeHtml(articlePage.publishedLabel)}</p>
        <h3>${escapeHtml(articlePage.title)}</h3>
        <p>${escapeHtml(articlePage.metaDescription)}</p>
        <a class="text-link" href="${relativePageUrl(page.slug, articlePage.slug)}">${escapeHtml(
          linkLabel,
        )}</a>
      </article>`,
    )
    .join("");
}

function renderHome(page, site) {
  const heroPosterUrl = relativeAssetUrl(page.slug, "assets/generated/hero-poster.jpg");
  const heroVideoUrl = relativeAssetUrl(page.slug, "assets/generated/hero-loop.mp4");
  const introBadgeUrl = relativeAssetUrl(page.slug, "assets/ase-certified-1.svg");
  const premiumImageUrl = relativeAssetUrl(page.slug, "assets/img-premium.jpeg");
  const standardImageUrl = relativeAssetUrl(page.slug, "assets/img-standard.jpeg");
  const testimonials = site.testimonials
    .map((testimonial, index) => {
      const leadClass = index === 0 ? " testimonial--lead" : "";
      return `<blockquote class="testimonial${leadClass}">
            <p>“${escapeHtml(testimonial.quote)}”</p>
            <footer>${escapeHtml(testimonial.author)}</footer>
          </blockquote>`;
    })
    .join("");
  const coverageLinks = collections.serviceAreaPages
    .map(
      (serviceAreaPage) => `<a class="coverage-link" href="${relativePageUrl(
        page.slug,
        serviceAreaPage.slug,
      )}">
            <span class="coverage-link__eyebrow">${escapeHtml(serviceAreaPage.eyebrow)}</span>
            <strong>${escapeHtml(serviceAreaPage.heroTitle)}</strong>
            <span>${escapeHtml(serviceAreaPage.heroSummary)}</span>
          </a>`,
    )
    .join("");

  return `
    <section class="hero hero--home">
      <div class="hero__media" aria-hidden="true">
        <video class="hero-video" autoplay muted loop playsinline poster="${escapeHtml(heroPosterUrl)}">
          <source src="${escapeHtml(heroVideoUrl)}" type="video/mp4">
        </video>
        <div class="hero__art-mask"></div>
        <div class="hero__art-rotor-glint"></div>
        <div class="hero__art-rotor"></div>
      </div>
      <div class="shell hero__layout">
        <div class="hero__content">
          <h1>${escapeHtml(page.hero.title)}</h1>
          <p class="hero__summary">${escapeHtml(page.hero.summary)}</p>
          <div class="hero__actions">
            <a class="button button--primary" href="${escapeHtml(site.phoneHref)}">Call Now</a>
            <a class="button button--secondary" href="${relativePageUrl(page.slug, "contact")}">Request a Quote</a>
          </div>
          <div class="hero-stats"><div class="hero-stat"><strong>${escapeHtml(
            site.yearsServing,
          )}</strong><span>serving Dallas drivers</span></div><div class="hero-stat"><strong>Service area</strong><span>Dallas and surrounding communities</span></div><div class="hero-stat"><strong>Same-day</strong><span>mobile scheduling when available</span></div></div>
        </div>
        <aside class="hero__support">
          <p class="hero__support-title">On-site diagnostics and repair</p>
          <p class="hero__support-copy">Brake pads, rotors, calipers, hoses, fluid service, and inspection support without the tow or waiting room.</p>
          <dl class="hero__details">
            <div><dt>Coverage</dt><dd>Dallas and surrounding service areas</dd></div>
            <div><dt>Hours</dt><dd>Mon - Sat, 8:00 am - 7:00 pm</dd></div>
            <div><dt>Need help fast?</dt><dd><a href="${escapeHtml(site.phoneHref)}">${escapeHtml(
    site.phoneDisplay,
  )}</a></dd></div>
          </dl>
        </aside>
      </div>
    </section>
    <section class="content-section section--intro shell">
      <div class="section-layout section-layout--intro-visual">
        <div class="section-heading">
          <h2>${escapeHtml(page.introHeading)}</h2>
        </div>
        <div class="content-stack">${renderParagraphs(page.introParagraphs)}</div>
        <figure class="section-visual section-visual--intro section-visual--badge">
          <img class="section-visual__image section-visual__image--intro section-visual__image--badge" src="${escapeHtml(
            introBadgeUrl,
          )}" alt="ASE-certified badge" loading="lazy" width="2500" height="2500">
        </figure>
      </div>
    </section>
    <section class="panel section--services shell">
      <div class="section-heading">
        <h2>Optimal brakes for optimal performance</h2>
      </div>
      <div class="service-grid">
        <article class="service-pane">
          <div class="service-pane__layout">
            <div class="service-pane__copy">
              <h3>${escapeHtml(page.serviceCards[0].title)}</h3>
              <p>${escapeHtml(page.serviceCards[0].body)}</p>
              <a class="text-link" href="${relativePageUrl(page.slug, "premium")}">Learn more</a>
            </div>
            <figure class="service-pane__visual service-pane__visual--premium">
              <img class="service-pane__image service-pane__image--premium" src="${escapeHtml(
                premiumImageUrl,
              )}" alt="Premium brake rotor and blue caliper during service" loading="lazy" width="1000" height="667">
              <figcaption>Premium-grade parts and cleaning</figcaption>
            </figure>
          </div>
        </article>
        <article class="service-pane">
          <div class="service-pane__layout">
            <div class="service-pane__copy">
              <h3>${escapeHtml(page.serviceCards[1].title)}</h3>
              <p>${escapeHtml(page.serviceCards[1].body)}</p>
              <a class="text-link" href="${relativePageUrl(page.slug, "standard")}">Learn more</a>
            </div>
            <figure class="service-pane__visual service-pane__visual--standard">
              <img class="service-pane__image service-pane__image--standard" src="${escapeHtml(
                standardImageUrl,
              )}" alt="Technician servicing a standard brake rotor and caliper" loading="lazy" width="1000" height="668">
              <figcaption>Pads, rotors, calipers, hoses</figcaption>
            </figure>
          </div>
        </article>
      </div>
    </section>
    <section class="content-section section--trust shell">
      <div class="section-layout">
        <div class="section-heading">
          <h2>${escapeHtml(page.convenienceHeading)}</h2>
        </div>
        <div class="content-stack">${renderParagraphs(page.convenienceParagraphs)}<ul class="check-list">${page.convenienceBullets
          .map((bullet) => `<li>${escapeHtml(bullet)}</li>`)
          .join("")}</ul></div>
      </div>
    </section>
    <section class="content-section section--safety shell">
      <div class="section-layout">
        <div class="section-heading">
          <h2>${escapeHtml(page.safetyHeading)}</h2>
        </div>
        <div class="content-stack">${renderParagraphs(page.safetyParagraphs)}</div>
      </div>
    </section>
    <section class="panel section--coverage shell">
      <div class="coverage-block">
        <div class="section-heading">
          <h2>Serving drivers where the vehicle already is</h2>
        </div>
        <div class="coverage-grid">${coverageLinks}</div>
      </div>
    </section>
    <section class="panel section--reviews shell">
      <div class="reviews-showcase">
        <div class="reviews-summary">
          <div class="section-heading">
            <span class="eyebrow">${escapeHtml(site.reviewHeading)}</span>
            <h2>Drivers already trust the mobile model</h2>
            <p>Read recent feedback from Dallas-area customers, then open our Google profile to leave a review after your service.</p>
          </div>
          <div class="reviews-score" aria-label="Five out of five stars from Google reviews">
            <span class="reviews-score__eyebrow">Google rating</span>
            <div class="reviews-score__headline">
              <strong>${escapeHtml(site.reviewRating)}</strong>
              <span class="reviews-score__stars" aria-hidden="true">★★★★★</span>
            </div>
            <p>${escapeHtml(site.reviewSummary)}</p>
          </div>
          <ul class="reviews-points" aria-label="Reasons customers mention in reviews">
            ${site.reviewPoints.map((point) => `<li>${escapeHtml(point)}</li>`).join("")}
          </ul>
          <a class="button button--secondary reviews-link" href="${escapeHtml(
            site.reviewLink,
          )}" target="_blank" rel="noopener noreferrer">Leave a Google review</a>
        </div>
        <div class="testimonial-grid">${testimonials}</div>
      </div>
    </section>
    <section class="panel section--resources shell">
      <div class="section-heading">
        <h2>Readable answers to common brake questions</h2>
      </div>
      <div class="card-grid card-grid--three">${renderArticleCards(page, "Read article")}</div>
    </section>
  `;
}

function renderService(page, site) {
  const secondaryTitle = page.slug === "premium" ? "Premium extras" : "What to expect";

  return `
    ${renderStandardHero(page, site, {
      stats: [
        { value: "On-site", label: "appointments across Dallas" },
        { value: "All vehicle types", label: "cars, trucks, SUVs, vans" },
        { value: "Quote first", label: "before scheduling" },
      ],
    })}
    ${renderContentSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <h2>${escapeHtml(page.includedHeading)}</h2>
      </div>
      <div class="split-grid">
        <article class="card">
          <h3>Core repair work</h3>
          <p>${escapeHtml(page.includedParagraphs[0])}</p>
          <ul class="check-list">${page.standardList
            .map((item) => `<li>${escapeHtml(item)}</li>`)
            .join("")}</ul>
        </article>
        <article class="card">
          <h3>${escapeHtml(secondaryTitle)}</h3>
          <p>${escapeHtml(page.outro)}</p>
          <ul class="check-list">${page.premiumList
            .map((item) => `<li>${escapeHtml(item)}</li>`)
            .join("")}</ul>
        </article>
      </div>
    </section>
  `;
}

function renderAreas(page, site) {
  const cards = collections.serviceAreaPages
    .map(
      (serviceAreaPage) => `<article class="card card--city">
        <h3>${escapeHtml(serviceAreaPage.heroTitle)}</h3>
        <p>${escapeHtml(serviceAreaPage.metaDescription)}</p>
        <a class="text-link" href="${relativePageUrl(page.slug, serviceAreaPage.slug)}">View ${escapeHtml(
          serviceAreaPage.title,
        )}</a>
      </article>`,
    )
    .join("");

  return `
    ${renderStandardHero(page, site)}
    ${renderContentSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <h2>Preserved city URLs, rebuilt with better internal navigation</h2>
      </div>
      <div class="card-grid card-grid--three">${cards}</div>
    </section>
  `;
}

function renderResources(page, site) {
  return `
    ${renderStandardHero(page, site)}
    ${renderContentSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <h2>Browse brake repair guides by topic</h2>
      </div>
      <div class="card-grid card-grid--three">${renderArticleCards(page, "Read resource")}</div>
    </section>
    <section class="panel shell">
      <div class="section-heading">
        <span class="eyebrow">FAQ</span>
        <h2>Common mobile brake service questions</h2>
        <p>Use these quick answers to understand what to expect before scheduling an on-site appointment.</p>
      </div>
      <div class="faq-list">${page.faqItems
        .map(
          (item) => `<details class="faq-item">
          <summary>${escapeHtml(item.question)}</summary>
          <p>${escapeHtml(item.answer)}</p>
        </details>`,
        )
        .join("")}</div>
    </section>
  `;
}

function renderContact(page, site) {
  const imageUrl = relativeAssetUrl(page.slug, "assets/img-luke.jpeg");
  const statusNextUrl = site.contactForm.next;

  return `
    <section class="hero">
      <div class="shell hero__grid">
        <div class="contact-hero__primary">
          <div class="hero__content">
            <h1>${escapeHtml(page.hero.title)}</h1>
            <p class="hero__summary">${escapeHtml(page.hero.summary)}</p>
            <div class="hero__actions">
              <a class="button button--primary" href="${escapeHtml(site.phoneHref)}">Call Now</a>
              <a class="button button--secondary" href="#contact-request">Request a Quote</a>
            </div>
            ${renderHeroStats([
              { value: "Free quote", label: "before scheduling" },
              { value: "Mon - Sat", label: "8:00 am - 7:00 pm" },
              { value: "Mobile-first", label: "appointments at your location" },
            ])}
          </div>
          <article class="card card--contact-direct">
            <h2>Talk to Quick Brake Repair</h2>
            <ul class="contact-list contact-list--direct">
              <li><strong>Call</strong><a href="${escapeHtml(site.phoneHref)}">${escapeHtml(site.phoneDisplay)}</a></li>
              <li><strong>Email</strong><ul class="footer-list">${site.emails
                .map(
                  (email) =>
                    `<li><a href="mailto:${escapeHtml(email)}">${escapeHtml(email)}</a></li>`,
                )
                .join("")}</ul></li>
              <li><strong>Location</strong><span>${escapeHtml(`${site.city} ${site.postalCode}`)}</span></li>
              <li><strong>Hours</strong><span>Mon - Sat: 8:00 am - 7:00 pm<br>Sunday: Closed</span></li>
            </ul>
          </article>
        </div>
        <aside id="contact-request" class="card hero-form-card" aria-labelledby="contact-request-heading">
          <span class="eyebrow">Request a quote</span>
          <h2 id="contact-request-heading">Share the vehicle issue first</h2>
          <p class="contact-note">${escapeHtml(page.formNotice)}</p>
          <div class="form-status" data-form-status hidden role="status" aria-live="polite"></div>
          <form class="contact-form" action="${escapeHtml(site.contactForm.action)}" method="post">
            <input type="hidden" name="_subject" value="${escapeHtml(site.contactForm.subject)}">
            <input type="hidden" name="_cc" value="${escapeHtml(site.contactForm.cc)}">
            <input type="hidden" name="_template" value="${escapeHtml(site.contactForm.template)}">
            <input type="hidden" name="_next" value="${escapeHtml(statusNextUrl)}">
            <label class="form-honeypot" aria-hidden="true"><span>Leave this field empty</span><input type="text" name="_honey" tabindex="-1" autocomplete="off"></label>
            <label class="contact-form__field"><span>Name</span><input type="text" name="name" required></label>
            <label class="contact-form__field"><span>Phone</span><input type="tel" name="phone" required></label>
            <label class="contact-form__field"><span>Email</span><input type="email" name="email" required></label>
            <label class="contact-form__field"><span>Vehicle</span><input type="text" name="vehicle" placeholder="Year, make, model"></label>
            <label class="contact-form__field contact-form__field--full"><span>Service location</span><input type="text" name="service_location" placeholder="City or address"></label>
            <label class="contact-form__field contact-form__field--full"><span>What are you noticing?</span><textarea name="symptoms" rows="5" placeholder="Noise, pulling, warning light, soft pedal, grinding, etc."></textarea></label>
            <button class="button button--primary contact-form__submit" type="submit">Send Request</button>
          </form>
        </aside>
      </div>
    </section>
    <section class="content-section shell section--contact-intro">
      <div class="section-layout section-layout--contact-intro">
        <div class="contact-intro__copy">
          <div class="section-heading">
            <h2>${escapeHtml(page.introHeading)}</h2>
          </div>
          <div class="content-stack">${renderParagraphs(page.introParagraphs)}</div>
        </div>
        <figure class="contact-intro__media">
          <img src="${escapeHtml(imageUrl)}" alt="Quick Brake Repair technician removing a wheel at a customer's location" loading="lazy" width="4032" height="3024">
        </figure>
      </div>
    </section>
  `;
}

function renderLocation(page, site) {
  const relatedArticle = collections.articlePages.find(
    (articlePage) => articlePage.relatedSlug === page.slug,
  );
  const relatedLinks = relatedArticle
    ? `<div class="related-links">
            <h3>Related resources</h3>
            <ul class="footer-list"><li><a href="${relativePageUrl(
              page.slug,
              relatedArticle.slug,
            )}">${escapeHtml(relatedArticle.title)}</a></li></ul>
          </div>`
    : "";

  return `
    ${renderStandardHero(page, site, {
      stats: [
        { value: page.title.replace(", TX", ""), label: "on-site service area" },
        { value: "On-site", label: "repair and diagnostic work" },
        { value: "Upfront", label: "quote before scheduling" },
      ],
    })}
    ${renderContentSection(page.overviewHeading, page.overviewParagraphs)}
    ${renderContentSection(page.detailHeading, page.detailParagraphs)}
    <section class="panel shell">
      <div class="split-grid">
        <article class="card">
          <h2>${escapeHtml(page.bulletHeading)}</h2>
          <ul class="check-list">${page.bullets
            .map((bullet) => `<li>${escapeHtml(bullet)}</li>`)
            .join("")}</ul>
        </article>
        <article class="card">
          <h2>Talk through the symptoms before you drive farther</h2>
          <p>${escapeHtml(page.closing)}</p>
          <a class="button button--primary" href="${escapeHtml(site.phoneHref)}">Call ${escapeHtml(
    site.phoneDisplay,
  )}</a>
          ${relatedLinks}
        </article>
      </div>
    </section>
  `;
}

function renderArticle(page, site) {
  const relatedPage = getPageBySlug(page.relatedSlug);
  const relatedCard = relatedPage
    ? `<div class="card">
          <h2>${escapeHtml(relatedPage.title)}</h2>
          <p>${escapeHtml(relatedPage.metaDescription)}</p>
          <a class="text-link" href="${relativePageUrl(page.slug, relatedPage.slug)}">Visit ${escapeHtml(
            relatedPage.title,
          )}</a>
        </div>`
    : "";

  return `
    ${renderStandardHero(page, site, {
      stats: [
        { value: page.publishedLabel, label: "published date" },
        { value: "Resource", label: "on-site brake guide" },
        { value: "Dallas area", label: "on-site brake service" },
      ],
    })}
    <section class="content-section shell">
      <div class="section-heading">
        <h2>${escapeHtml(page.title)}</h2>
      </div>
      <div class="content-stack">
        <p>${escapeHtml(page.intro)}</p>
      </div>
    </section>
    <section class="article-layout shell">
      <div class="article-copy">${page.sections
        .map(
          (section) => `<article class="article-block">
        <h2>${escapeHtml(section.question)}</h2>
        ${renderParagraphs(section.answer)}
      </article>`,
        )
        .join("")}</div>
      <aside class="article-sidebar">
        <div class="card">
          <h2>Get a mobile quote first</h2>
          <p>${escapeHtml(page.closing)}</p>
          <a class="button button--primary" href="${escapeHtml(site.phoneHref)}">Call ${escapeHtml(
    site.phoneDisplay,
  )}</a>
        </div>
        ${relatedCard}
      </aside>
    </section>
  `;
}

export function renderPageBody(page, site) {
  switch (page.kind) {
    case "home":
      return renderHome(page, site);
    case "service":
      return renderService(page, site);
    case "areas":
      return renderAreas(page, site);
    case "resources":
      return renderResources(page, site);
    case "contact":
      return renderContact(page, site);
    case "location":
      return renderLocation(page, site);
    case "article":
      return renderArticle(page, site);
    default:
      return renderContentSection(page.hero.title, [page.hero.summary]);
  }
}
