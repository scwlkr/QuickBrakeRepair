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
