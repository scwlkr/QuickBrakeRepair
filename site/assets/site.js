const menuToggle = document.querySelector(".menu-toggle");
const siteNav = document.querySelector(".site-nav");
const body = document.body;
const mobileNavBreakpoint = 1100;

const buildServicesDropdown = () => {
  if (!siteNav || siteNav.querySelector(".site-nav__group--services")) {
    return null;
  }

  const premiumLink = siteNav.querySelector('a[href="/premium/"]');
  const standardLink = siteNav.querySelector('a[href="/standard/"]');

  if (!premiumLink || !standardLink) {
    return null;
  }

  const dropdownGroup = document.createElement("div");
  dropdownGroup.className = "site-nav__group site-nav__group--services";

  const trigger = document.createElement("button");
  trigger.type = "button";
  trigger.className = "site-nav__link site-nav__trigger";
  trigger.textContent = "Services";
  trigger.setAttribute("aria-expanded", "false");
  trigger.setAttribute("aria-haspopup", "true");
  trigger.setAttribute("aria-controls", "site-nav-services");

  if (
    premiumLink.classList.contains("is-active") ||
    standardLink.classList.contains("is-active")
  ) {
    trigger.classList.add("is-active");
  }

  const dropdown = document.createElement("div");
  dropdown.className = "site-nav__dropdown";
  dropdown.id = "site-nav-services";
  dropdown.append(premiumLink, standardLink);

  dropdownGroup.append(trigger, dropdown);

  const insertBeforeTarget =
    siteNav.querySelector('a[href="/areas-we-serve/"]') || premiumLink;

  siteNav.insertBefore(dropdownGroup, insertBeforeTarget);

  return { dropdownGroup, trigger };
};

const servicesDropdown = buildServicesDropdown();

const closeServicesMenu = () => {
  if (!servicesDropdown) {
    return;
  }

  servicesDropdown.dropdownGroup.classList.remove("is-open");
  servicesDropdown.trigger.setAttribute("aria-expanded", "false");
};

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
