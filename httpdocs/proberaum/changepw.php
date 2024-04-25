<?php
include("sidebar.php");

if (array_key_exists( 'oldpass', $_POST ) ) {
   $fehler = false;
   if( !$oldpass = arrayKey( 'oldpass', $_POST ) ) 
      $fehler = "Das alte Passwort ist leer!";
   elseif( !$newpass1 = arrayKey( 'newpass1', $_POST ) ) 
      $fehler = "Das neue Passwort ist leer!";
   elseif( !$newpass2 = arrayKey( 'newpass2', $_POST ) ) 
      $fehler = "Das wiederholte neue Passwort ist leer!";
   elseif( strcmp( $newpass1, $newpass2 ) != 0 )
      $fehler = "Passw&ouml;rter stimmen nicht &uuml;berein!";
   elseif( strlen( $newpass1 ) < 6 )
      $fehler = "Das neue Passwort ist zu kurz. Verwende bitte mindestens 6 Zeichen.";
   elseif( is_int( strpos( $newpass1, ' ' ) ) )
      $fehler = "Das Passwort darf kein Leerzeichen enthalten.";
   
   // Check if the old pass is correct
   if( !$fehler ) {
      $stmt = $mysqli->prepare( "SELECT name FROM z10_probebands  WHERE id=? AND password=MD5(?)" );
      $stmt->bind_param( 'is', $_SESSION['bandid'], $oldpass );
      $stmt->execute();
      $stmt->store_result();
      if ( $stmt->num_rows != 1 ) {
         $fehler = "Ung&uuml;tiges altes Passwort!";
      }
   }

   // Now set the new password (if there is still no error)
   if( !$fehler ) {
      $stmt = $mysqli->prepare( "UPDATE z10_probebands SET password=MD5(?), changedpass=1 WHERE id=?" );
      $stmt->bind_param( 'si', $newpass1, $_SESSION['bandid'] );
      $stmt->execute();
      if( $stmt->affected_rows == 1 )
         echo "<div align='center'><br><br>Passwort erfolgreich ge&auml;ndert.<br><a href='main.php'>Zur&uuml;ck</a><br></div>";
      else
         $fehler = 'Passwort konnte nicht aktualisiert werden. Bitte wende dich an einen Administrator.';
   }

   if( $fehler )
      echo "<div align='center'><b>Fehler!</b><br><br>$fehler<br><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div>";
}
else {
?>
   <form action="changepw.php" method="post">
      <table>
         <tr>
            <td>Altes Passwort:</td>
            <td><input type="password" size="24" maxlength="50" name="oldpass"></td>
         </tr>
         <tr>
            <td>Neues Passwort:</td>
            <td><input type="password" size="24" maxlength="50" name="newpass1"></td>
         </tr>
         <tr>
            <td>Neues Passwort wiederholen:</td>
            <td><input type="password" size="24" maxlength="50" name="newpass2"></td>
         </tr>
      </table><br><br>
      <div align="center"><input type="submit" value="&Auml;ndern"></div>
   </form>
<?php
}
include("footer.php");
?>
