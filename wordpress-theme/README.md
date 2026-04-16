# Quick Brake Repair WordPress Theme

This folder contains a standalone classic WordPress theme build for the existing Quick Brake Repair website.

It does not replace the current static site in the repo.
It is a separate deliverable intended for upload to WordPress.com Business as a custom theme.

## What This Folder Contains

- `quick-brake-repair-theme/`
  The uploadable WordPress theme.
- `README.md`
  Packaging and upload instructions.
- `THEME_EDITING_GUIDE.md`
  Safe editing rules for future Codex work.
- `MIGRATION_NOTES.md`
  What was preserved from the old repo and what still needs admin-side migration.

## Important Theme Behavior

This theme is intentionally code-driven.

- Core SEO copy was preserved into `quick-brake-repair-theme/inc/content-map.json`.
- Matching WordPress pages, posts, and service-area entries render that preserved content by slug.
- This means the migration does not depend on rebuilding layouts in the block editor or a page builder.
- The Contact page is the main exception: its form area is designed to accept WordPress.com form blocks or shortcode content added in the admin.

## Most Important Files

- `quick-brake-repair-theme/style.css`
  Theme registration header.
- `quick-brake-repair-theme/functions.php`
  Theme bootstrap.
- `quick-brake-repair-theme/inc/content-map.json`
  Preserved site copy and page/article structure.
- `quick-brake-repair-theme/inc/content-map.php`
  Helpers that map WordPress slugs to preserved theme content.
- `quick-brake-repair-theme/assets/css/theme.css`
  Main front-end styling.
- `quick-brake-repair-theme/assets/js/theme.js`
  Small interaction layer.
- `quick-brake-repair-theme/template-parts/`
  Page-family layouts.

## How To Zip The Theme

From the repo root:

```bash
cd wordpress-theme
zip -r quick-brake-repair-theme.zip quick-brake-repair-theme
```

Or in Finder, compress the `quick-brake-repair-theme/` folder directly.

Do not zip the whole `wordpress-theme/` directory for upload.
Upload only the `quick-brake-repair-theme/` folder as a zip.

## How To Upload To WordPress.com Business

1. In WordPress.com, go to `Appearance -> Themes`.
2. Choose `Install Theme` or `Upload Theme`.
3. Upload `quick-brake-repair-theme.zip`.
4. Activate the theme.
5. Go to `Settings -> Permalinks` and use a structure that keeps post slugs at the root, usually `Post name`.
6. Follow `MIGRATION_NOTES.md` to create the required pages, resource posts, and service area entries with matching slugs.

## How Future AI Edits Should Be Requested

Ask for changes against the WordPress theme folder explicitly.

Good request examples:

- “Update the homepage hero inside `wordpress-theme/quick-brake-repair-theme/` only.”
- “Adjust the service-area template styling without changing the static site.”
- “Edit `inc/content-map.json` to update preserved SEO copy for the Plano page.”

Be explicit that:

- the static site outside `/wordpress-theme/` should remain untouched
- slug structure should stay aligned with the current site
- valuable SEO copy should not be shortened unless requested

