if (menuToggle && siteNav) {
  const closeNav = () => {
    menuToggle.setAttribute("aria-expanded", "false");
    menuToggle.setAttribute("aria-label", "Open navigation");
    menuToggle.classList.remove("is-active");
    siteNav.classList.remove("is-open");
    body.classList.remove("has-open-nav");
    closeServicesMenu();
  };

  const openNav = () => {
    menuToggle.setAttribute("aria-expanded", "true");
    menuToggle.setAttribute("aria-label", "Close navigation");
    menuToggle.classList.add("is-active");
    siteNav.classList.add("is-open");
    body.classList.add("has-open-nav");
  };

  menuToggle.setAttribute("aria-label", "Open navigation");

  if (servicesDropdown) {
    servicesDropdown.trigger.addEventListener("click", () => {
      if (window.innerWidth > mobileNavBreakpoint) {
        return;
      }

      const expanded =
        servicesDropdown.trigger.getAttribute("aria-expanded") === "true";

      servicesDropdown.dropdownGroup.classList.toggle("is-open", !expanded);
      servicesDropdown.trigger.setAttribute("aria-expanded", String(!expanded));
    });

    document.addEventListener("click", (event) => {
      if (
        window.innerWidth > mobileNavBreakpoint ||
        servicesDropdown.dropdownGroup.contains(event.target)
      ) {
        return;
      }

      closeServicesMenu();
    });

    servicesDropdown.dropdownGroup.addEventListener("focusout", (event) => {
      if (!servicesDropdown.dropdownGroup.contains(event.relatedTarget)) {
        closeServicesMenu();
      }
    });
  }

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
    if (window.innerWidth > mobileNavBreakpoint) {
      closeNav();
    }
  });
}
