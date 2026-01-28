function calculateChecksum(svnr) {
  var weights = [3, 7, 9, 0, 5, 8, 4, 2, 1, 6];
  var sum = 0;

  for (var i = 0; i < weights.length; i++) {
    sum = sum + weights[i] * parseInt(svnr[i], 10);
  }

  return sum % 11;
}

function isValidSvnr(svnr) {
  svnr = svnr.replace(/\D/g, "");

  if (svnr.length !== 10) return false;
  if (svnr.charAt(0) === "0") return false;

  var checksum = calculateChecksum(svnr);
  var controlDigit = parseInt(svnr.charAt(3), 10);

  return checksum === controlDigit;
}

var svnrInput = document.getElementById("scnr");
var message = document.getElementById("svnrMessage");

if (svnrInput && message) {
  svnrInput.addEventListener("input", function () {
    message.style.display = isValidSvnr(svnrInput.value) ? "block" : "none";
  });
}
