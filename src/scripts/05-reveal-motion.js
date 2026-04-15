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
    ".site-footer__grid > section",
    ".site-footer__meta",
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
