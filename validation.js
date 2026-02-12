function calculateChecksum(svnr) {

  // Each position has a fixed multiplier
  var multipliers = [3, 7, 9, 0, 5, 8, 4, 2, 1, 6];

  var total = 0;

  for (var i = 0; i < multipliers.length; i++) {

    // Convert character to integer
    var digit = parseInt(svnr[i], 10);
    total = total + (digit * multipliers[i]);
  }
  return total % 11;
}


function isValidSvnr(svnr) {

  // Remove everything that is not a number
  svnr = svnr.replace(/\D/g, "");

  // Must be 10 digits long
  if (svnr.length !== 10) return false;

  // First digit may not be 0
  if (svnr[0] === "0") return false;

  var calculatedChecksum = calculateChecksum(svnr);

  var controlDigit = parseInt(svnr[3], 10);


  if (calculatedChecksum === controlDigit) {
    return true;
  } else {
    return false;
  }
}

var inputField = document.getElementById("scnr");
var infoMessage = document.getElementById("svnrMessage");

if (inputField && infoMessage) {
  inputField.addEventListener("input", function () {

    if (isValidSvnr(inputField.value)) {
      infoMessage.style.display = "block";
    } else {
      infoMessage.style.display = "none";
    }

  });
}
