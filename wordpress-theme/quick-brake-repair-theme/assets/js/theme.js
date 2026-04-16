(() => {
  const header = document.querySelector("[data-site-header]");
  const toggle = document.querySelector("[data-nav-toggle]");
  const panel = document.querySelector("[data-nav-panel]");

  if (header) {
    const syncHeaderState = () => {
      header.classList.toggle("is-scrolled", window.scrollY > 12);
    };

    syncHeaderState();
    window.addEventListener("scroll", syncHeaderState, { passive: true });
  }

  if (!toggle || !panel) {
    return;
  }

  const closeNav = () => {
    toggle.setAttribute("aria-expanded", "false");
    panel.classList.remove("is-open");
  };

  const openNav = () => {
    toggle.setAttribute("aria-expanded", "true");
    panel.classList.add("is-open");
  };

  toggle.addEventListener("click", () => {
    const expanded = toggle.getAttribute("aria-expanded") === "true";

    if (expanded) {
      closeNav();
      return;
    }

    openNav();
  });

  document.addEventListener("click", (event) => {
    if (panel.contains(event.target) || toggle.contains(event.target)) {
      return;
    }

    closeNav();
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeNav();
    }
  });
})();
