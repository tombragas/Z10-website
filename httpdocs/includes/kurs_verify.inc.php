<?
$mid = arrayKey( 'mid', $_GET );
$tan = arrayKey( 'tan', $_GET );

if (!$mid) {
   $msg = 'Fehler! Es wurde keine Emailadresse übergeben';
}
elseif (!$tan) {
   $msg = 'Fehler! Es wurde keine TAN übergeben';
}
else {
   $query = "SELECT email, z10_kurse.name, tan, aktiv, vorname, z10_kurse_anmeldungen.name, betreueremail
      FROM z10_kurse_anmeldungen, z10_kurse 
      WHERE email=? AND z10_kurse_anmeldungen.kurse_id = z10_kurse.id AND tan=?";
   $stmt = $mysqli->prepare( $query );
   $stmt->bind_param( 'si', $mid, $tan );
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result( $email, $kursname, $dbtan, $aktiv, $vorname, $nachname, $betreueremail );
   $stmt->fetch();
   if ($stmt->num_rows) {
      if ( $aktiv == '1' )
         $msg = "Deine Anmeldung zum Kurs <b><i>$kursname</i></b> wurde schon bestätigt.";
      else {
         $ustmt = $mysqli->prepare( "UPDATE z10_kurse_anmeldungen SET aktiv=1 WHERE email=? AND tan=?" );
         $ustmt->bind_param( 'si', $mid, $tan );
         $ustmt->execute();

         if ($ustmt->affected_rows > 0) {
            $msg = "Deine Anmeldung zum Kurs <b><i>$kursname</i></b> wurde soeben erfolgreich abgeschlossen.";
            $betreuermailtext = <<<EOT
Hallo,

soeben hat sich

 $vorname $nachname ($email) 

zum Kurs $kursname angemeldet.

Viele liebe Grüße,
Dein Kursverwaltungssystem

EOT;
            foreach( explode( ',', $betreueremail ) as $bmail ) {
               mail($bmail, "Z10-Kursanmeldung", $betreuermailtext, "From: Z10-Kultur <z10@z10.info>");
            }
         }
         else 
            $msg = "Fehler! Es kam zu einem Datenbankfehler bei der Anmeldebestätigung zum Kurs <b><i>$kursname</i></b>";
      }
   } 
   else 
      $msg = 'Entweder du hast dich noch nicht angemeldet, die Tan ist falsch oder deine Anmeldung ist schon abgelaufen (Die Email muß innerhalb von 24 Stunden bestätigt werden).<br>Sollte letzteres der Fall sein so melde dich bitte erneut an.';
}

echo "<h4>Kurs Anmeldung bestätigen</h4><div class='contentbox'>$msg</div>";
?>

