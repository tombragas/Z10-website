<?php

$kursanmeldung = arrayKey('kursanmeldung', $_GET);
$id = arrayKey('id', $_GET);
if (!$id)
  $id = arrayKey('id', $_POST);

$query = "SELECT z10_kurse.name, maxteilnehmer, COUNT(z10_kurse_anmeldungen.name) 
   FROM z10_kurse 
   LEFT JOIN z10_kurse_anmeldungen ON z10_kurse.id = z10_kurse_anmeldungen.kurse_id 
   WHERE z10_kurse.id=? AND anmeldeschluss > NOW()
   GROUP BY kurse_id";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($kursname, $maxteil, $anmeldungen);
$stmt->fetch();

if ($stmt->num_rows == 0) {
  http_response_code(404);
  $ueb = 'Fehler!';
  $msg = "Der angegebene Kurs existiert nicht oder ist bereits vorbei";
  // FIXME
  $msg .= '<br><a href="/kurse" class="button">Zurück zur Kursübersicht</a>';
} elseif ($anmeldungen >= $maxteil) {
  $ueb = 'Kurs voll';
  $msg = 'Der Kurs den du gewählt hast ist leider voll. Schau doch in ein paar Tagen nochmal vorbei, evtl. meldet sich noch jemand ab.';
  // FIXME
  $msg .= '<br><a href="/kurse" class="button">Zurück zur Kursübersicht</a>';
  http_response_code(404);
} elseif ($kursanmeldung == 1) {
  $msg = '';

  $vorname = htmlspecialchars(strip_tags(arrayKey('vorname', $_POST)));
  $name    = htmlspecialchars(strip_tags(arrayKey('name', $_POST)));
  $email   = htmlspecialchars(strip_tags(arrayKey('email',   $_POST)));
  $telefon = htmlspecialchars(strip_tags(arrayKey('telefon', $_POST)));
  if (!$telefon) {
    $telefon = 'Telefonnummer nicht angegeben';
  }

  if (!$vorname or !$name or !$email) {
    $ueb = 'Fehler!';
    $msg .= 'Ein Feld wurde nicht ausgefült!<br> Anmeldung konnte nicht abgeschlossen werden!<br><a href="javascript:history.back()">Zurück</a></div>';
  } else {
    $estmt = $mysqli->prepare("SELECT email FROM z10_kurse_anmeldungen WHERE kurse_id=? AND email=?");
    $estmt->bind_param('is', $id, $email);
    $estmt->execute();
    $estmt->store_result();
    $estmt->fetch();
    if ($estmt->num_rows > 0) {
      $ueb = "Fehler!";
      $msg .= 'Es ist schon jemand mit dieser Emailadresse angemeldet! Anmeldung konnte nicht abgeschlossen werden!<br><a href="javascript:history.back()">Zurück</a></div>';
    } else {
      // anmeldung vornehmen 
      $tan = rand(100000000, 999999999);
      $ablaufzeit = time() + (24 * 3600);

      $istmt = $mysqli->prepare("INSERT INTO z10_kurse_anmeldungen (vorname, name, email, telefon, kurse_id, tan, zeit) VALUES (?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?) )");
      $istmt->bind_param('ssssiii', $vorname, $name, $email, $telefon, $id, $tan, $ablaufzeit);
      $istmt->execute();

      if ($istmt->affected_rows > 0) {
        $urltan = urlencode($tan);

        $url = "https://test.z10.whka.de/send_mail.php";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        error_reporting(E_NOTICE);

        $headers = array(
          "Content-Type: application/x-www-form-urlencoded",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "secret=^ebXF3i@t4g3j8wVPD^#c24ZnQFi4hLZyrjpejzN9p1PGv^hvYNb9VZArWt#h@1^&email=$email&course_name=$kursname&first_name=$vorname&urltan=$urltan";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        //echo "<pre>";
        //var_dump($resp);


        $ueb = 'Anmeldung FAST fertig';
        $msg = 'Die Anmeldung war erfolgreich.<br> In wenigen Minuten müßte dich eine Email erreichen.<br> Um die Anmeldung abzuschliessen klicke bitte auf den entsprechenden Link in der Email. Danke!<br><br> Sollte keine E-Mail ankommen, melde dich bei admin@z10.info <div align="center"><a href="?topic=kurse">Zurück</a></div> ';
      } else {
        $ueb = 'Fehler!';
        $msg = 'Es kam zu einem Datenbankfehler.  Anmeldung konnte nicht abgeschlossen werden!<br> <a href="javascript:history.back()">Zurück</a><br><br>';
      }
    }
  }
} else {
  $ueb = "Anmeldung für den Kurs <h2 style='overflow-wrap: anywhere;'>$kursname</h2>";
  // FIXME
  $msg = <<<HTML
  <style>
    .kursform {
      display: grid;
      gap: 1rem 2rem;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
  </style>
<form class="kursform" action="/kurs_anmeldung?kursanmeldung=1" method="post" onsubmit="this.sub.value=\'Bitte warten...\'; this.sub.disabled=\'true\';">
<div><label for="forename">Vorname:</label>
<input type="text" id="forename" class="textfield" name="vorname" autocomplete="given-name" required></div>
<div><label for="lastname">Name:</label>
<input type="text" id="lastname" class="textfield" name="name" autocomplete="family-name" required></div>
<div><label for="email">E-Mailadresse:</label>
<input type="email" id="email" class="textfield" name="email" autocomplete="email" required></div>
<div><label>Telefonnummer:</label>
<input type="tel" class="textfield" name="telefon" placeholder="optional"></div>
<div class='text' style="grid-column: 1/-1"><br>Die Anmeldung ist unverbindlich, allerdings bitten wir Dich, Dich nur anzumelden, 
wenn Du auch teilnehmen willst, da meist nur eine begrenzte Anzahl an Plätzen vorhanden ist.<br>
Nach der Anmeldung erhälst Du eine Email. 
In Dieser Email steht ein Link den Du anklicken mußt, um deine Anmeldung abzuschliessen.  <br>
</div>
<input type="submit" name="sub" value="Anmelden" class="sendbutton">
<input type="hidden" name="id" value="$id">
</form>
HTML;
}

$stmt->close();
echo "<h2>$ueb</h2>";
echo "<div class='contentbox'>$msg</div>";
