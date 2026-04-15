import { escapeAttr } from "../lib/html.mjs";
import {
  canonicalUrl,
  relativeAssetUrl,
} from "../lib/site-paths.mjs";

function renderStructuredData(page, site, serviceAreaPages) {
  if (page.kind === "article") {
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
        mainEntityOfPage: canonicalUrl(site.url, page.slug),
      },
      null,
      2,
    );
  }

  return JSON.stringify(
    {
      "@context": "https://schema.org",
      "@type": "AutoRepair",
      name: site.name,
      url: canonicalUrl(site.url, page.slug),
      telephone: site.phoneDisplay,
      address: {
        "@type": "PostalAddress",
        addressLocality: "Dallas",
        addressRegion: "TX",
        postalCode: site.postalCode,
        addressCountry: "US",
      },
      areaServed: serviceAreaPages.map((serviceAreaPage) =>
        serviceAreaPage.slug
          .split("/")
          .at(-1)
          .replace(/-tx$/, "")
          .split("-")
          .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
          .join(" "),
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
    },
    null,
    2,
  );
}

export function renderHead(page, site, collections) {
  const canonical = canonicalUrl(site.url, page.slug);
  const iconUrl = relativeAssetUrl(page.slug, "assets/favicon-32.png");
  const appleTouchIconUrl = relativeAssetUrl(page.slug, "assets/apple-touch-icon.png");
  const manifestUrl = relativeAssetUrl(page.slug, "manifest.webmanifest");
  const stylesheetUrl = relativeAssetUrl(page.slug, "assets/site.css");
  const scriptUrl = relativeAssetUrl(page.slug, "assets/site.js");

  return `<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${escapeAttr(page.title)}</title>
    <meta name="description" content="${escapeAttr(page.metaDescription)}">
    <meta name="theme-color" content="${escapeAttr(page.themeColor)}">
    <meta property="og:type" content="${page.kind === "article" ? "article" : "website"}">
    <meta property="og:title" content="${escapeAttr(page.title)}">
    <meta property="og:description" content="${escapeAttr(page.metaDescription)}">
    <meta property="og:url" content="${escapeAttr(canonical)}">
    <meta property="og:site_name" content="${escapeAttr(site.name)}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="${escapeAttr(page.title)}">
    <meta name="twitter:description" content="${escapeAttr(page.metaDescription)}">
    <link rel="canonical" href="${escapeAttr(canonical)}">
    <link rel="icon" href="${escapeAttr(iconUrl)}" sizes="32x32" type="image/png">
    <link rel="apple-touch-icon" sizes="180x180" href="${escapeAttr(appleTouchIconUrl)}">
    <link rel="manifest" href="${escapeAttr(manifestUrl)}">
    <link rel="stylesheet" href="${escapeAttr(stylesheetUrl)}">
    <script type="application/ld+json">${renderStructuredData(
      page,
      site,
      collections.serviceAreaPages,
    )}</script>
    <script type="module" src="${escapeAttr(scriptUrl)}"></script>
  </head>`;
}
