<?php

echo '<h1 class="title">Kurse</h1><div class="contentbox">' . getContent($mysqli, 'kurshinweis') . '</div>';

$query = <<<SQL
SELECT id, z10_kurse.name, UNIX_TIMESTAMP( anmeldeschluss ), beschreibung, gebuehr, maxteilnehmer, extern 
FROM z10_kurse 
WHERE anmeldeschluss > NOW() 
ORDER BY z10_kurse.name
SQL;
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $anmeldeschluss, $text, $gebuehr, $maxteilnehmer, $extern);

while ($stmt->fetch()) {

   $tstmt = $mysqli->prepare('SELECT COUNT(kurse_id) FROM z10_kurse_anmeldungen WHERE kurse_id=?');
   $tstmt->bind_param('i', $id);
   $tstmt->execute();
   $tstmt->store_result();
   $tstmt->bind_result($teilnehmer);
   $tstmt->fetch();

   $extadd = '';
   if ($extern != 'n') {
      $extadd = '<small>externer Kurs</small>';
   }

   $gebstr = '';
   if ($gebuehr != 0) {
      $gebstr .= "$gebuehr Euro";
   } else {
      $gebstr .= 'keine';
   }

   $anmeldeschluss = date("d.m.y", $anmeldeschluss);
   $plaetze = ($maxteilnehmer - $teilnehmer) . " von $maxteilnehmer";

   if ($maxteilnehmer == 0 or $maxteilnehmer > $teilnehmer) {
      // FIXME
      $anmeldung = "<a class='kursanmeldung' href='/kurs_anmeldung?id=$id'>Anmelden</a>\n";
   } else {
      $anmeldung = '<div class="kursanmeldung disabled">Kurs leider voll</div>';
   }

   echo <<<EOD
<div class="kurse">
   <div class="kursheader">
      <h3 class="kursname">$name</h3>
      $extadd
   </div>
   <div class="kurstext">
      <div class="course-tags">
      <div class="kursdeadline">Anmelden bis: $anmeldeschluss</div>
      <div class="kursteilnehmer">Freie Plätze: $plaetze</div>
      </div>
      <div class="kursbeschreibung">
      $text
      </div>
      <div class="clearfix" style="clear:inherit;"></div>
      <div class="kursgebuehr"><span>Teilnahmegebühr:</span> $gebstr</div>
      $anmeldung
   </div>
</div>
EOD;

   $tstmt->close();
}
$stmt->close();
echo '<h2 style="margin-top: 3rem">Alte Kurse</h2>';
echo '<div class="contentbox">' . getContent($mysqli, 'kursarchiv') . '</div>';

$query = <<<SQL
SELECT id, z10_kurse.name, UNIX_TIMESTAMP( anmeldeschluss ), beschreibung, gebuehr, extern 
FROM z10_kurse 
WHERE anmeldeschluss < NOW() 
AND EXTRACT( YEAR FROM anmeldeschluss) > 2018 
ORDER BY anmeldeschluss DESC, z10_kurse.name
SQL;
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $anmeldeschluss, $text, $gebuehr, $extern);

while ($stmt->fetch()) {

   // Externe Kurse brauchen wir nicht im Archiv.
   if ($extern == 'y') {
      continue;
   }

   if ($gebuehr != 0) {
      $gebstr = "$gebuehr €";
   } else {
      $gebstr = '-';
   }

   $anmeldeschluss = date("d.m.y", $anmeldeschluss);

   echo <<<HTML
<div class="kurse">
   <div class="kursheader">
      <h3 class="kursname">$name</h3>
   </div>
   <div class="kurstext">
      <div class="course-tags">
      <div class="kursdeadlinealt">Anmelden bis: $anmeldeschluss</div>
      <div class="kursgebuehralt">Kosten waren: $gebstr</div>
      </div>
      <div class="kursbeschreibung">
         $text
      </div>
   </div>
</div>
HTML;
}
$stmt->close();

// echo '&nbsp;</div>';
