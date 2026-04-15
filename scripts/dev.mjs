import { extname, resolve, sep } from "node:path";
import { stat } from "node:fs/promises";

const siteRoot = resolve(process.cwd());
const port = Number(process.env.PORT || 3000);
const host = process.env.HOST || "localhost";

const mimeTypes = new Map([
  [".css", "text/css; charset=utf-8"],
  [".gif", "image/gif"],
  [".html", "text/html; charset=utf-8"],
  [".ico", "image/x-icon"],
  [".jpeg", "image/jpeg"],
  [".jpg", "image/jpeg"],
  [".js", "text/javascript; charset=utf-8"],
  [".json", "application/json; charset=utf-8"],
  [".map", "application/json; charset=utf-8"],
  [".png", "image/png"],
  [".svg", "image/svg+xml"],
  [".ttf", "font/ttf"],
  [".txt", "text/plain; charset=utf-8"],
  [".webmanifest", "application/manifest+json; charset=utf-8"],
  [".webp", "image/webp"],
  [".woff", "font/woff"],
  [".woff2", "font/woff2"],
  [".xml", "application/xml; charset=utf-8"],
]);

function contentType(filePath) {
  const ext = extname(filePath).toLowerCase();
  if (ext) {
    return mimeTypes.get(ext) || "application/octet-stream";
  }

  const base = filePath.split(/[\\/]/).pop();
  if (base === "atom") return "application/atom+xml; charset=utf-8";
  if (base === "rss2") return "application/rss+xml; charset=utf-8";

  return "application/octet-stream";
}

function isWithinSiteRoot(filePath) {
  return filePath === siteRoot || filePath.startsWith(`${siteRoot}${sep}`);
}

async function fileExists(filePath) {
  try {
    return (await stat(filePath)).isFile();
  } catch {
    return false;
  }
}

async function resolveAsset(pathname) {
  let decodedPath;
  try {
    decodedPath = decodeURIComponent(pathname);
  } catch {
    return null;
  }

  const stripped = decodedPath.replace(/^\/+/, "");
  const candidates =
    decodedPath === "/"
      ? ["index.html"]
      : stripped.endsWith("/")
        ? [stripped, `${stripped}index.html`]
        : [stripped, `${stripped}/index.html`];

  for (const relativePath of candidates) {
    const absolutePath = resolve(siteRoot, relativePath);
    if (!isWithinSiteRoot(absolutePath)) continue;
    if (await fileExists(absolutePath)) return absolutePath;
  }

  return null;
}

Bun.serve({
  hostname: host,
  port,
  async fetch(request) {
    const url = new URL(request.url);
    const filePath = await resolveAsset(url.pathname);

    if (!filePath) {
      return new Response("Not Found", {
        status: 404,
        headers: {
          "content-type": "text/plain; charset=utf-8",
        },
      });
    }

    return new Response(Bun.file(filePath), {
      headers: {
        "cache-control": "no-store",
        "content-type": contentType(filePath),
      },
    });
  },
});

console.log(`Serving ${siteRoot} at http://${host}:${port}/`);
