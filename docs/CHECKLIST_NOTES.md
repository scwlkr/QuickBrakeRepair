# Checklist Notes

Working notes for the items tracked in [CHECKLIST.md](./CHECKLIST.md).

## Confirmed Decisions

- Use the approved logo at [`assets/logo.png`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/logo.png) as the source for favicon and Apple touch icon updates.
- Keep the existing static review/testimonial content. Live Google review data is not needed for this pass.
- Add subtle sitewide motion with variation between sections so the effect feels restrained rather than repetitive.
- Defer WordPress.com deployment and hosting setup decisions until they become necessary to complete a checklist item.
- Replace the current `mailto:` contact form fallback with a static-friendly submission flow that can send formatted emails without requiring WordPress changes first.

## Current Work Plan

- [x] Update favicon and Apple touch icon references across the site.
- [x] Redesign the homepage review section to feel more premium and less templated.
- [x] Add subtle scroll-triggered motion in shared CSS/JS with reduced-motion support.
- [x] Update the contact form to use a real email delivery path and send a copy to the test inbox.
- [x] Run verification checks and capture desktop/mobile screenshots.

## Implemented Changes

- Added PNG favicon assets and an Apple touch icon generated from the approved logo:
  - [`assets/favicon-32.png`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/favicon-32.png)
  - [`assets/favicon-192.png`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/favicon-192.png)
  - [`assets/favicon-512.png`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/favicon-512.png)
  - [`assets/apple-touch-icon.png`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/apple-touch-icon.png)
- Updated all static HTML pages to use the new PNG favicon and Apple touch icon tags.
- Updated [`manifest.webmanifest`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/manifest.webmanifest) to reference PNG icons instead of the old SVG favicon.
- Rebuilt the homepage reviews section in [`index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/index.html) with a darker editorial layout, rating summary, and improved CTA hierarchy while preserving the existing review quotes.
- Adjusted the review-card quote marks in [`assets/site.css`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/site.css) to prevent overlap with testimonial copy and reduce visual crowding.
- Added a shared reveal-motion system in [`assets/site.css`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/site.css) and [`assets/site.js`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/site.js).
- Added a contact-form success state and switched the form in [`contact/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/contact/index.html) from `mailto:` to FormSubmit with:
  - primary inbox: `Empstacked@gmail.com`
  - test copy: `shane.caleb.walker@gmail.com`
  - table-formatted emails
  - return URL set to the contact page with a success query string

## Verification

- `git diff --check`
- `node --check assets/site.js`
- `python3 -m http.server 4173 --directory ..`
- Captured local screenshots:
  - `/tmp/qbr-home.png`
  - `/tmp/qbr-home-mobile.png`
  - `/tmp/qbr-contact.png`

## Open Notes

- WordPress.com deployment steps are still intentionally on hold.
- The final form backend choice should stay simple and static-site friendly unless later WordPress requirements make that unnecessary.
- FormSubmit may require the destination inbox owner to complete an activation/confirmation step the first time the form is used live.
