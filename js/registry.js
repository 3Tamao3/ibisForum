// registry.js
// This runs AFTER the HTML is loaded (so our elements actually exist).
document.addEventListener("DOMContentLoaded", function () {
  // ----------------------------
  // 1) Career extra fields logic
  // ----------------------------
  const careerYes = document.getElementById("career_yes");
  const careerNo = document.getElementById("career_no");
  const extraFields = document.getElementById("careerExtraFields");

  if (extraFields) {
    const extraInputs = extraFields.querySelectorAll("input, select, textarea");

    function setExtraFieldsEnabled(enabled) {
      extraFields.style.display = enabled ? "block" : "none";

      extraInputs.forEach((el) => {
        el.disabled = !enabled;

        // Only phone & email become required when enabled
        if (el.id === "phone" || el.id === "email") {
          el.required = enabled;
        }

        // Clear values when hiding
        if (!enabled) {
          el.value = "";
        }
      });
    }

    function updateCareerFields() {
      const shouldShow = careerYes && careerYes.checked;
      setExtraFieldsEnabled(shouldShow);
    }

    // Run once on page load
    updateCareerFields();

    // Run when radio changes
    if (careerYes) careerYes.addEventListener("change", updateCareerFields);
    if (careerNo) careerNo.addEventListener("change", updateCareerFields);
  }

  // --------------------------------------
  // 2) Provider "Sonstige" show/hide input
  // --------------------------------------
  const dropdown = document.getElementById("provider_select");
  const input = document.getElementById("provider_sonstige");

  function checkSonstigeProvider() {
    if (!dropdown || !input) return;

    // IMPORTANT: your HTML uses value="Sonstige" (capital S)
    // so we must compare with "Sonstige"
    const isSonstige = dropdown.value === "Sonstige";

    input.style.display = isSonstige ? "block" : "none";
    input.required = isSonstige;

    if (!isSonstige) {
      input.value = "";
    }
  }

  // Run once + when dropdown changes
  checkSonstigeProvider();
  if (dropdown) dropdown.addEventListener("change", checkSonstigeProvider);

  // ----------------------------
  // 3) flatpickr for appointment
  // ----------------------------
  // This only works if flatpickr library is loaded before this file.
  flatpickr("#appointment", {
    allowInput: true,
    dateFormat: "Y-m-d",
    minDate: "today",
    maxDate: new Date().fp_incr(30),
    disable: [
      "today",
      function (date) {
        // Only allow Monday (1)
        return date.getDay() !== 1;
      },
    ],
  });
});
