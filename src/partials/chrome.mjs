import { escapeHtml } from "../lib/html.mjs";
import { relativeAssetUrl, relativePageUrl } from "../lib/site-paths.mjs";
import { collections } from "../data/index.mjs";

const navItems = [
  { slug: "", label: "Home" },
  { slug: "premium", label: "Premium" },
  { slug: "standard", label: "Standard" },
  { slug: "areas-we-serve", label: "Areas We Serve" },
  { slug: "resources", label: "Resources" },
  { slug: "contact", label: "Contact" },
];

function isNavActive(page, itemSlug) {
  if (!itemSlug) {
    return page.slug === "";
  }

  if (itemSlug === "areas-we-serve") {
    return page.kind === "areas" || page.kind === "location";
  }

  if (itemSlug === "resources") {
    return page.kind === "resources" || page.kind === "article";
  }

  return page.slug === itemSlug;
}

export function renderLogo(page) {
  const logoUrl = relativeAssetUrl(page.slug, "assets/logo.png");

  return `<div class="brand-mark" aria-hidden="true" style="background-image:url('${logoUrl}')">
    <span class="brand-mark__core"></span>
    <span class="brand-mark__ring brand-mark__ring--one"></span>
    <span class="brand-mark__ring brand-mark__ring--two"></span>
    <span class="brand-mark__slice"></span>
  </div>`;
}

export function renderHeader(page, site) {
  const links = navItems
    .map((item) => {
      const className = `site-nav__link${isNavActive(page, item.slug) ? " is-active" : ""}`;
      return `<a class="${className}" href="${relativePageUrl(page.slug, item.slug)}">${escapeHtml(
        item.label,
      )}</a>`;
    })
    .join("");

  return `<header class="site-header">
    <div class="site-header__inner shell">
      <a class="brand" href="${relativePageUrl(page.slug, "")}" aria-label="${escapeHtml(site.name)} home">
        ${renderLogo(page)}
        <span class="brand__text">
          <strong>${escapeHtml(site.name)}</strong>
          <span>${escapeHtml(site.brandTagline)}</span>
        </span>
      </a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Open navigation">
        <span></span>
        <span></span>
        <span></span>
        <span class="sr-only">Toggle navigation</span>
      </button>
      <nav id="site-nav" class="site-nav" aria-label="Primary">
        ${links}
      </nav>
      <a class="call-pill" href="${escapeHtml(site.phoneHref)}">${escapeHtml(site.phoneDisplay)}</a>
    </div>
  </header>`;
}

export function renderFooter(page, site) {
  const serviceAreaLinks = collections.serviceAreaPages
    .map(
      (serviceAreaPage) =>
        `<li><a href="${relativePageUrl(page.slug, serviceAreaPage.slug)}">${escapeHtml(
          serviceAreaPage.title.replace(", TX", ""),
        )}</a></li>`,
    )
    .join("");
  const resourceLinks = collections.articlePages
    .slice(0, site.footerResourceLimit)
    .map(
      (articlePage) =>
        `<li><a href="${relativePageUrl(page.slug, articlePage.slug)}">${escapeHtml(
          articlePage.title,
        )}</a></li>`,
    )
    .join("");

  return `<footer class="site-footer">
    <div class="shell site-footer__grid">
      <section>
        <h2 class="footer-title">Mobile brake service designed around your day.</h2>
        <p class="footer-copy">ASE-certified technicians, on-site repair support, and clear next steps before you drive again.</p>
      </section>
      <section>
        <h2 class="footer-list-title">Contact</h2>
        <ul class="footer-list">
          <li><a href="${escapeHtml(site.phoneHref)}">${escapeHtml(site.phoneDisplay)}</a></li>
          <li><a href="mailto:${escapeHtml(site.emails[0])}">${escapeHtml(site.emails[0])}</a></li>
          <li>${escapeHtml(`${site.city} ${site.postalCode}`)}</li>
        </ul>
      </section>
      <section>
        <h2 class="footer-list-title">Service Areas</h2>
        <ul class="footer-list">${serviceAreaLinks}</ul>
      </section>
      <section>
        <h2 class="footer-list-title">Resources</h2>
        <ul class="footer-list">${resourceLinks}</ul>
      </section>
    </div>
    <div class="shell site-footer__meta">
      <p>Mon - Sat: 8:00 am - 7:00 pm | Sunday: Closed | Overnight and weekend appointments available</p>
      <p>Copyright © ${escapeHtml(site.name)}. All Rights Reserved.</p>
    </div>
    <a class="floating-call" href="${escapeHtml(site.phoneHref)}" aria-label="Call ${escapeHtml(site.phoneDisplay)}">
      <span class="floating-call__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M6.62 10.79a15.06 15.06 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.11.37 2.3.56 3.51.56a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.21.19 2.4.56 3.51a1 1 0 0 1-.24 1.02l-2.2 2.26Z" fill="currentColor"></path>
        </svg>
      </span>
      <span class="floating-call__text">Call ${escapeHtml(site.phoneDisplay)}</span>
    </a>
  </footer>`;
}

export function renderBreadcrumbs(page) {
  if (!page.breadcrumbs.length) {
    return "";
  }

  const crumbs = page.breadcrumbs
    .map((crumb) => {
      if (typeof crumb.slug === "string") {
        return `<a href="${relativePageUrl(page.slug, crumb.slug)}">${escapeHtml(crumb.label)}</a>`;
      }

      return `<span>${escapeHtml(crumb.label)}</span>`;
    })
    .join("<span>/</span>");

  return `<nav class="breadcrumbs shell" aria-label="Breadcrumbs">${crumbs}</nav>`;
}

export function renderHeroCard(page, site) {
  return `<aside class="hero-card">
    ${renderLogo(page)}
    <div class="hero-card__copy">
      <strong>On-site diagnostics and repair</strong>
      <p>Brake pads, rotors, calipers, hoses, fluid service, and inspection support without the tow or waiting room.</p>
    </div>
    <dl class="hero-card__facts">
      <div><dt>Coverage</dt><dd>${escapeHtml(site.serviceAreaLabel)}</dd></div>
      <div><dt>Hours</dt><dd>Mon - Sat, 8:00 am - 7:00 pm</dd></div>
      <div><dt>Need help fast?</dt><dd><a href="${escapeHtml(site.phoneHref)}">${escapeHtml(
        site.phoneDisplay,
      )}</a></dd></div>
    </dl>
  </aside>`;
}
