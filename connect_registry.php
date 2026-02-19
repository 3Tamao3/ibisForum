<?php
// connect.php
// This file receives the form data and inserts it into the database.

// 1) Basic "only allow POST" safety check
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("This page only accepts form submissions.");
}

// 2) Database connection settings (XAMPP defaults)
$host = "localhost";
$dbname = "ibis_formula";
$username = "root";
$password = ""; // XAMPP default is empty

// 3) Connect using PDO (safe + modern)
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 4) Helper function to safely read POST values
function post(string $key): ?string
{
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : null;
}

// 5) Helper: convert common date strings to MySQL DATE (YYYY-MM-DD)
function toMysqlDate(?string $dateString): ?string
{
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

// 6) Read values from the form (names must match your HTML 'name=""')
$lastName = post("lastName");
$firstName = post("firstName");
$familyStatus = post("familyStatus");
$socialSecurityNumber = post("socialSecurityNumber");

$provider_select = post("provider_select");
$provider_sonstige = post("provider_sonstige");

$career = post("career"); // "career_yes" or "career_no"

// These fields only exist if career_yes, but we still read them safely:
$phone = post("phone");
$email = post("email");
$appointmentRaw = post("appointment");

// Convert appointment to MySQL format (YYYY-MM-DD)
$appointment = toMysqlDate($appointmentRaw);

// 7) If career_no, ignore the extra fields so you don't store garbage
if ($career !== "career_yes") {
    $phone = null;
    $email = null;
    $appointment = null;
}

// 8) Insert into database using a prepared statement
$sql = "INSERT INTO registry
    (lastName, firstName, familyStatus, socialSecurityNumber, provider_select, provider_sonstige, career, phone, email, appointment)
VALUES
    (:lastName, :firstName, :familyStatus, :socialSecurityNumber, :provider_select, :provider_sonstige, :career, :phone, :email, :appointment)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":lastName" => $lastName,
    ":firstName" => $firstName,
    ":familyStatus" => $familyStatus,
    ":socialSecurityNumber" => $socialSecurityNumber,
    ":provider_select" => $provider_select,
    ":provider_sonstige" => $provider_sonstige,
    ":career" => $career,
    ":phone" => $phone,
    ":email" => $email,
    ":appointment" => $appointment
]);

header("Location: subsites/success.php");
exit;
