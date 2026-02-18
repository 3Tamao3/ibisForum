<!doctype html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title data-i18n="page_title_registry"></title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="icon" type="image/png" href="../imgs/img_ibis_logo.png" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
</head>

<body>
  <div class="classCenterBox">
    <div class="classTopRow">
      <img src="../imgs/img_ibis_logo.png" alt="ibis acam Logo" />
      <div class="classLanguageButtons">
        <button type="button" class="class-btn-liquid liquid" id="btnDE">DE</button>
        <button type="button" class="class-btn-liquid liquid" id="btnEN">EN</button>
      </div>
    </div>
    <h1 data-i18n="registration_title"></h1>
    <form action="../connect.php" method="post" enctype="multipart/form-data">
      <div class="classSameLine">
        <div>
          <label data-i18n="lastname"></label><br />
          <input required type="text" id="lastName" name="lastName" pattern="[A-Za-zÀ-žßäöüÄÖÜ\s\-]+"

            data-i18n-placeholder="lastname_ph" /><br />
        </div>
        <div>
          <label data-i18n="firstname"></label><br />
          <input required type="text" id="firstName" name="firstName" pattern="[A-Za-zÀ-žßäöüÄÖÜ\s\-]+"

            data-i18n-placeholder="firstname_ph" /><br />
        </div>
      </div>
      <div>
        <label data-i18n="family_status"></label><br />
        <select required class="classProviderDropdown" name="familyStatus">
          <option disabled selected data-i18n="choose"></option>
          <option value="single" data-i18n="family_status_single"></option>
          <option value="married" data-i18n="family_status_married"></option>
          <option value="divorced" data-i18n="family_status_divorced"></option>
          <option value="widowed" data-i18n="family_status_widowed"></option>
          <option value="registeredPartnership" data-i18n="family_staus_registered"></option>
        </select>
      </div>
      <br>
      <div>
        <label data-i18n="social_security_number"></label><br />
        <input required type="text" id="socialSecurityNumber" name="socialSecurityNumber" pattern="[0-9]{10}"
          data-i18n-placeholder="social_security_number_ph" /><br />
      </div>
      <p data-i18n="social_security_number_text" id="socialSecurityNumberMessage"
        style="color: rgb(7, 173, 7); display: none"></p>
      <div>
        <label>
          <span data-i18n="provider"></span>
          <span class="classInfo-icon" data-i18n-title="provider_info" title="" aria-label="Info">
            🛈
          </span> </label><br />

        <select required class="classProviderDropdown" name="provider_select" id="provider_select">

          <option value="" disabled selected data-i18n="choose"></option>

          <option value="AMS">AMS</option>
          <option value="BFI">BFI</option>
          <option value="IP_Center">IP Center</option>
          <option value="IT_Works">IT Works</option>
          <option value="JAW">JAW</option>
          <option value="Sprungbrett">Sprungbrett</option>
          <option value="UEBA_Blick">ÜBA Blick</option>
          <option value="VHS">VHS</option>
          <option value="WUK">WUK</option>
          <option value="Update_Training">Update Training</option>
          <option value="Income">Income</option>
          <option value="Context">Context</option>
          <option value="Afit">Afit</option>
          <option value="die_Berater">die Berater</option>
          <option value="Wienwork">Wienwork</option>
          <option value="Integrationshaus">Integrationshaus</option>
          <option value="Berufsboerse">Berufsbörse</option>
          <option value="BEST">BEST</option>
          <option value="UEBA_Check_In">ÜBA Check In</option>
          <option value="oesb_Consulting">ösb Consulting</option>
          <option value="Jugendcollege_Wien_Advanced_Ost">Jugendcollege Wien - advanced Ost ibis acam</option>
          <option value="Caritas">Caritas</option>
          <option value="UEBA_Flieger">ÜBA Flieger</option>
          <option value="ProVita">ProVita Bildungs GmbH</option>
          <option value="Jobmove">Jobmove</option>
          <option value="ABO_Jugend">ABO Jugend</option>
          <option value="Volkshilfe">Volkshilfe</option>
          <option value="Hanreich_Partner">Hanreich-Partner</option>
          <option value="OEJAB">ÖJAB</option>
          <option value="Berufsevent">Berufsevent</option>
          <option value="Equalizent">Equalizent</option>
          <option value="Jugendwerkstatt_IP_Center">Jugendwerkstatt / IP-Center</option>
          <option value="Mentor">Mentor</option>
          <option value="Jugendcollege_Advanced_Sued_BEST">Jugendcollege advanced SÜD - BEST</option>
          <option value="WITAF">WITAF</option>
          <option value="Jugendcollege_BFI">Jugendcollege BFI</option>
          <option value="Jugendcollege_Advanced_Sued_Mentor">Jugendcollege advanced SÜD - Mentor</option>
          <option value="Verein_TIW">Verein-TIW</option>
          <option value="Sonstige">Sonstige</option>
        </select>
        <br><br>
        <div>
          <input type="text" id="provider_sonstige" name="provider_sonstige" data-i18n-placeholder="provider_else_ph"
            style="display:none;" />

        </div>
      </div>

      <div>
        <p data-i18n="career_check_question"></p>
        <input type="radio" id="career_yes" name="career" value="career_yes" />
        <label for="career_yes" data-i18n="yes"></label><br />
        <input checked="checked" type="radio" id="career_no" name="career" value="career_no" />
        <label for="career_no" data-i18n="no"></label><br />
      </div>
      <br />
      <div id="careerExtraFields" style="display: none">
        <div>
          <label data-i18n="phone"></label><br />
          <input required type="tel" id="phone" name="phone" pattern="\+?[0-9\s\-]+"
            data-i18n-placeholder="phone_ph" /><br />
        </div>
        <div>
          <label data-i18n="email"></label><br />
          <input required type="email" id="email" name="email" data-i18n-placeholder="email_ph"
            pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" /><br />
        </div>
        <div>
          <label for="appointment" data-i18n="appointments"></label>
          <input required type="text" id="appointment" name="appointment" data-i18n-placeholder="date_ph" />
        </div>
      </div>
      <button type="submit" class="class-btn-liquid liquid" data-i18n="submit"></button>
      <a href="../index.php">
        <button type="button" class="class-btn-liquid liquid" data-i18n="back"></button>
      </a>
    </form>
  </div>
  <script src="../js/i18n.js"></script>
  <script src="../js/validation.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="../js/registry.js"></script>

</body>

</html>