# Migration Notes

## What Was Preserved From The Existing Repo

The new WordPress theme preserves the existing site intent in code:

- homepage positioning and major section structure
- core pages:
  - `/`
  - `/premium/`
  - `/standard/`
  - `/areas-we-serve/`
  - `/resources/`
  - `/contact/`
- service-area URLs and city-page copy intent:
  - `/service-area/dallas-tx/`
  - `/service-area/plano-tx/`
  - `/service-area/richardson-tx/`
  - `/service-area/garland-tx/`
  - `/service-area/mesquite-tx/`
  - `/service-area/irving-tx/`
- resource article URLs and preserved article copy:
  - `/mobile-brake-repair-in-dallas-tx-fast-service-at-your-location/`
  - `/brake-pad-replacement-in-plano-tx-what-every-driver-should-know/`
  - `/brake-hose-replacement-in-irving-tx-ensuring-safe-fluid-flow/`
  - `/brake-caliper-replacement-in-richardson-tx-restoring-braking-power/`
  - `/comprehensive-brake-inspection-services-in-garland-tx-for-vehicle-safety/`
  - `/brake-fluid-service-in-mesquite-tx-maintaining-hydraulic-performance/`
- contact details, testimonial usage, review positioning, and local-service CTA emphasis
- FAQ support, both on the Resources page and via a dedicated FAQ page template

## Theme Content Model

- `Pages` are used for the main site pages.
- `Posts` are used for resource articles.
- `Service Areas` is a custom post type registered by the theme for `/service-area/...` URLs.

## Manual WordPress Admin Work Still Required

After theme upload and activation, create the following content entries with matching slugs.

### Required Pages

- Home page for the static front page
  Suggested title: `Home`
- `premium`
- `standard`
- `areas-we-serve`
- `resources`
- `contact`
- optional: `faq`
  Apply the `FAQ Page` template if you want a dedicated FAQ page

Then:

- set the homepage page as the static front page in `Settings -> Reading`
- optionally set a separate posts page if you want a standard blog index beyond the mapped Resources landing page

### Required Service Area Entries

Create `Service Areas` posts with these slugs:

- `dallas-tx`
- `plano-tx`
- `richardson-tx`
- `garland-tx`
- `mesquite-tx`
- `irving-tx`

The theme supplies the preserved service-area layout and copy by slug.

### Required Resource Posts

Create standard WordPress posts with these slugs:

- `mobile-brake-repair-in-dallas-tx-fast-service-at-your-location`
- `brake-pad-replacement-in-plano-tx-what-every-driver-should-know`
- `brake-hose-replacement-in-irving-tx-ensuring-safe-fluid-flow`
- `brake-caliper-replacement-in-richardson-tx-restoring-braking-power`
- `comprehensive-brake-inspection-services-in-garland-tx-for-vehicle-safety`
- `brake-fluid-service-in-mesquite-tx-maintaining-hydraulic-performance`

The theme renders preserved article content for those slugs from `inc/content-map.json`.

## Areas That Need Real Admin Configuration After Upload

- navigation menus
  The theme has a fallback nav, but assign a real `Primary Menu` in WordPress for long-term control.
- contact form
  Add a WordPress.com Form block, shortcode, or embed into the Contact page content.
- featured images
  Optional for general blog/archive use. The mapped pages already use bundled local assets.
- site icon / favicon
  Set in WordPress admin if you want admin-managed favicon behavior.
- blog categories/tags
  Optional if you want a fuller editorial workflow for future articles.
- homepage and blog reading settings
  Set the correct static front page and optional posts page.

## Practical Assumption Built Into The Theme

This theme assumes:

- page structure and high-value SEO copy should stay code-driven for now
- WordPress admin is mainly for routing, menus, form configuration, and future publishing
- future AI edits should usually target the theme files, especially `inc/content-map.json` and `template-parts/`

