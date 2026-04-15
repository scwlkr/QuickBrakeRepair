export function escapeHtml(value) {
  return `${value ?? ""}`
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#39;");
}

export const escapeAttr = escapeHtml;

export function renderParagraphs(items = []) {
  return items.map((item) => `<p>${escapeHtml(item)}</p>`).join("");
}

export function renderList(items = [], renderItem) {
  return items.map((item, index) => renderItem(item, index)).join("");
}

export function xmlEscape(value) {
  return `${value ?? ""}`
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&apos;");
}
