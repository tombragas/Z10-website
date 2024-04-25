<?php
$mid = arrayKey( 'mid', $_GET );
$tan = arrayKey( 'tan', $_GET );

if (!$mid) {
   $msg = 'Fehler! Es wurde keine Emailadresse übergeben';
}
elseif (!$tan) {
   $msg = 'Fehler! Es wurde keine TAN übergeben';
}
else {
   $query = "SELECT email, z10_kurse.name, tan, vorname, z10_kurse_anmeldungen.name, betreueremail
      FROM z10_kurse_anmeldungen, z10_kurse 
      WHERE email=? AND z10_kurse_anmeldungen.kurse_id = z10_kurse.id AND z10_kurse_anmeldungen.tan=?";
   $stmt = $mysqli->prepare( $query );
   $stmt->bind_param( 'si', $mid, $tan );
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result( $email, $kursname, $dbtan, $vorname, $nachname, $betreueremail );
   $stmt->fetch();
   if ($stmt->num_rows) {
      if ( $tan != $dbtan ) {
         $msg = "Fehler! Die übergebene Tan ist inkorrekt";
      }
      else {

         $dstmt = $mysqli->prepare( "DELETE FROM z10_kurse_anmeldungen WHERE email=? AND tan=?" );
         $dstmt->bind_param( 'si', $mid, $tan );
         $dstmt->execute();

         if ($dstmt->affected_rows > 0) {
            $msg = "Deine Anmeldung zum Kurs <b><i>$kursname</i></b> wurde soeben erfolgreich <b>gelöscht</b>";
            $betreuermailtext = <<<EOT
Hallo,

soeben hat sich

 $vorname $nachname ($email) 

vom Kurs $kursname abgemeldet.

Viele liebe Grüße,
Dein Kursverwaltungssystem

EOT;
            foreach( explode( ',', $betreueremail ) as $bmail ) {
               mail($bmail, "Z10-Kursabmeldung", $betreuermailtext, "From: Z10-Kultur <z10@z10.info>");
            }
         }
         else 
            $msg = "Deine Anmeldung zum Kurs <b><i>$kursname</i></b> konnte leider nicht gelöscht werden.";
      }

   } 
   else 
      $msg = 'Du bist nicht zu diesem Kurs angemeldet oder Deine Anmeldung wurde bereits gelöscht.';
}

echo "<h4>Kurs löschen</h4><div class='contentbox'>$msg</div>";
?>

