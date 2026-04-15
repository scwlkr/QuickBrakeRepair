# Project Agent Guidance

This document captures repo-specific guidance for future design and implementation work.

## 1. Business Goal

Quick Brake Repair is a Dallas-area mobile brake repair business. The website needs to:

- preserve ranking assets
- feel trustworthy and premium
- make contact conversion easy
- work well on mobile

## 2. SEO Constraints

The following are mandatory unless the user explicitly overrides them:

- Keep existing URLs and slugs.
- Keep service-area pages distinct.
- Keep core copy intact, especially on ranking pages.
- Prefer layout upgrades and better information design over rewriting copy.

Reference: [`WEBSITE_BUILD_APPROACH.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/docs/WEBSITE_BUILD_APPROACH.md)

## 3. UI Direction

The currently approved direction is:

- blue/white/graphite palette
- premium, restrained, professional styling
- strong landing-page hero with looping video
- conventional, high-confidence layout instead of novelty card stacks
- clear section rhythm and hierarchy

Avoid:

- random warm/orange palette shifts
- “AI-looking” floating card layouts
- overdecorated gradients or gimmicks
- weak typographic hierarchy
- visual choices that make the brand feel generic

## 4. Homepage Guidance

Homepage is the standard for the rest of the site.

Required characteristics:

- full-bleed cinematic hero
- immediate business clarity
- strong CTA treatment
- support panel with service facts
- generous spacing below hero
- sections that read as part of one premium page

Hero media currently lives at:

- [`assets/generated/hero-loop.mp4`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/generated/hero-loop.mp4)
- [`assets/generated/hero-poster.jpg`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/generated/hero-poster.jpg)

If replacing the hero media in the future:

- keep it local if practical
- keep file size reasonable
- ensure the poster frame still looks premium if video autoplay fails

## 5. Technical Guidance

- Prefer static HTML/CSS/JS.
- The publishable site lives at the repository root, not under `site/`.
- The authoring source of truth lives under `src/`, and `npm run build` regenerates the root output.
- Because GitHub Pages branch deploys this repo at a project path, prefer relative page and asset links over root-relative paths.
- Shared design changes should flow through [`src/styles/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/src/styles) and emit to [`assets/site.css`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/site.css).
- Shared behavior should live in [`src/scripts/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/src/scripts) and emit to [`assets/site.js`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/site.js).
- Page content should come from [`src/data/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/src/data), with shared chrome and page families rendered from [`src/partials/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/src/partials) and [`src/templates/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/src/templates).
- Use page-specific classes only where shared abstractions become too broad.

## 6. Verification Standard

At minimum, after UI changes:

```bash
npm run build
git diff --check
node --check assets/site.js
python3 -m http.server 4173 --directory ..
```

Then verify the homepage visually with Playwright at:

- desktop width
- mobile width
- using `http://127.0.0.1:4173/QuickBrakeRepair/` so the preview matches the GitHub Pages project path

If shared CSS changed, also verify at least one non-home page such as:

- [`contact/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/contact/index.html)

## 7. Good Future Work

High-value follow-up work:

- bring `premium`, `standard`, and `resources` up to the homepage quality bar
- improve service-area templates without changing their copy focus
- strengthen conversion paths on contact-heavy pages
- replace the generated hero loop with high-quality real footage if available

## 8. Bad Future Work

Avoid spending time on:

- framework migration for its own sake
- headless WordPress complexity
- design churn that weakens brand consistency
- wholesale copy rewrites that jeopardize SEO
- bypassing `src/` and hand-editing generated root pages for normal feature work
