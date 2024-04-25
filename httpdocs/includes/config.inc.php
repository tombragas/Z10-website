<?php

$ROOTURL = str_replace('admin', '', "https://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']));
$ROOTDIR = '/var/www/vhosts/hosting1234.af90a.netcup.net/httpdocs/';

// Eventl noch kleiner?
ini_set('upload_max_filesize', '1M');

/*
 * Mysqli Verbindung...
 */
$mysqli = new mysqli(
   '10.35.249.9',      /* HOST */
   'k34741_z10',            /* USER */
   'Pqqx292_',     /* PW   */
   'k34741_z10'             /* DB   */
);

if (mysqli_connect_errno()) {
   printf("Verbindung zur Datenbank Server fehlgeschlagen: '%s'\n", mysqli_connect_error());
   exit;
}

$mysqli->set_charset('utf8');

// nicht ideal hier..
cleanUP($mysqli);

/*
 * "elegantisiert" 14.5.11 - SVB
 * Gibt an ob grade Semesterferien sind
 */
function getFerien()
{
   date_default_timezone_set('Europe/Berlin');
   $date = date('nd');
   $startsommer = 212;   // 12. Feb 
   $endsommer   = 414;   // 14. April 
   $startwinter = 719;   // 19. Juli
   $endwinter   = 1010;  // 10. Okt
   if ($date > $startsommer and $date < $endsommer)
      return true;
   if ($date > $startwinter and $date < $endwinter)
      return true;

   return false;
}
$semesterferien = getFerien();


/*
 * Holt Texte und gibt sie zur�ck. Sorgt f�r einen guten Anteil des Homepage-Contents
 * 14.5.11 SVB: umgestellt auf mysqli
 */
function getContent($mysqli, $id)
{
   $stmt = $mysqli->prepare("SELECT content FROM z10_texte WHERE name=?");
   $stmt->bind_param('s', $id);
   $stmt->execute();

   $stmt->store_result();
   $stmt->bind_result($content);
   $stmt->fetch();

   return $content;
}

/*
 * PHP stinkt. Deswegen m�ssen wir uns das hier selbst bauen -.-
 */
function arrayKey($key, $array)
{

   if (array_key_exists($key, $array) and !empty($array[$key]))
      return $array[$key];
   else
      return false;
}

/*
 * Alte Adressen aus der Verteiler Warteliste l�schen und alte Kursanmeldungen rauswerfen
 */
function cleanUp($mysqli)
{

   $stmt = $mysqli->prepare("DELETE FROM z10_emails_verify WHERE zeit < NOW()");
   $stmt->execute();
   $stmt->close();

   $stmt = $mysqli->prepare("DELETE FROM z10_kurse_anmeldungen WHERE zeit < NOW() AND aktiv = 0");
   $stmt->execute();
   $stmt->close();
}

/*
 * Holt Termine aus der Datenbank und gibt sie als ass. Array zur�ck
 * $aktuell gibt an, ob vergange oder aktuelle Termine zur�ckgegeben werden
 * $nurjahr gibt an, ob die Suche auf ein spezielles Jahr eingeschr�nkt wird
 *       Angabe als YY oder YYYY
 */
function getTermine($mysqli, $aktuell = true, $nurjahr = false)
{

   $query = "
      SELECT 
         z10_termine.id, 
         UNIX_TIMESTAMP(z10_termine.zeitpunkt),
         z10_termine.name, 
         z10_termine.text,
         z10_kategorien.name,
         z10_termine.bild
      FROM z10_termine, z10_kategorien 
      WHERE z10_termine.kategorie = z10_kategorien.id 
         AND ";
   if ($aktuell)
      $query .= "DATE(zeitpunkt) >= CURDATE() ORDER BY zeitpunkt";
   else {
      $query .= "DATE(zeitpunkt) < CURDATE()";
      if ($nurjahr) {
         $nurjahr = date('Y', mktime(0, 0, 0, 1, 1, $nurjahr));
         $query .= " AND EXTRACT( YEAR FROM zeitpunkt ) = ?";
      }
      $query .= " ORDER BY zeitpunkt";
   }

   $stmt = $mysqli->prepare($query);

   if ($nurjahr)
      $stmt->bind_param('s', $nurjahr);

   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($id, $zeit, $name, $bild, $text, $kategorie);

   $termine = array();
   while ($stmt->fetch()) {
      $termine[] = array(
         'id'        => $id,
         'zeitpunkt' => $zeit,
         'name'      => $name,
         'bild'      => $bild,
         'text'      => $text,
         'kategorie' => $kategorie,
      );
   }

   $stmt->close();
   return $termine;
}
