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

const buildServicesDropdown = () => {
  if (!siteNav || siteNav.querySelector(".site-nav__group--services")) {
    return null;
  }

  const premiumLink = findNavLink("/premium/");
  const standardLink = findNavLink("/standard/");

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

  const insertBeforeTarget = findNavLink("/areas-we-serve/") || premiumLink;

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
  if (body.classList.contains("page-home") && siteHeader && homeLightSection) {
    const lightSectionTop = homeLightSection.getBoundingClientRect().top;
    const headerThreshold = siteHeader.offsetHeight + 12;
    body.classList.toggle("is-scrolled", lightSectionTop <= headerThreshold);
    return;
  }

  body.classList.toggle("is-scrolled", window.scrollY > 8);
};

syncScrolledState();

let scrolledStateFrame = null;

const requestScrolledStateSync = () => {
  if (scrolledStateFrame !== null) {
    return;
  }

  scrolledStateFrame = window.requestAnimationFrame(() => {
    syncScrolledState();
    scrolledStateFrame = null;
  });
};

window.addEventListener("scroll", requestScrolledStateSync, { passive: true });
window.addEventListener("resize", requestScrolledStateSync);

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

const contactFormStatus = document.querySelector("[data-form-status]");

const syncContactFormStatus = () => {
  if (!contactFormStatus) {
    return;
  }

  const params = new URLSearchParams(window.location.search);

  if (params.get("submitted") !== "1") {
    return;
  }

  contactFormStatus.hidden = false;
  contactFormStatus.textContent =
    "Thanks. Your request was submitted and should be in the Quick Brake Repair inbox for follow-up.";
};

const initializeRevealMotion = () => {
  const revealSections = [
    ...document.querySelectorAll("main > section, main > article, .site-footer"),
  ];

  if (!revealSections.length) {
    return;
  }

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const revealTargetSelectors = [
    ".hero__content",
    ".hero__support",
    ".hero-card",
    ".hero-stats",
    ".section-heading",
    ".content-stack",
    ".section-visual",
    ".service-pane",
    ".coverage-link",
    ".reviews-score",
    ".reviews-points",
    ".testimonial",
    ".card",
    ".article-block",
    ".article-sidebar",
    ".contact-intro__copy",
    ".contact-intro__media",
    ".site-footer__cta",
    ".site-footer__column",
    ".site-footer__bottom",
  ];
  const revealVariants = ["up", "up-soft", "left", "right", "scale"];
  const seenTargets = new Set();
  const revealTargets = [];

  revealSections.forEach((section, sectionIndex) => {
    const sectionTargets = [];

    revealTargetSelectors.forEach((selector) => {
      section.querySelectorAll(`:scope ${selector}`).forEach((element) => {
        if (seenTargets.has(element)) {
          return;
        }

        seenTargets.add(element);
        sectionTargets.push(element);
      });
    });

    sectionTargets.forEach((element, targetIndex) => {
      const variant =
        revealVariants[(sectionIndex + targetIndex) % revealVariants.length];

      element.dataset.reveal = variant;
      element.style.setProperty(
        "--reveal-delay",
        `${Math.min(targetIndex * 70, 280)}ms`,
      );

      revealTargets.push(element);
    });
  });

  if (!revealTargets.length) {
    return;
  }

  if (reduceMotion || !("IntersectionObserver" in window)) {
    revealTargets.forEach((element) => {
      element.classList.add("is-visible");
    });

    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        entry.target.classList.remove("is-pending");
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.18,
      rootMargin: "0px 0px -8% 0px",
    },
  );

  revealTargets.forEach((element) => {
    const elementTop = element.getBoundingClientRect().top;

    if (elementTop < window.innerHeight * 0.82) {
      element.classList.add("is-visible");
      return;
    }

    element.classList.add("is-pending");
    observer.observe(element);
  });

  body.classList.add("has-reveal-motion");
};

syncContactFormStatus();
initializeRevealMotion();
