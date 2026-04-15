import { access, readFile } from "node:fs/promises";
import path from "node:path";

import {
  pageFilePath,
  resolveReferencePath,
} from "../../src/lib/site-paths.mjs";

async function pathExists(filePath) {
  try {
    await access(filePath);
    return true;
  } catch {
    return false;
  }
}

export function validateSourceData({ pages }) {
  const seenSlugs = new Set();
  const issues = [];

  if (pages.length !== 18) {
    issues.push(`Expected 18 pages but found ${pages.length}.`);
  }

  for (const page of pages) {
    if (seenSlugs.has(page.slug)) {
      issues.push(`Duplicate slug detected: "${page.slug}".`);
    }

    seenSlugs.add(page.slug);

    for (const field of [
      "slug",
      "kind",
      "title",
      "metaDescription",
      "canonicalPath",
      "themeColor",
      "hero",
      "breadcrumbs",
      "lastmod",
    ]) {
      if (
        page[field] === undefined ||
        page[field] === null ||
        (typeof page[field] === "string" &&
          !page[field] &&
          field !== "slug" &&
          field !== "canonicalPath")
      ) {
        issues.push(`Page "${page.slug || "index"}" is missing required field "${field}".`);
      }
    }
  }

  if (issues.length) {
    throw new Error(`Source validation failed:\n- ${issues.join("\n- ")}`);
  }
}

function getLocalReferences(markup) {
  const references = [];
  const pattern = /\b(?:href|src)=["']([^"']+)["']/g;
  let match;

  while ((match = pattern.exec(markup)) !== null) {
    references.push(match[1]);
  }

  return references;
}

function shouldCheckReference(reference) {
  if (!reference || reference.startsWith("#") || reference.startsWith("?")) {
    return false;
  }

  if (/^[a-zA-Z][a-zA-Z0-9+.-]*:/.test(reference) || reference.startsWith("//")) {
    return false;
  }

  return true;
}

export async function validateBuildOutput({
  outDir,
  pages,
  articlePages,
  site,
}) {
  const issues = [];

  for (const page of pages) {
    const outputPath = path.join(outDir, pageFilePath(page.slug));

    if (!(await pathExists(outputPath))) {
      issues.push(`Missing generated page: ${path.relative(outDir, outputPath)}`);
      continue;
    }

    const markup = await readFile(outputPath, "utf8");

    for (const reference of getLocalReferences(markup)) {
      if (!shouldCheckReference(reference)) {
        continue;
      }

      if (reference.startsWith("/")) {
        issues.push(
          `Root-relative local reference found in ${path.relative(
            outDir,
            outputPath,
          )}: ${reference}`,
        );
        continue;
      }

      const resolvedPath = resolveReferencePath(path.dirname(outputPath), reference);

      if (resolvedPath && !(await pathExists(resolvedPath))) {
        issues.push(
          `Unknown internal reference in ${path.relative(outDir, outputPath)}: ${reference}`,
        );
      }
    }
  }

  const sitemapMarkup = await readFile(path.join(outDir, "sitemap.xml"), "utf8");
  for (const page of pages) {
    const canonicalUrl = `${site.url}${page.canonicalPath}`;
    if (!sitemapMarkup.includes(canonicalUrl)) {
      issues.push(`Sitemap is missing ${canonicalUrl}`);
    }
  }

  const atomMarkup = await readFile(path.join(outDir, "feed/atom"), "utf8");
  const rssMarkup = await readFile(path.join(outDir, "feed/rss2"), "utf8");
  for (const articlePage of articlePages) {
    const canonicalUrl = `${site.url}${articlePage.canonicalPath}`;
    if (!atomMarkup.includes(canonicalUrl)) {
      issues.push(`Atom feed is missing ${canonicalUrl}`);
    }

    if (!rssMarkup.includes(canonicalUrl)) {
      issues.push(`RSS feed is missing ${canonicalUrl}`);
    }
  }

  if (issues.length) {
    throw new Error(`Build validation failed:\n- ${issues.join("\n- ")}`);
  }
}
