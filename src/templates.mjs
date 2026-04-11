import { collections, getPageBySlug } from "./content.mjs";

function navItems() {
  return [
    { href: "/", label: "Home" },
    { href: "/premium", label: "Premium" },
    { href: "/standard", label: "Standard" },
    { href: "/areas-we-serve", label: "Areas We Serve" },
    { href: "/resources", label: "Resources" },
    { href: "/contact", label: "Contact" },
  ];
}

function absoluteUrl(site, slug) {
  return slug ? `${site.url}/${slug}` : site.url;
}

function normalizeHref(href) {
  return href === "/" ? href : `${href}/`;
}

function isNavActive(page, item) {
  if (item.href === "/") {
    return page.slug === "";
  }

  if (item.href === "/areas-we-serve") {
    return page.template === "areas" || page.template === "location";
  }

  if (item.href === "/resources") {
    return page.template === "resources" || page.template === "article";
  }

  return page.slug === item.href.replace(/^\//, "");
}

function titleCase(value) {
  return value
    .split("-")
    .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
    .join(" ");
}

function renderLogo() {
  return `<div class="brand-mark" aria-hidden="true">
    <span class="brand-mark__core"></span>
    <span class="brand-mark__ring brand-mark__ring--one"></span>
    <span class="brand-mark__ring brand-mark__ring--two"></span>
    <span class="brand-mark__slice"></span>
  </div>`;
}

function renderHeader(page, site) {
  const links = navItems()
    .map(
      (item) => `<a class="site-nav__link${isNavActive(page, item) ? " is-active" : ""}" href="${normalizeHref(item.href)}">${item.label}</a>`,
    )
    .join("");

  return `<header class="site-header">
    <div class="site-header__inner shell">
      <a class="brand" href="/" aria-label="${site.name} home">
        ${renderLogo()}
        <span class="brand__text">
          <strong>${site.name}</strong>
          <span>Mobile brake repair across Dallas-area service zones</span>
        </span>
      </a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
        <span></span>
        <span></span>
        <span></span>
        <span class="sr-only">Toggle navigation</span>
      </button>
      <nav id="site-nav" class="site-nav" aria-label="Primary">
        ${links}
      </nav>
      <a class="call-pill" href="${site.phoneHref}">${site.phoneDisplay}</a>
    </div>
  </header>`;
}

function renderFooter(site) {
  const cities = collections.serviceAreaPages
    .map((page) => `<li><a href="/${page.slug}/">${page.title.replace(", TX", "")}</a></li>`)
    .join("");
  const resources = collections.articlePages
    .slice(0, 4)
    .map((page) => `<li><a href="/${page.slug}/">${page.title}</a></li>`)
    .join("");

  return `<footer class="site-footer">
    <div class="shell site-footer__grid">
      <section>
        <p class="eyebrow">Quick Brake Repair</p>
        <h2 class="footer-title">Mobile brake service designed around your day.</h2>
        <p class="footer-copy">ASE-certified technicians, on-site repair support, and clear next steps before you drive again.</p>
      </section>
      <section>
        <h2 class="footer-list-title">Contact</h2>
        <ul class="footer-list">
          <li><a href="${site.phoneHref}">${site.phoneDisplay}</a></li>
          <li><a href="mailto:${site.emails[0]}">${site.emails[0]}</a></li>
          <li>${site.city} ${site.postalCode}</li>
        </ul>
      </section>
      <section>
        <h2 class="footer-list-title">Service Areas</h2>
        <ul class="footer-list">${cities}</ul>
      </section>
      <section>
        <h2 class="footer-list-title">Resources</h2>
        <ul class="footer-list">${resources}</ul>
      </section>
    </div>
    <div class="shell site-footer__meta">
      <p>Mon - Sat: 8:00 am - 7:00 pm | Sunday: Closed | Overnight and weekend appointments available</p>
      <p>Copyright © ${site.name}. All Rights Reserved.</p>
    </div>
    <a class="floating-call" href="${site.phoneHref}">Call ${site.phoneDisplay}</a>
  </footer>`;
}

function renderBreadcrumbs(page) {
  if (!page.slug) {
    return "";
  }

  const crumbs = [
    `<a href="/">Home</a>`,
    ...page.slug.split("/").map((part, index, array) => {
      const slug = array.slice(0, index + 1).join("/");
      const isLast = index === array.length - 1;
      const linkedPage = getPageBySlug(slug);
      const label =
        page.slug === slug && page.heroTitle ? page.heroTitle : titleCase(part);

      if (isLast || !linkedPage) {
        return `<span>${label}</span>`;
      }

      return `<a href="/${slug}/">${linkedPage.heroTitle ?? linkedPage.title}</a>`;
    }),
  ];

  return `<nav class="breadcrumbs shell" aria-label="Breadcrumbs">${crumbs.join("<span>/</span>")}</nav>`;
}

function renderHero(page, site, options = {}) {
  const stats = options.stats
    ? `<div class="hero-stats">${options.stats
        .map(
          (stat) => `<div class="hero-stat"><strong>${stat.value}</strong><span>${stat.label}</span></div>`,
        )
        .join("")}</div>`
    : "";

  return `<section class="hero">
    <div class="shell hero__grid">
      <div class="hero__content">
        <p class="eyebrow">${page.eyebrow}</p>
        <h1>${page.heroTitle}</h1>
        <p class="hero__summary">${page.heroSummary}</p>
        <div class="hero__actions">
          <a class="button button--primary" href="${site.phoneHref}">Call Now</a>
          <a class="button button--secondary" href="/contact/">Request a Quote</a>
        </div>
        ${stats}
      </div>
      <aside class="hero-card">
        ${renderLogo()}
        <div class="hero-card__copy">
          <strong>On-site diagnostics and repair</strong>
          <p>Brake pads, rotors, calipers, hoses, fluid service, and inspection support without the tow or waiting room.</p>
        </div>
        <dl class="hero-card__facts">
          <div><dt>Coverage</dt><dd>${site.serviceAreaLabel}</dd></div>
          <div><dt>Hours</dt><dd>Mon - Sat, 8:00 am - 7:00 pm</dd></div>
          <div><dt>Need help fast?</dt><dd><a href="${site.phoneHref}">${site.phoneDisplay}</a></dd></div>
        </dl>
      </aside>
    </div>
  </section>`;
}

function renderSection(title, paragraphs, extra = "") {
  const body = paragraphs.map((paragraph) => `<p>${paragraph}</p>`).join("");
  return `<section class="content-section shell">
    <div class="section-heading">
      <p class="eyebrow">Built from the legacy page copy</p>
      <h2>${title}</h2>
    </div>
    <div class="content-stack">${body}${extra}</div>
  </section>`;
}

function renderHome(page, site) {
  const locations = collections.serviceAreaPages
    .map(
      (item) => `<article class="card card--city">
        <p class="eyebrow">${item.eyebrow}</p>
        <h3>${item.heroTitle}</h3>
        <p>${item.heroSummary}</p>
        <a class="text-link" href="/${item.slug}/">Explore the ${item.title.replace(", TX", "")} page</a>
      </article>`,
    )
    .join("");

  const resources = collections.articlePages
    .map(
      (item) => `<article class="card card--resource">
        <p class="card__meta">${item.publishedLabel}</p>
        <h3>${item.title}</h3>
        <p>${item.metaDescription}</p>
        <a class="text-link" href="/${item.slug}/">Read article</a>
      </article>`,
    )
    .join("");

  const testimonials = site.testimonials
    .map(
      (item) => `<blockquote class="testimonial">
        <p>“${item.quote}”</p>
        <footer>${item.author}</footer>
      </blockquote>`,
    )
    .join("");

  const serviceCards = page.serviceCards
    .map(
      (item) => `<article class="card card--service">
        <h3>${item.title}</h3>
        <p>${item.body}</p>
        <a class="text-link" href="${item.href}/">Learn more</a>
      </article>`,
    )
    .join("");

  const convenienceBullets = `<ul class="check-list">${page.convenienceBullets
    .map((bullet) => `<li>${bullet}</li>`)
    .join("")}</ul>`;

  return `
    ${renderHero(page, site, {
      stats: [
        { value: site.yearsServing, label: "serving Dallas drivers" },
        { value: "6 cities", label: "covered by core landing pages" },
        { value: "Same-day", label: "mobile scheduling when available" },
      ],
    })}
    ${renderSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Service paths</p>
        <h2>Optimal brakes for optimal performance</h2>
      </div>
      <div class="card-grid card-grid--two">${serviceCards}</div>
    </section>
    ${renderSection(page.convenienceHeading, page.convenienceParagraphs, convenienceBullets)}
    ${renderSection(page.safetyHeading, page.safetyParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Coverage</p>
        <h2>Serving drivers where the vehicle already is</h2>
      </div>
      <div class="card-grid card-grid--three">${locations}</div>
    </section>
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Reviews</p>
        <h2>Drivers already trust the mobile model</h2>
      </div>
      <div class="testimonial-grid">${testimonials}</div>
    </section>
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Resources</p>
        <h2>Readable answers to common brake questions</h2>
      </div>
      <div class="card-grid card-grid--three">${resources}</div>
    </section>
  `;
}

function renderService(page, site) {
  const standard = `<ul class="check-list">${page.standardList
    .map((item) => `<li>${item}</li>`)
    .join("")}</ul>`;
  const premium = `<ul class="check-list">${page.premiumList
    .map((item) => `<li>${item}</li>`)
    .join("")}</ul>`;

  return `
    ${renderHero(page, site, {
      stats: [
        { value: "On-site", label: "appointments across Dallas" },
        { value: "All vehicle types", label: "cars, trucks, SUVs, vans" },
        { value: "Quote first", label: "before scheduling" },
      ],
    })}
    ${renderSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Included services</p>
        <h2>${page.includedHeading}</h2>
      </div>
      <div class="split-grid">
        <article class="card">
          <h3>Core repair work</h3>
          <p>${page.includedParagraphs[0]}</p>
          ${standard}
        </article>
        <article class="card">
          <h3>${page.template === "service" && page.slug === "premium" ? "Premium extras" : "What to expect"}</h3>
          <p>${page.outro}</p>
          ${premium}
        </article>
      </div>
    </section>
  `;
}

function renderAreas(page, site) {
  const cards = collections.serviceAreaPages
    .map(
      (item) => `<article class="card card--city">
        <p class="eyebrow">${item.title}</p>
        <h3>${item.heroTitle}</h3>
        <p>${item.metaDescription}</p>
        <a class="text-link" href="/${item.slug}/">View ${item.title}</a>
      </article>`,
    )
    .join("");

  return `
    ${renderHero(page, site)}
    ${renderSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Location pages</p>
        <h2>Preserved city URLs, rebuilt with better internal navigation</h2>
      </div>
      <div class="card-grid card-grid--three">${cards}</div>
    </section>
  `;
}

function renderContact(page, site) {
  const emailLinks = site.emails
    .map((email) => `<li><a href="mailto:${email}">${email}</a></li>`)
    .join("");

  return `
    ${renderHero(page, site, {
      stats: [
        { value: "Free quote", label: "before scheduling" },
        { value: "Mon - Sat", label: "8:00 am - 7:00 pm" },
        { value: "Mobile-first", label: "appointments at your location" },
      ],
    })}
    ${renderSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="split-grid">
        <article class="card">
          <p class="eyebrow">Direct contact</p>
          <h2>Talk to Quick Brake Repair</h2>
          <ul class="contact-list">
            <li><strong>Call</strong><a href="${site.phoneHref}">${site.phoneDisplay}</a></li>
            <li><strong>Email</strong><ul class="footer-list">${emailLinks}</ul></li>
            <li><strong>Location</strong><span>${site.city} ${site.postalCode}</span></li>
            <li><strong>Hours</strong><span>Mon - Sat: 8:00 am - 7:00 pm<br>Sunday: Closed</span></li>
          </ul>
        </article>
        <article class="card">
          <p class="eyebrow">Request a quote</p>
          <h2>Share the vehicle issue first</h2>
          <p class="contact-note">${page.formNotice}</p>
          <form class="contact-form" action="mailto:${site.emails[0]}" method="post" enctype="text/plain">
            <label><span>Name</span><input type="text" name="name" required></label>
            <label><span>Phone</span><input type="tel" name="phone" required></label>
            <label><span>Email</span><input type="email" name="email" required></label>
            <label><span>Vehicle</span><input type="text" name="vehicle" placeholder="Year, make, model"></label>
            <label><span>Service location</span><input type="text" name="location" placeholder="City or address"></label>
            <label><span>What are you noticing?</span><textarea name="symptoms" rows="5" placeholder="Noise, pulling, warning light, soft pedal, grinding, etc."></textarea></label>
            <button class="button button--primary" type="submit">Email Request</button>
          </form>
        </article>
      </div>
    </section>
  `;
}

function renderResources(page, site) {
  const cards = collections.articlePages
    .map(
      (item) => `<article class="card card--resource">
        <p class="card__meta">${item.publishedLabel}</p>
        <h3>${item.title}</h3>
        <p>${item.heroSummary}</p>
        <a class="text-link" href="/${item.slug}/">Read resource</a>
      </article>`,
    )
    .join("");

  return `
    ${renderHero(page, site)}
    ${renderSection(page.introHeading, page.introParagraphs)}
    <section class="panel shell">
      <div class="section-heading">
        <p class="eyebrow">Article library</p>
        <h2>Preserved SEO resources with cleaner readability</h2>
      </div>
      <div class="card-grid card-grid--three">${cards}</div>
    </section>
  `;
}

function renderLocation(page, site) {
  const bullets = `<ul class="check-list">${page.bullets.map((item) => `<li>${item}</li>`).join("")}</ul>`;
  const relatedArticles = collections.articlePages
    .filter((item) => item.relatedSlug === page.slug || item.slug.includes(page.slug.split("/").pop()?.split("-")[0] ?? ""))
    .slice(0, 2)
    .map(
      (item) => `<li><a href="/${item.slug}/">${item.title}</a></li>`,
    )
    .join("");

  return `
    ${renderHero(page, site, {
      stats: [
        { value: page.title.replace(", TX", ""), label: "preserved service-area URL" },
        { value: "On-site", label: "repair and diagnostic work" },
        { value: "Upfront", label: "quote before scheduling" },
      ],
    })}
    ${renderSection(page.overviewHeading, page.overviewParagraphs)}
    ${renderSection(page.detailHeading, page.detailParagraphs)}
    <section class="panel shell">
      <div class="split-grid">
        <article class="card">
          <p class="eyebrow">Why it matters</p>
          <h2>${page.bulletHeading}</h2>
          ${bullets}
        </article>
        <article class="card">
          <p class="eyebrow">Next step</p>
          <h2>Talk through the symptoms before you drive farther</h2>
          <p>${page.closing}</p>
          <a class="button button--primary" href="${site.phoneHref}">Call ${site.phoneDisplay}</a>
          ${
            relatedArticles
              ? `<div class="related-links">
            <h3>Related resources</h3>
            <ul class="footer-list">${relatedArticles}</ul>
          </div>`
              : ""
          }
        </article>
      </div>
    </section>
  `;
}

function renderArticle(page, site) {
  const relatedPage = getPageBySlug(page.relatedSlug);
  const sections = page.sections
    .map(
      (section) => `<article class="article-block">
        <h2>${section.question}</h2>
        ${section.answer.map((paragraph) => `<p>${paragraph}</p>`).join("")}
      </article>`,
    )
    .join("");

  return `
    ${renderHero(page, site, {
      stats: [
        { value: page.publishedLabel, label: "published date" },
        { value: "Resource", label: "preserved ranking URL" },
        { value: "Dallas area", label: "mobile service context" },
      ],
    })}
    <section class="content-section shell">
      <div class="section-heading">
        <p class="eyebrow">Article overview</p>
        <h2>${page.title}</h2>
      </div>
      <div class="content-stack">
        <p>${page.intro}</p>
      </div>
    </section>
    <section class="article-layout shell">
      <div class="article-copy">${sections}</div>
      <aside class="article-sidebar">
        <div class="card">
          <p class="eyebrow">Need help now?</p>
          <h2>Get a mobile quote first</h2>
          <p>${page.closing}</p>
          <a class="button button--primary" href="${site.phoneHref}">Call ${site.phoneDisplay}</a>
        </div>
        ${
          relatedPage
            ? `<div class="card">
          <p class="eyebrow">Related city page</p>
          <h2>${relatedPage.title}</h2>
          <p>${relatedPage.metaDescription}</p>
          <a class="text-link" href="/${relatedPage.slug}/">Visit ${relatedPage.title}</a>
        </div>`
            : ""
        }
      </aside>
    </section>
  `;
}

function renderStructuredData(page, site) {
  const base = {
    "@context": "https://schema.org",
    "@type": "AutoRepair",
    name: site.name,
    url: absoluteUrl(site, page.slug),
    telephone: site.phoneDisplay,
    address: {
      "@type": "PostalAddress",
      addressLocality: "Dallas",
      addressRegion: "TX",
      postalCode: site.postalCode,
      addressCountry: "US",
    },
    areaServed: collections.serviceAreaPages.map((item) =>
      item.slug.split("/").at(-1).replace(/-tx$/, "").split("-").map((part) => part[0].toUpperCase() + part.slice(1)).join(" "),
    ),
    openingHoursSpecification: [
      {
        "@type": "OpeningHoursSpecification",
        dayOfWeek: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        opens: "08:00",
        closes: "19:00",
      },
    ],
    sameAs: [],
  };

  if (page.template === "article") {
    return JSON.stringify(
      {
        "@context": "https://schema.org",
        "@type": "Article",
        headline: page.title,
        datePublished: page.lastmod,
        dateModified: page.lastmod,
        author: {
          "@type": "Organization",
          name: site.name,
        },
        publisher: {
          "@type": "Organization",
          name: site.name,
        },
        description: page.metaDescription,
        mainEntityOfPage: absoluteUrl(site, page.slug),
      },
      null,
      2,
    );
  }

  return JSON.stringify(base, null, 2);
}

function renderBody(page, site) {
  switch (page.template) {
    case "home":
      return renderHome(page, site);
    case "service":
      return renderService(page, site);
    case "areas":
      return renderAreas(page, site);
    case "contact":
      return renderContact(page, site);
    case "resources":
      return renderResources(page, site);
    case "location":
      return renderLocation(page, site);
    case "article":
      return renderArticle(page, site);
    default:
      return renderSection(page.heroTitle, [page.heroSummary]);
  }
}

export function renderPage(page, context) {
  const { site } = context;
  const canonical = absoluteUrl(site, page.slug);
  const body = renderBody(page, site);

  return `<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${page.title}</title>
    <meta name="description" content="${page.metaDescription}">
    <meta name="theme-color" content="#0a0f17">
    <meta property="og:type" content="${page.template === "article" ? "article" : "website"}">
    <meta property="og:title" content="${page.title}">
    <meta property="og:description" content="${page.metaDescription}">
    <meta property="og:url" content="${canonical}">
    <meta property="og:site_name" content="${site.name}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="${page.title}">
    <meta name="twitter:description" content="${page.metaDescription}">
    <link rel="canonical" href="${canonical}">
    <link rel="icon" href="/assets/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="stylesheet" href="/assets/site.css">
    <script type="application/ld+json">${renderStructuredData(page, site)}</script>
    <script type="module" src="/assets/site.js"></script>
  </head>
  <body>
    <div class="site-chrome">
      ${renderHeader(page, site)}
      <main>
        ${renderBreadcrumbs(page)}
        ${body}
      </main>
      ${renderFooter(site)}
    </div>
  </body>
</html>
`;
}
