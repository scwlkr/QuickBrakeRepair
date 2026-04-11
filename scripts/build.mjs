import { cpSync, existsSync, mkdirSync, readFileSync, rmSync, writeFileSync } from "node:fs";
import { dirname, join } from "node:path";
import { pages, robotsText, site, sitemapEntries } from "../src/content.mjs";
import { renderPage } from "../src/templates.mjs";

const outDir = "site";

function ensureDir(path) {
  mkdirSync(path, { recursive: true });
}

function writeFile(path, contents) {
  ensureDir(dirname(path));
  writeFileSync(path, contents);
}

function pageOutputPath(slug) {
  return slug ? join(outDir, slug, "index.html") : join(outDir, "index.html");
}

function buildSitemap() {
  const body = sitemapEntries
    .map(
      (entry) => `  <url>
    <loc>${site.url}${entry.slug ? `/${entry.slug}` : ""}</loc>
    <priority>${entry.priority}</priority>
    <changefreq>${entry.changefreq}</changefreq>
    <lastmod>${entry.lastmod}</lastmod>
  </url>`,
    )
    .join("\n");

  return `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${body}
</urlset>
`;
}

rmSync(outDir, { recursive: true, force: true });
ensureDir(outDir);

cpSync("src/assets", join(outDir, "assets"), { recursive: true });

for (const page of pages) {
  const output = renderPage(page, { site, pages });
  writeFile(pageOutputPath(page.slug), output);
}

writeFile(join(outDir, "robots.txt"), robotsText);
writeFile(join(outDir, "sitemap.xml"), buildSitemap());

if (existsSync("old-website-refrence/www.quickbrakerepair.com/feed")) {
  cpSync("old-website-refrence/www.quickbrakerepair.com/feed", join(outDir, "feed"), {
    recursive: true,
  });
}

const manifest = {
  name: site.name,
  short_name: "Quick Brake",
  start_url: "/",
  display: "standalone",
  background_color: "#0a0f17",
  theme_color: "#205cff",
  icons: [
    {
      src: "/assets/favicon.svg",
      sizes: "any",
      type: "image/svg+xml",
      purpose: "any",
    },
  ],
};

writeFile(join(outDir, "manifest.webmanifest"), JSON.stringify(manifest, null, 2));

const summary = {
  pages: pages.length,
  output: outDir,
  generatedAt: new Date().toISOString(),
};

writeFile(join(outDir, "build-summary.json"), `${JSON.stringify(summary, null, 2)}\n`);
