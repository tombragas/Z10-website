<?php
include("sidebar.php");
include("functions.inc.php");
if( array_key_exists( 'delid', $_GET ) ) {
   if( !$delid = arrayKey( 'delid', $_GET ) ) 
      echo "<div align='center'><b>Fehler!</b><br><br>Keine Id zum L&ouml;schen angegeben<br><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div>";
   else 
      echo "<div align='center'>Willst du die Belegung wirklich l&ouml;schen?<br><a href='delbelegung.php?reallydelid=$delid'>Oh ja!</a><br></div>";
}
elseif( array_key_exists( 'reallydelid', $_GET ) ) {
   $fehler = false;
   if( !$rdelid = arrayKey( 'reallydelid', $_GET ) ) 
      $fehler = 'Fehlerhafter Link: keine Id gefunden';
   else {
      $result = checkBerechtigung( $mysqli, $rdelid );
      if( $result[0] != 2 )
         $fehler = $result[1];
   }

   if( !$fehler ) {
      $stmt = $mysqli->prepare( "DELETE FROM z10_proberaumbelegung WHERE id=?" );
      $stmt->bind_param( 'i', $rdelid );
      $stmt->execute();
      if( $stmt->affected_rows == 1 )
         echo "<div align='center'><br><br>Belegung erfolgreich entfernt<br><br><a href='main.php'>Zur&uuml;ck</a><br></div>";
      else
         $fehler = 'Belegung konnte nicht entfernt werden. Bitte wende dich an einen Administrator.';
   }

   if( $fehler ) 
      echo "<div align='center'><b>Fehler!</b><br><br>$fehler<br><a href='main.php'>Zur&uuml;ck</a><br></div>";
}
else
   echo "<div align='center'><b>Fehler!</b><br><br>Fehlerhafter Link: keine Id gefudnen<br><a href='main.php'>Zur&uuml;ck</a><br></div>";
include("footer.php");
?>
