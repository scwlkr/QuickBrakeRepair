import assert from "node:assert/strict";
import { mkdtemp, readFile, rm } from "node:fs/promises";
import os from "node:os";
import path from "node:path";
import test from "node:test";

import { articlePages, pages, site } from "../src/data/index.mjs";
import { pageFilePath } from "../src/lib/site-paths.mjs";
import { buildSite } from "../scripts/lib/build-site.mjs";

test("build emits all expected pages and artifacts", async () => {
  const tempDir = await mkdtemp(path.join(os.tmpdir(), "qbr-build-"));

  try {
    const summary = await buildSite({
      rootDir: process.cwd(),
      outDir: tempDir,
    });

    assert.equal(summary.pages, 18);

    for (const page of pages) {
      const emitted = await readFile(path.join(tempDir, pageFilePath(page.slug)), "utf8");
      assert.match(emitted, /<link rel="stylesheet" href="(?:\.\.\/)*assets\/site\.css">/);
      assert.doesNotMatch(emitted, /\b(?:href|src)=["']\/(?!\/)/);
    }

    const sitemapMarkup = await readFile(path.join(tempDir, "sitemap.xml"), "utf8");
    for (const page of pages) {
      assert.match(
        sitemapMarkup,
        new RegExp(
          `${site.url.replaceAll(".", "\\.")}${page.canonicalPath.replaceAll("/", "\\/")}`,
        ),
      );
    }

    const atomMarkup = await readFile(path.join(tempDir, "feed/atom"), "utf8");
    const rssMarkup = await readFile(path.join(tempDir, "feed/rss2"), "utf8");
    for (const articlePage of articlePages) {
      const pageUrl = `${site.url}${articlePage.canonicalPath}`;
      assert.match(atomMarkup, new RegExp(pageUrl.replaceAll(".", "\\.")));
      assert.match(rssMarkup, new RegExp(pageUrl.replaceAll(".", "\\.")));
    }
  } finally {
    await rm(tempDir, { recursive: true, force: true });
  }
});
