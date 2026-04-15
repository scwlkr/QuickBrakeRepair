import { collections, site } from "../data/index.mjs";
import { renderHead } from "../partials/metadata.mjs";
import {
  renderBreadcrumbs,
  renderFooter,
  renderHeader,
} from "../partials/chrome.mjs";
import { renderPageBody } from "./renderers.mjs";

export function renderPage(page) {
  const bodyClass = page.bodyClass ? ` class="${page.bodyClass}"` : "";
  const mainAttributes =
    page.slug === ""
      ? ` id="main-content" class="page-home__main"`
      : "";

  return `<!doctype html>
<html lang="en">
  ${renderHead(page, site, collections)}
  <body${bodyClass}>
    <div class="site-chrome">
      ${renderHeader(page, site)}
      <main${mainAttributes}>
        ${renderBreadcrumbs(page)}
        ${renderPageBody(page, site)}
      </main>
      ${renderFooter(page, site)}
    </div>
  </body>
</html>
`;
}
