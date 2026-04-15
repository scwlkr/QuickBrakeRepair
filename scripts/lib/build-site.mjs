import { cp, mkdir, readFile, readdir, rm, writeFile } from "node:fs/promises";
import path from "node:path";

import {
  articlePages,
  feedEntries,
  manifest,
  pages,
  robotsText,
  sitemapEntries,
  site,
} from "../../src/data/index.mjs";
import { xmlEscape } from "../../src/lib/html.mjs";
import { pageFilePath } from "../../src/lib/site-paths.mjs";
import { renderPage } from "../../src/templates/index.mjs";
import {
  validateBuildOutput,
  validateSourceData,
} from "./validation.mjs";

async function ensureDir(filePath) {
  await mkdir(path.dirname(filePath), { recursive: true });
}

async function writeFileEnsured(filePath, contents) {
  await ensureDir(filePath);
  await writeFile(filePath, contents);
}

async function readConcatenatedSource(directoryPath) {
  const entries = (await readdir(directoryPath))
    .filter((entry) => !entry.startsWith("."))
    .sort();

  const contents = await Promise.all(
    entries.map((entry) => readFile(path.join(directoryPath, entry), "utf8")),
  );

  return `${contents.map((content) => content.trimEnd()).join("\n\n")}\n`;
}

function toIsoDate(dateValue) {
  return new Date(`${dateValue}T00:00:00.000Z`).toISOString();
}

function renderSitemap() {
  const urls = sitemapEntries
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
${urls}
</urlset>
`;
}

function renderAtomFeed() {
  const entries = feedEntries
    .map(
      (entry) => `  <entry>
    <title>${xmlEscape(entry.title)}</title>
    <link rel="alternate" href="${xmlEscape(entry.url)}" />
    <author>
      <name>${xmlEscape(site.name)}</name>
    </author>
    <updated>${entry.publishedAt}</updated>
    <published>${entry.publishedAt}</published>
    <content>${xmlEscape(entry.html)}</content>
  </entry>`,
    )
    .join("\n");

  return `<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g-custom="http://base.google.com/cns/1.0">
  <title>quickbrakerepair</title>
  <link rel="alternate" href="${site.url}" />
  <subtitle />
${entries}
</feed>
`;
}

function renderRssFeed() {
  const items = feedEntries
    .map(
      (entry) => `    <item>
      <title>${xmlEscape(entry.title)}</title>
      <link>${xmlEscape(entry.url)}</link>
      <description>${xmlEscape(entry.description)}</description>
      <content:encoded>${xmlEscape(entry.html)}</content:encoded>
      <pubDate>${toIsoDate(entry.publishedAt.slice(0, 10))}</pubDate>
    </item>`,
    )
    .join("\n");

  return `<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:g-custom="http://base.google.com/cns/1.0" version="2.0">
  <channel>
    <title>quickbrakerepair</title>
    <link>${site.url}</link>
    <description />
    <atom:link href="${site.url}/feed/rss2" type="application/rss+xml" rel="self" />
${items}
  </channel>
</rss>
`;
}

async function copyPassthroughAssets(rootDir, outDir) {
  if (path.resolve(rootDir) === path.resolve(outDir)) {
    return;
  }

  await rm(outDir, { recursive: true, force: true });
  await mkdir(outDir, { recursive: true });
  await cp(path.join(rootDir, "assets"), path.join(outDir, "assets"), {
    recursive: true,
  });

  try {
    await cp(path.join(rootDir, ".nojekyll"), path.join(outDir, ".nojekyll"));
  } catch {
    // Ignore optional project files.
  }
}

export async function buildSite({ rootDir = process.cwd(), outDir = rootDir } = {}) {
  const resolvedRoot = path.resolve(rootDir);
  const resolvedOut = path.resolve(rootDir, outDir);

  validateSourceData({ pages });
  await copyPassthroughAssets(resolvedRoot, resolvedOut);

  const stylesheet = await readConcatenatedSource(path.join(resolvedRoot, "src/styles"));
  const script = await readConcatenatedSource(path.join(resolvedRoot, "src/scripts"));

  await writeFileEnsured(path.join(resolvedOut, "assets/site.css"), stylesheet);
  await writeFileEnsured(path.join(resolvedOut, "assets/site.js"), script);

  await Promise.all(
    pages.map((page) =>
      writeFileEnsured(
        path.join(resolvedOut, pageFilePath(page.slug)),
        renderPage(page),
      ),
    ),
  );

  await writeFileEnsured(
    path.join(resolvedOut, "manifest.webmanifest"),
    `${JSON.stringify(manifest, null, 2)}\n`,
  );
  await writeFileEnsured(path.join(resolvedOut, "robots.txt"), robotsText);
  await writeFileEnsured(path.join(resolvedOut, "sitemap.xml"), renderSitemap());
  await writeFileEnsured(path.join(resolvedOut, "feed/atom"), renderAtomFeed());
  await writeFileEnsured(path.join(resolvedOut, "feed/rss2"), renderRssFeed());

  const summary = {
    pages: pages.length,
    output: path.relative(resolvedRoot, resolvedOut) || ".",
    generatedAt: new Date().toISOString(),
  };

  await writeFileEnsured(
    path.join(resolvedOut, "build-summary.json"),
    `${JSON.stringify(summary, null, 2)}\n`,
  );

  await validateBuildOutput({
    outDir: resolvedOut,
    pages,
    articlePages,
    site,
  });

  return summary;
}
