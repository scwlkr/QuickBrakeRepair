import path from "node:path";

const posixPath = path.posix;

export function directoryForSlug(slug) {
  return slug || ".";
}

export function pageFilePath(slug) {
  return slug ? posixPath.join(slug, "index.html") : "index.html";
}

export function canonicalPath(slug) {
  return slug ? `/${slug}` : "";
}

export function canonicalUrl(siteUrl, slug) {
  return `${siteUrl}${canonicalPath(slug)}`;
}

export function relativePageUrl(fromSlug, toSlug) {
  const relativePath = posixPath.relative(
    directoryForSlug(fromSlug),
    directoryForSlug(toSlug),
  );

  return relativePath ? `${relativePath}/` : "./";
}

export function relativeAssetUrl(fromSlug, assetPath) {
  return posixPath.relative(directoryForSlug(fromSlug), assetPath);
}

export function resolveReferencePath(currentFilePath, reference) {
  const sanitizedReference = reference.split("#")[0].split("?")[0];

  if (!sanitizedReference) {
    return null;
  }

  if (sanitizedReference.endsWith("/")) {
    return path.resolve(currentFilePath, sanitizedReference, "index.html");
  }

  const extension = path.extname(sanitizedReference);

  if (!extension) {
    return path.resolve(currentFilePath, sanitizedReference, "index.html");
  }

  return path.resolve(currentFilePath, sanitizedReference);
}
