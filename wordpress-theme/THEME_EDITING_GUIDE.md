# Theme Editing Guide

This guide explains how to safely keep working on the WordPress theme inside this repo.

## Editing Boundary

Only edit files inside:

- `wordpress-theme/quick-brake-repair-theme/`

Do not refactor or replace the existing static site unless a separate request explicitly asks for that work.

## Where To Edit What

- Layout and template routing:
  `functions.php`, `header.php`, `footer.php`, `page.php`, `single.php`, `archive.php`, `front-page.php`
- Shared data and preserved SEO copy:
  `inc/content-map.json`
- Content lookup logic:
  `inc/content-map.php`
- Theme setup and WordPress behavior:
  `inc/setup.php`, `inc/theme-support.php`, `inc/enqueue.php`, `inc/seo.php`
- Page-family layouts:
  `template-parts/`
- Visual styling:
  `assets/css/theme.css`
- Interaction JS:
  `assets/js/theme.js`
- FAQ page template:
  `page-templates/template-faq.php`

## Safe Editing Rules

- Preserve the existing slug intent from the old site.
- Keep service-area URLs under `/service-area/...`.
- Keep the long article slugs intact.
- Preserve strong SEO copy unless the request explicitly asks for copy changes.
- Prefer updating `inc/content-map.json` for mapped page/article copy instead of hiding it in editor-only content.
- Keep the Contact page form slot compatible with WordPress.com blocks or shortcode embeds.
- Avoid adding page builders, framework runtimes, or plugin dependencies just to solve layout work.

## How This Theme Handles Content

This theme uses a code-based content snapshot.

- Matching core page slugs render mapped content from `inc/content-map.json`.
- Matching post slugs render mapped resource article content.
- Matching `Service Areas` custom post entries render mapped city-page content.
- Generic pages and posts that do not match the content map fall back to normal WordPress content output.

That means if an AI edit changes layout but not copy, the right file is usually a template or CSS file.
If an AI edit changes preserved page/article copy, the right file is usually `inc/content-map.json`.

## Recommended Workflow

1. Edit the theme files only.
2. Run PHP lint across the theme:

```bash
find wordpress-theme/quick-brake-repair-theme -name '*.php' -print0 | xargs -0 -n1 php -l
```

3. If CSS or JS changed, review the affected templates and class names together.
4. Re-zip only `quick-brake-repair-theme/`.
5. Upload the new zip to a staging WordPress.com Business site first.
6. Confirm:
   - homepage layout
   - contact page form slot
   - one service-area entry
   - one resource post
   - mobile navigation
7. Promote the same zip to production after QA.

## Avoid Breaking Theme Integrity

- Do not remove required theme files like `style.css`, `index.php`, `functions.php`, `header.php`, or `footer.php`.
- Do not move the copied local assets out of the theme folder.
- Do not rename the `qbr_service_area` post type unless you also plan the URL migration carefully.
- Do not switch mapped pages to editor-driven content unless that migration is intentional and documented.
- Do not hardcode production domains in templates.

