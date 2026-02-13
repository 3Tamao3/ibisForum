// Wait until the page is fully loaded
document.addEventListener("DOMContentLoaded", function () {

    // Get all inputs with class "file-input"
    const fileInputs = document.querySelectorAll(".file-input");

    // Loop through each input
    fileInputs.forEach(function(input) {

        // Check when user selects a file
        input.addEventListener("change", function() {

            // If no file selected
            if (input.files.length === 0) {
                input.style.border = "2px solid red";
            } 
            // If file selected
            else {
                input.style.border = "2px solid green";
            }

        });

        // Also check immediately when page loads
        if (input.files.length === 0) {
            input.style.border = "2px solid red";
        }

    });

});