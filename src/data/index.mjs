import { escapeHtml } from "../lib/html.mjs";
import { canonicalPath, canonicalUrl } from "../lib/site-paths.mjs";
import { articlePages as baseArticlePages } from "./pages/articles.mjs";
import { corePages as baseCorePages } from "./pages/core.mjs";
import { serviceAreaPages as baseServiceAreaPages } from "./pages/service-areas.mjs";
import { site as baseSite } from "./site.mjs";

const pageKindByTemplate = {
  home: "home",
  service: "service",
  areas: "areas",
  resources: "resources",
  contact: "contact",
  location: "location",
  article: "article",
};

const bodyClassBySlug = {
  "": "page-home",
  contact: "page-contact",
};

const corePageOverrides = {
  contact: {
    introParagraphs: [
      "When you call Quick Brake Repair, you’ll get a free quote before the appointment is booked. That makes it easier to understand the likely path forward before service begins.",
      "For the fastest response, call directly. If you prefer, use the contact form on this page and include the vehicle, location, and symptoms you’re noticing.",
    ],
    formNotice:
      "Use the form below to send your vehicle details directly for follow-up. The static build keeps the layout independent from any future WordPress integration, so the delivery method can still be swapped later without redesigning the page.",
  },
  resources: {
    introParagraphs: [
      "These guides are organized to make it easier to browse, compare, and revisit common brake topics before you schedule service.",
      "Use these articles to understand common warning signs, how mobile brake service works, and what different repair paths actually involve.",
    ],
    faqItems: [
      {
        question: "How does mobile brake repair work at my location?",
        answer:
          "Quick Brake Repair travels to your home, workplace, or parking area, inspects the braking system on-site, and handles approved repair work without sending you to a shop waiting room.",
      },
      {
        question: "Can you replace pads, rotors, calipers, and hoses on-site?",
        answer:
          "Yes. Mobile appointments can cover brake pads, rotors, calipers, hoses, fluid service, and related diagnostics depending on the condition of the vehicle and the repair path confirmed during inspection.",
      },
      {
        question: "What brake warning signs should I pay attention to first?",
        answer:
          "Squealing, grinding, a soft pedal, vibration while braking, warning lights, or longer stopping distances are all signs that the system should be inspected before the issue gets worse.",
      },
      {
        question: "Do I need a quote before scheduling service?",
        answer:
          "You can call for a quote and next-step guidance before booking. If more information is needed, Quick Brake Repair can recommend the right inspection path before parts or labor are approved.",
      },
    ],
  },
};

export const site = {
  ...baseSite,
  themeColor: "#081a37",
  brandTagline: "Mobile brake repair in the Dallas area",
  reviewRating: "5.0",
  reviewHeading: "5-star Google reviews",
  reviewSummary:
    "Customers consistently call out fast diagnosis, professional communication, and the convenience of getting brake work handled where the vehicle already is.",
  reviewPoints: [
    "Mobile service at home, work, or roadside.",
    "Clear diagnosis before repair approval.",
    "Responsive help when braking issues cannot wait.",
  ],
  reviewLink: "https://maps.app.goo.gl/YkvHFa36LSMcayqG6",
  footerResourceLimit: 4,
  contactForm: {
    action: "https://formsubmit.co/Empstacked@gmail.com",
    subject: "Quick Brake Repair website contact request",
    cc: "shane.caleb.walker@gmail.com",
    template: "table",
    next: "https://www.quickbrakerepair.com/contact/?submitted=1#contact-request",
  },
};

function buildBreadcrumbs(page) {
  if (!page.slug) {
    return [];
  }

  if (page.template === "location") {
    return [
      { label: "Home", slug: "" },
      { label: "Service Area" },
      { label: page.heroTitle },
    ];
  }

  return [
    { label: "Home", slug: "" },
    { label: page.heroTitle },
  ];
}

function normalizePage(page) {
  return {
    ...page,
    kind: pageKindByTemplate[page.template] ?? page.template,
    canonicalPath: canonicalPath(page.slug),
    themeColor: site.themeColor,
    bodyClass: bodyClassBySlug[page.slug] ?? "",
    hero: {
      eyebrow: page.eyebrow ?? "",
      title: page.heroTitle,
      summary: page.heroSummary,
    },
    breadcrumbs: buildBreadcrumbs(page),
  };
}

export const corePages = baseCorePages.map((page) =>
  normalizePage({
    ...page,
    ...(corePageOverrides[page.slug] ?? {}),
  }),
);

export const serviceAreaPages = baseServiceAreaPages.map(normalizePage);
export const articlePages = baseArticlePages.map(normalizePage);
export const pages = [...corePages, ...serviceAreaPages, ...articlePages];

export function getPageBySlug(slug) {
  return pages.find((page) => page.slug === slug);
}

export const collections = {
  corePages,
  serviceAreaPages,
  articlePages,
};

export const sitemapEntries = pages.map((page) => ({
  slug: page.slug,
  priority: page.priority,
  changefreq: page.changefreq,
  lastmod: page.lastmod,
}));

export const manifest = {
  name: site.name,
  short_name: site.name,
  start_url: "./",
  display: "standalone",
  background_color: "#ffffff",
  theme_color: site.themeColor,
  icons: [
    {
      src: "assets/favicon-192.png",
      sizes: "192x192",
      type: "image/png",
    },
    {
      src: "assets/favicon-512.png",
      sizes: "512x512",
      type: "image/png",
    },
  ],
};

export const robotsText = `# Sitemap is also available on /sitemap.xml
Sitemap: ${site.url}/sitemap.xml
User-agent: *
`;

function renderFeedArticleHtml(page) {
  const relatedPage = getPageBySlug(page.relatedSlug);
  const intro = `<h1>${escapeHtml(page.title)}</h1><div data-rss-type="text"><p>${escapeHtml(page.intro)}</p></div>`;
  const sections = page.sections
    .map(
      (section) => `<h2>${escapeHtml(section.question)}</h2>${section.answer
        .map((answer) => `<div data-rss-type="text"><p>${escapeHtml(answer)}</p></div>`)
        .join("")}`,
    )
    .join("");
  const closing = `<div data-rss-type="text"><p>${escapeHtml(page.closing)}</p></div>`;
  const related = relatedPage
    ? `<div data-rss-type="text"><p>Related city page: <a href="${canonicalUrl(
        site.url,
        relatedPage.slug,
      )}">${escapeHtml(relatedPage.title)}</a></p></div>`
    : "";

  return `${intro}${sections}${closing}${related}`;
}

export const feedEntries = articlePages.map((page) => ({
  slug: page.slug,
  title: page.title,
  description: page.metaDescription,
  publishedAt: `${page.lastmod}T00:00:00.000Z`,
  url: canonicalUrl(site.url, page.slug),
  html: renderFeedArticleHtml(page),
}));
