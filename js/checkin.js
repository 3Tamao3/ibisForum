// This runs when the page is fully loaded
document.addEventListener("DOMContentLoaded", function () {

  // Initialize flatpickr calendar
  flatpickr("#birthday", {
    allowInput: true,
    dateFormat: "d-m-Y",
    maxDate: new Date().setFullYear(new Date().getFullYear() - 14),
  });

  // Get elements
  const birthdayInput = document.getElementById("birthday");
  const kontaktDiv = document.querySelector(".classContactYouth");

  // Listen for birthday changes
  birthdayInput.addEventListener("change", function () {

    // Convert input value to Date object
    const birthday = new Date(this.value.split("-").reverse().join("-"));
    const today = new Date();

    // Calculate age
    let age = today.getFullYear() - birthday.getFullYear();

    const monthDiff = today.getMonth() - birthday.getMonth();

    if (
      monthDiff < 0 ||
      (monthDiff === 0 && today.getDate() < birthday.getDate())
    ) {
      age--;
    }

    // Show guardian contact if under 18
    if (age <= 18) {
      kontaktDiv.style.display = "block";
    } else {
      kontaktDiv.style.display = "none";
    }

  });

});
