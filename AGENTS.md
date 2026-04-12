# AGENTS.md

Project guidance for future coding/design agents working in `QuickBrakeRepair`.

## Project Overview

- This repo is a static website build for `quickbrakerepair.com`.
- The current architecture is plain `HTML/CSS/JS` under [`site/`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site).
- WordPress is treated as optional hosting/integration infrastructure, not the primary implementation surface.

## Source Of Truth

- Read [`docs/WEBSITE_BUILD_APPROACH.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/docs/WEBSITE_BUILD_APPROACH.md) before making structural changes.
- Read [`docs/PROJECT_AGENT_GUIDANCE.md`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/docs/PROJECT_AGENT_GUIDANCE.md) before making UI changes.

## Non-Negotiables

- Do not change URL structure.
- Do not remove pages.
- Do not merge service-area pages.
- Preserve SEO copy unless the user explicitly asks for copy changes.
- Favor layout, hierarchy, spacing, internal linking, and visual improvements over text rewrites.

## Current Site Structure

- Homepage: [`site/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/index.html)
- Shared styles: [`site/assets/site.css`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/assets/site.css)
- Shared interactions: [`site/assets/site.js`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/assets/site.js)
- Core pages:
  - [`site/contact/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/contact/index.html)
  - [`site/areas-we-serve/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/areas-we-serve/index.html)
  - [`site/premium/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/premium/index.html)
  - [`site/standard/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/standard/index.html)
  - [`site/resources/index.html`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/resources/index.html)
- Generated homepage hero media:
  - [`site/assets/generated/hero-loop.mp4`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/assets/generated/hero-loop.mp4)
  - [`site/assets/generated/hero-poster.jpg`](/Users/shanewalker/Desktop/dev/QuickBrakeRepair/site/assets/generated/hero-poster.jpg)

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

- Use shared CSS for consistent cross-page changes.
- Keep page-specific classes scoped and intentional.
- Avoid introducing frameworks.
- Keep assets local when possible.
- If changing theme colors, update `<meta name="theme-color">` across affected static pages.

## Verification Workflow

After meaningful UI changes:

1. Run `git diff --check`
2. Run `node --check site/assets/site.js`
3. Serve locally with:
   ```bash
   python3 -m http.server 4173 --directory site
   ```
4. Verify with Playwright screenshots at desktop and mobile widths.
5. Spot-check at least one interior page if shared CSS changed.

## Preferred Commands

```bash
rg --files site
sed -n '1,260p' site/index.html
sed -n '1,260p' site/assets/site.css
node --check site/assets/site.js
python3 -m http.server 4173 --directory site
npx --yes playwright screenshot -b chromium --viewport-size="1440,1100" --wait-for-timeout 1400 http://127.0.0.1:4173/ /tmp/qbr-home.png
npx --yes playwright screenshot -b chromium --viewport-size="390,844" --wait-for-timeout 1400 http://127.0.0.1:4173/ /tmp/qbr-home-mobile.png
```

## When In Doubt

- Preserve SEO.
- Preserve structure.
- Improve clarity and professionalism.
- Prefer restraint over decoration.
