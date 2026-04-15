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
