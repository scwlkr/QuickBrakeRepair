# Checklist Notes

Working notes for the items tracked in [CHECKLIST.md](./CHECKLIST.md).

## Confirmed Decisions

- Use the approved logo at [`assets/logo.png`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/assets/logo.png) as the source for favicon and Apple touch icon updates.
- Keep the existing static review/testimonial content. Live Google review data is not needed for this pass.
- Add subtle sitewide motion with variation between sections so the effect feels restrained rather than repetitive.
- Defer WordPress.com deployment and hosting setup decisions until they become necessary to complete a checklist item.
- Replace the current `mailto:` contact form fallback with a static-friendly submission flow that can send formatted emails without requiring WordPress changes first.

## Current Work Plan

- [ ] Update favicon and Apple touch icon references across the site.
- [ ] Redesign the homepage review section to feel more premium and less templated.
- [ ] Add subtle scroll-triggered motion in shared CSS/JS with reduced-motion support.
- [ ] Update the contact form to use a real email delivery path and send a copy to the test inbox.
- [ ] Run verification checks and capture desktop/mobile screenshots.

## Open Notes

- WordPress.com deployment steps are still intentionally on hold.
- The final form backend choice should stay simple and static-site friendly unless later WordPress requirements make that unnecessary.
- If the chosen form service requires email-address activation, that confirmation step will need to be completed once the form is live.
