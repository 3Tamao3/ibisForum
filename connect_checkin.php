<?php
// connect_checkin.php
// Takes the big check-in form, uploads files, inserts everything into the `checkin` table.

// 1) Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("This page only accepts form submissions (POST).");
}

// 2) DB connection settings (XAMPP defaults)
$host = "localhost";
$dbname = "ibis_formula";   // <-- MUST match your database name
$username = "root";
$password = "";

// 3) Connect with PDO
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper: safely read POST values
function post(string $key): ?string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : null;
}

// Helper: convert common date strings to MySQL DATE (YYYY-MM-DD)
function toMysqlDate(?string $dateString): ?string {
    if (!$dateString) return null;

    // Try common formats first
    $formats = ["Y-m-d", "d.m.Y", "d/m/Y"];
    foreach ($formats as $f) {
        $dt = DateTime::createFromFormat($f, $dateString);
        if ($dt && $dt->format($f) === $dateString) {
            return $dt->format("Y-m-d");
        }
    }

    // Last attempt: let PHP guess
    $ts = strtotime($dateString);
    if ($ts !== false) {
        return date("Y-m-d", $ts);
    }

    return null;
}

// Helper: upload a single file and return the saved path (or null if none uploaded)
function uploadFile(string $inputName, string $uploadFolder = "uploads"): ?string {
    if (!isset($_FILES[$inputName])) {
        return null;
    }

    // No file chosen
    if ($_FILES[$inputName]["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    // Other upload error
    if ($_FILES[$inputName]["error"] !== UPLOAD_ERR_OK) {
        die("Upload error for '$inputName'. Error code: " . $_FILES[$inputName]["error"]);
    }

    // Make sure uploads folder exists
    if (!is_dir($uploadFolder)) {
        mkdir($uploadFolder, 0777, true);
    }

    $tmpPath = $_FILES[$inputName]["tmp_name"];
    $originalName = basename((string)$_FILES[$inputName]["name"]);

    // Optional: basic extension allowlist (adjust if needed)
    $allowed = ["pdf", "jpg", "jpeg", "png"];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    if ($ext && !in_array($ext, $allowed, true)) {
        die("File type not allowed for '$inputName'. Allowed: " . implode(", ", $allowed));
    }

    // Create unique file name
    $uniqueName = time() . "_" . bin2hex(random_bytes(6)) . "_" . $originalName;
    $targetPath = $uploadFolder . "/" . $uniqueName;

    if (!move_uploaded_file($tmpPath, $targetPath)) {
        die("Could not save uploaded file for '$inputName'.");
    }

    // Store relative path in DB (easier to use later)
    return $targetPath;
}

/* ---------------------------
   4) Read form fields (must match your HTML name="")
---------------------------- */

// Basic selections / radios
$teachingForm = post("teachingForm");
$apprenticeship = post("apprenticeship");
$preApprenticeshipPeriod = post("preApprenticeshipPeriod"); // your DB uses enum('yes','no')
$vocationalSchool = post("vocationalSchool");               // your DB uses enum('ongoing','no')
$gender = post("gender");

// Person data
$firstName = post("firstName");
$lastName = post("lastName");
$familyStatus = post("familyStatus");
$socialSecurityNumber = post("socialSecurityNumber");

// Birthday must be DATE in DB
$birthday = toMysqlDate(post("birthday"));

$birthCountry = post("birthCountry");
$birthCity = post("birthCity");

// Address
$street = post("street");
$houseNumber = post("houseNumber");
$staircase = post("staircase");
$door = post("door");
$zip = post("zip");
$city = post("city");

// Contact details
$phone = post("phone");
$email = post("email");

// Emergency/contact person section
$contactType = post("contact"); // HTML uses name="contact" but DB column is contactType
$contactAdvicer = post("contactAdvicer");

$contactFirstName = post("contactFirstName");
$contactLastName = post("contactLastName");
$contactStreet = post("contactStreet");
$contactHouseNumber = post("contactHouseNumber");

// NOTE: your HTML field is literally name="contactStraircase" (typo),
// and your DB column is contactStraircase. So we use that exact spelling.
$contactStraircase = post("contactStraircase");

$contactDoor = post("contactDoor");
$contactZIP = post("contactZIP");
$contactCity = post("contactCity");
$contactPhone = post("contactPhone");

// School + note
$lastSchoolForm = post("lastSchoolForm");
$note = post("note");

/* ---------------------------
   5) Upload files
   DB columns are named exactly like this in your table:
   registrationForm, birthCert, citizenship, bankCard, ecard, residence
---------------------------- */

$registrationForm = uploadFile("registrationForm");
$birthCert        = uploadFile("birthCert");
$citizenship      = uploadFile("citizenship");
$bankCard         = uploadFile("bankCard");
$ecard            = uploadFile("ecard");
$residence        = uploadFile("residence");

/* ---------------------------
   6) Insert into DB (table name: checkin)
---------------------------- */

$sql = "INSERT INTO checkin (
    teachingForm, apprenticeship, preApprenticeshipPeriod, vocationalSchool, gender,
    firstName, lastName, familyStatus, socialSecurityNumber,
    birthday, birthCountry, birthCity,
    street, houseNumber, staircase, door,
    zip, city,
    phone, email,
    contactType, contactAdvicer,
    contactFirstName, contactLastName, contactStreet, contactHouseNumber, contactStraircase, contactDoor,
    contactZIP, contactCity, contactPhone,
    lastSchoolForm, note,
    registrationForm, birthCert, citizenship, bankCard, ecard, residence
) VALUES (
    :teachingForm, :apprenticeship, :preApprenticeshipPeriod, :vocationalSchool, :gender,
    :firstName, :lastName, :familyStatus, :socialSecurityNumber,
    :birthday, :birthCountry, :birthCity,
    :street, :houseNumber, :staircase, :door,
    :zip, :city,
    :phone, :email,
    :contactType, :contactAdvicer,
    :contactFirstName, :contactLastName, :contactStreet, :contactHouseNumber, :contactStraircase, :contactDoor,
    :contactZIP, :contactCity, :contactPhone,
    :lastSchoolForm, :note,
    :registrationForm, :birthCert, :citizenship, :bankCard, :ecard, :residence
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":teachingForm" => $teachingForm,
    ":apprenticeship" => $apprenticeship,
    ":preApprenticeshipPeriod" => $preApprenticeshipPeriod,
    ":vocationalSchool" => $vocationalSchool,
    ":gender" => $gender,

    ":firstName" => $firstName,
    ":lastName" => $lastName,
    ":familyStatus" => $familyStatus,
    ":socialSecurityNumber" => $socialSecurityNumber,

    ":birthday" => $birthday,
    ":birthCountry" => $birthCountry,
    ":birthCity" => $birthCity,

    ":street" => $street,
    ":houseNumber" => $houseNumber,
    ":staircase" => $staircase,
    ":door" => $door,

    ":zip" => $zip,
    ":city" => $city,

    ":phone" => $phone,
    ":email" => $email,

    ":contactType" => $contactType,
    ":contactAdvicer" => $contactAdvicer,

    ":contactFirstName" => $contactFirstName,
    ":contactLastName" => $contactLastName,
    ":contactStreet" => $contactStreet,
    ":contactHouseNumber" => $contactHouseNumber,
    ":contactStraircase" => $contactStraircase,
    ":contactDoor" => $contactDoor,

    ":contactZIP" => $contactZIP,
    ":contactCity" => $contactCity,
    ":contactPhone" => $contactPhone,

    ":lastSchoolForm" => $lastSchoolForm,
    ":note" => $note,

    ":registrationForm" => $registrationForm,
    ":birthCert" => $birthCert,
    ":citizenship" => $citizenship,
    ":bankCard" => $bankCard,
    ":ecard" => $ecard,
    ":residence" => $residence
]);

// 7) Redirect after success (create success.php if you want)
header("Location: subsites/success.php");
exit;
