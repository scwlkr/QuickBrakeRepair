# QBR - Your Optimal Build Approach

Current repo note

The project now uses a source-driven static build:

* edit content, templates, styles, and scripts under `src/`
* run `npm run build`
* publish the generated root output for GitHub Pages / static hosting / optional WordPress upload

Core Decision

You should NOT build a WordPress theme from scratch.
Instead:
Build a static site (HTML/CSS/JS) → then integrate ONLY what you need into WordPress (forms + optional CMS).
This avoids PHP complexity, speeds you up massively, and fits your April 19 deadline.

🧠 Architecture (simple + fast)
Layer 1 — Static Site (your main work)
* AI generates:
    * HTML pages (same URLs/structure)
    * Clean CSS (modern redesign)
    * Minimal JS (nav, interactions)
Layer 2 — WordPress (just utilities)
* Hosting + domain
* Contact form handling
* Optional CMS (FAQ page via Google Sheets)

🧱 Site Structure (from your sitemap)
You already have the blueprint:
Core pages
* / (home)
* /contact
* /areas-we-serve
* /premium
* /standard
* /resources
SEO pages (DO NOT TOUCH URL STRUCTURE)
* /service-area/dallas-tx
* /service-area/plano-tx
* etc.
Blog/resource pages
* long SEO URLs (leave intact)
👉 These pages are ranking assets — keep them.

⚠️ Important SEO Rule
Do NOT:
* Change slugs
* Remove pages
* Combine service-area pages
You can:
* Improve layout
* Improve internal linking
* Improve readability

🔄 Build Pipeline (step-by-step)
1. Crawl + Extract Site
Use:
wget \
 --mirror \
 --convert-links \
 --adjust-extension \
 --page-requisites \
 --no-parent \
 https://www.quickbrakerepair.com
This gives you:
* HTML
* images
* basic structure

2. Clean the Output
You’ll get messy files. Do this:
* Remove inline styles
* Strip unnecessary scripts
* Extract:
    * headings
    * paragraphs
    * structure

3. Rebuild with AI (this is the key step)
Prompt AI like this:
“Rebuild this page using modern HTML/CSS. Keep all text content exactly the same. Improve layout, spacing, hierarchy, and mobile responsiveness. No frameworks.”
Do this per page.

4. Design System (DO THIS ONCE)
Before generating pages, define:
* typography scale
* spacing system
* color palette
* button styles
* section layouts
Then reuse across all pages.

5. Contact Form (your only dynamic need)
Easiest method (recommended):
Use WordPress plugin:
* WPForms or Contact Form 7
Then:
* Create form in WP admin
* Embed using:
<iframe src="/contact-form-page"></iframe>
OR
Use REST endpoint (cleaner):
* Submit via fetch → WP backend

6. Reviews (Google Reviews)
Do NOT fake scrape.
Use:
* Embed widget OR
* JS fetch via API (if available)
Simplest:
* manually display 5-star reviews
* link to Google profile

7. FAQ (your Google Sheets idea)
Best move:
* Publish Google Sheet as JSON
* Fetch with JS
* Render FAQ dynamically
This keeps client editable without WP.

8. Deploy Strategy (important)
Since you're on WordPress hosting:
Option A (fastest)
* Upload files via:
    * File Manager OR FTP
* Place in /public_html
* Disable WP theme completely
Option B (cleaner long-term)
* Create minimal WP theme
* Drop your HTML into:
    * page.php
    * header.php
    * footer.php

⚡ What You Should NOT Do
❌ Don’t:
* Use Elementor / WP builder
* Overcomplicate with React/Next
* Try full headless WP (too slow for deadline)
* Rebuild SEO pages from scratch manually

🎯 What Actually Matters for Success
1. Keep URLs intact
2. Keep SEO copy intact
3. Improve UX massively
4. Make contact conversion easier
5. Launch before April 19

🧩 If I Were You (exact execution)
1. Crawl site (today)
2. Extract + organize pages (today)
3. Build design system (tomorrow morning)
4. AI-generate pages (bulk)
5. Hook contact form
6. Upload to WP hosting
7. QA + mobile fixes
8. Launch
