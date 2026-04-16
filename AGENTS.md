# AGENTS.md

Project guidance for future coding/design agents working in `QuickBrakeRepair`.

## Project Overview

- This repo now centers on the WordPress theme for `quickbrakerepair.com`.
- The primary implementation surface is [`wordpress-theme/quick-brake-repair-theme/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme).
- The legacy static site at the repository root and the old authoring flow under [`src/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/src) remain as reference material, not the default place to make changes.
- Do not refactor or replace the existing static site unless a separate request explicitly asks for that work.
- Assume future site work should stay inside the theme unless the user says otherwise.

## Source Of Truth

- Read [`wordpress-theme/THEME_EDITING_GUIDE.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/THEME_EDITING_GUIDE.md) before making structural or UI changes.
- Read [`wordpress-theme/MIGRATION_NOTES.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/MIGRATION_NOTES.md) before changing routing, slugs, or mapped content.
- Read [`docs/PROJECT_AGENT_GUIDANCE.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/docs/PROJECT_AGENT_GUIDANCE.md) before making major visual changes.
- Treat [`docs/WEBSITE_BUILD_APPROACH.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/docs/WEBSITE_BUILD_APPROACH.md) as legacy background only unless the user explicitly asks to work on the old static pipeline.

## Editing Boundary

- Only edit files inside [`wordpress-theme/quick-brake-repair-theme/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme).
- Do not hand-edit the generated static root files or `src/` for normal feature, UI, or content work.
- If a request appears to require non-theme edits, confirm that scope explicitly before touching legacy static files.

## Current Theme Structure

- Theme root:
  [`wordpress-theme/quick-brake-repair-theme/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme)
- Layout and template routing:
  [`functions.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/functions.php),
  [`header.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/header.php),
  [`footer.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/footer.php),
  [`page.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/page.php),
  [`single.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/single.php),
  [`archive.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/archive.php),
  [`front-page.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/front-page.php)
- Shared data and preserved SEO copy:
  [`inc/content-map.json`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/inc/content-map.json)
- Content lookup logic:
  [`inc/content-map.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/inc/content-map.php)
- Theme setup and WordPress behavior:
  [`inc/setup.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/inc/setup.php),
  [`inc/theme-support.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/inc/theme-support.php),
  [`inc/enqueue.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/inc/enqueue.php),
  [`inc/seo.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/inc/seo.php)
- Page-family layouts:
  [`template-parts/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/template-parts)
- Visual styling:
  [`assets/css/theme.css`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/assets/css/theme.css)
- Interaction JS:
  [`assets/js/theme.js`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/assets/js/theme.js)
- FAQ page template:
  [`page-templates/template-faq.php`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/page-templates/template-faq.php)
- Bundled theme media:
  [`assets/images/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/wordpress-theme/quick-brake-repair-theme/assets/images)

## WordPress Content Model

- `Pages` are used for the main site pages, including `/`, `/premium/`, `/standard/`, `/areas-we-serve/`, `/resources/`, `/contact/`, and optional `/faq/`.
- `Posts` are used for resource articles.
- `Service Areas` is a custom post type registered by the theme for `/service-area/...` URLs.
- WordPress admin is mainly for routing, menus, form configuration, and future publishing.
- High-value structure and preserved SEO copy remain code-driven for now.

## How Theme Content Works

- Matching core page slugs render mapped content from `inc/content-map.json`.
- Matching post slugs render mapped resource article content.
- Matching `Service Areas` entries render mapped city-page content under `/service-area/...`.
- Generic pages and posts that do not match the content map fall back to normal WordPress content output.
- If a change is layout-only, the right file is usually a template, CSS, or JS file.
- If a change affects preserved page or article copy, the right file is usually `inc/content-map.json`.

## Non-Negotiables

- Do not change URL structure.
- Do not remove pages.
- Do not merge service-area pages.
- Preserve the existing slug intent from the old site.
- Keep service-area URLs under `/service-area/...`.
- Keep the long article slugs intact.
- Preserve SEO copy unless the user explicitly asks for copy changes.
- Favor layout, hierarchy, spacing, internal linking, and visual improvements over text rewrites.
- Prefer updating `inc/content-map.json` for mapped page and article copy instead of hiding preserved content in editor-only content.
- Keep the Contact page form slot compatible with WordPress.com blocks or shortcode embeds.
- Avoid adding page builders, framework runtimes, or plugin dependencies just to solve layout work.

## Design Direction

- Brand direction is blue/white/graphite, not orange/warm-neutral.
- The site should feel professional and premium, closer to Apple-style restraint than “AI template.”
- Avoid “floating card everywhere” design.
- Prefer a strong hero, clear editorial spacing, clean sections, disciplined typography, and restrained accents.
- Homepage should feel like the flagship experience.

## Homepage Rules

- Keep the scroll-stopping looping hero video unless the user asks to replace it.
- The homepage hero should remain cinematic and high-contrast.
- Avoid stacking generic cards immediately under the hero.
- Preserve the existing homepage copy while refining presentation.

## Editing Rules

- Only touch the WordPress theme unless the user explicitly requests legacy static-site work.
- Do not remove required theme files like `style.css`, `index.php`, `functions.php`, `header.php`, or `footer.php`.
- Do not move copied local assets out of the theme folder.
- Do not rename the `qbr_service_area` post type unless a URL migration is intentionally planned.
- Do not switch mapped pages to editor-driven content unless that migration is intentional and documented.
- Do not hardcode production domains in templates.
- Keep page-specific classes scoped and intentional.
- Keep assets local to the theme when possible.

## Verification Workflow

After meaningful theme changes:

1. Run PHP lint across the theme:
   ```bash
   find wordpress-theme/quick-brake-repair-theme -name '*.php' -print0 | xargs -0 -n1 php -l
   ```
2. If JS changed, run:
   ```bash
   node --check wordpress-theme/quick-brake-repair-theme/assets/js/theme.js
   ```
3. Run `git diff --check`.
4. If CSS or JS changed, review the affected templates and class names together.
5. If packaging or release handoff is part of the task, re-zip only `quick-brake-repair-theme/`.
6. Test on a local WordPress install or staging WordPress.com Business site when available.
7. Confirm:
   - homepage layout
   - contact page form slot
   - one service-area entry
   - one resource post
   - mobile navigation

During visual QA, explicitly check for layout dead space:

- In paired desktop layouts, card bottoms should align unless there is a deliberate asymmetry.
- CTA cards and form cards should not contain large empty space below their final action or content block.
- If a card is stretched to match a neighboring card, make sure its internal content is intentionally distributed so it reaches the visual bottom cleanly.
- Do not sign off after a “looks close enough” pass; inspect the screenshot for empty vertical gaps, floating CTAs, and awkward card anchoring.

## Preferred Commands

```bash
rg --files wordpress-theme/quick-brake-repair-theme | sed -n '1,200p'
sed -n '1,260p' wordpress-theme/quick-brake-repair-theme/functions.php
sed -n '1,260p' wordpress-theme/quick-brake-repair-theme/inc/content-map.json
sed -n '1,260p' wordpress-theme/quick-brake-repair-theme/inc/content-map.php
sed -n '1,260p' wordpress-theme/quick-brake-repair-theme/assets/css/theme.css
sed -n '1,260p' wordpress-theme/quick-brake-repair-theme/assets/js/theme.js
find wordpress-theme/quick-brake-repair-theme -name '*.php' -print0 | xargs -0 -n1 php -l
node --check wordpress-theme/quick-brake-repair-theme/assets/js/theme.js
cd wordpress-theme && zip -r quick-brake-repair-theme.zip quick-brake-repair-theme
```

## When In Doubt

- Touch the WordPress theme only.
- Preserve SEO.
- Preserve slugs and URL structure.
- Improve clarity and professionalism.
- Prefer restraint over decoration.
