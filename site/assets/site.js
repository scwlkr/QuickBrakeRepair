const menuToggle = document.querySelector(".menu-toggle");
const siteNav = document.querySelector(".site-nav");
const body = document.body;

const syncScrolledState = () => {
  body.classList.toggle("is-scrolled", window.scrollY > 8);
};

syncScrolledState();
window.addEventListener("scroll", syncScrolledState, { passive: true });

if (menuToggle && siteNav) {
  const closeNav = () => {
    menuToggle.setAttribute("aria-expanded", "false");
    menuToggle.setAttribute("aria-label", "Open navigation");
    menuToggle.classList.remove("is-active");
    siteNav.classList.remove("is-open");
    body.classList.remove("has-open-nav");
  };

  const openNav = () => {
    menuToggle.setAttribute("aria-expanded", "true");
    menuToggle.setAttribute("aria-label", "Close navigation");
    menuToggle.classList.add("is-active");
    siteNav.classList.add("is-open");
    body.classList.add("has-open-nav");
  };

  menuToggle.setAttribute("aria-label", "Open navigation");

  menuToggle.addEventListener("click", () => {
    const expanded = menuToggle.getAttribute("aria-expanded") === "true";
    if (expanded) {
      closeNav();
      return;
    }

    openNav();
  });

  siteNav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", closeNav);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeNav();
    }
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > 1040) {
      closeNav();
    }
  });
}
