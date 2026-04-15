const menuToggle = document.querySelector(".menu-toggle");
const siteNav = document.querySelector(".site-nav");
const body = document.body;
const mobileNavBreakpoint = 1100;
const siteHeader = document.querySelector(".site-header");
const homeHero = document.querySelector(".hero--home");
const homeLightSection = homeHero?.nextElementSibling;

const normalizePathname = (value) => {
  if (!value) {
    return "/";
  }

  return `${value}`.replace(/\/?$/, "/");
};

const findNavLink = (pathname) => {
  if (!siteNav) {
    return null;
  }

  return [...siteNav.querySelectorAll("a[href]")]
    .find((link) => {
      const href = link.getAttribute("href");

      if (!href || href.startsWith("#")) {
        return false;
      }

      const resolvedPathname = normalizePathname(new URL(href, window.location.href).pathname);

      return resolvedPathname === pathname || resolvedPathname.endsWith(pathname);
    }) || null;
};
