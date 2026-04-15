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
