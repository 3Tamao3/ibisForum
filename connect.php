<?php
$gender       = $_POST['gender'] ?? null;
$lastName     = $_POST['lastName'] ?? null;
$firstName    = $_POST['firstName'] ?? null;
$scnr         = $_POST['scnr'] ?? null;
$birthday     = $_POST['birthday'] ?? null;
$birthCountry = $_POST['birthCountry'] ?? null;
$birthCity    = $_POST['birthCity'] ?? null;
$street       = $_POST['street'] ?? null;
$houseNumber  = $_POST['houseNumber'] ?? null;
$staircase    = $_POST['staircase'] ?? null;
$door         = $_POST['door'] ?? null;
$zip          = $_POST['zip'] ?? null;
$city         = $_POST['city'] ?? null;
$phone        = $_POST['phone'] ?? null;
$email        = $_POST['email'] ?? null;
$appointment = $_POST['appointment'] ?? null;


$meldezettel  = $_FILES['meldezettel']['name'] ?? null;
$birthCert    = $_FILES['birthCert']['name'] ?? null;
$citizenship  = $_FILES['citizenship']['name'] ?? null;
$bankCard     = $_FILES['bankCard']['name'] ?? null;
$ecard        = $_FILES['ecard']['name'] ?? null;
$residence    = $_FILES['residence']['name'] ?? null;

$provider     = $_POST['provider'] ?? null;
$career       = $_POST['career'] ?? null;
$kontakt_phone = $_POST['kontakt_phone'] ?? null;
$kontakt_email = $_POST['kontakt_email'] ?? null;
$kontakt = $_POST['kontakt'] ?? null;
$kontakt_betreuer = $_POST['kontakt_betreuer'] ?? null;
$kontakt_vorname = $_POST['kontakt_vorname'] ?? null;
$kontakt_nachname = $_POST['kontakt_nachname'] ?? null;
$kontakt_straße = $_POST['kontakt_straße'] ?? null;
$kontakt_houseNumber = $_POST['kontakt_houseNumber'] ?? null;
$kontakt_straircase = $_POST['kontakt_straircase'] ?? null;
$kontakt_door = $_POST['kontakt_door'] ?? null;
$kontakt_zip = $_POST['kontakt_zip'] ?? null;
$kontakt_ort = $_POST['kontakt_ort'] ?? null;
$kontakt_phone = $_POST['kontakt_phone'] ?? null;

$connection = new mysqli('localhost', 'root', '', 'ibis_formula');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

$stmt1 = $connection->prepare("
    INSERT INTO teilnahmebogen
    (gender, last_name, first_name, scnr, birthday, birth_country, birth_city, street, house_number, staircase, door, zip, city, phone, email, meldezettel, birth_cert, citizenship, bank_card, ecard, residence)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt1->bind_param(
    "sssssssssssssssssssss",
    $gender,
    $lastName,
    $firstName,
    $scnr,
    $birthday,
    $birthCountry,
    $birthCity,
    $street,
    $houseNumber,
    $staircase,
    $door,
    $zip,
    $city,
    $phone,
    $email,
    $meldezettel,
    $birthCert,
    $citizenship,
    $bankCard,
    $ecard,
    $residence
);

$stmt1->execute();
$stmt1->close();

if ($provider !== null || $career !== null || $phone !== null || $email !== null) {

    $stmt2 = $connection->prepare("
  INSERT INTO career_check (scnr, provider, career, phone, email, appointment)
  VALUES (?, ?, ?, ?, ?, ?)
");
    $stmt2->bind_param("ssssss", $scnr, $provider, $career, $phone, $email, $appointment);

    $stmt2->execute();
    $stmt2->close();
}

$connection->close();

header("Location: success.html");
exit();
