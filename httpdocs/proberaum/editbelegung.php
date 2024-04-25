<?php
include("sidebar.php");
include("functions.inc.php");
if( array_key_exists( 'id', $_POST ) ) {
   $fehler = false;

   if( !$editid = arrayKey( 'id', $_POST ) )
      $fehler = "Keine EditId angegeben";
   if( !$datum = arrayKey( 'belegdatum', $_POST ) ) 
      $fehler = "Kein  Datum angegeben";
   elseif( !$startzeit = arrayKey( 'startzeit', $_POST ) ) 
      $fehler = "Keine Startzeit angegeben!";
   elseif( !$endzeit = arrayKey( 'endzeit', $_POST ) ) 
      $fehler = "Keine Endzeit angegeben!";
   else {
      try {
         $start = new DateTime( "$datum $startzeit" );
         $sqlstart = $start->format( 'Y-m-d H:i:s' );
      }
      catch (Exception $e ) {
         $fehler = "&Uuml;bermittelte Startzeit ist ung&uuml;ltig<br>";
      }
      try {
         $ende = new DateTime( "$datum $endzeit" );
         $sqlend = $ende->format( 'Y-m-d H:i:s' );
      }
      catch (Exception $e ) {
         $fehler .= "&Uuml;bermittelte Endzeit ist ung&uuml;ltig<br>";
      }
   }

   // Verify the given times
   if( !$fehler ) {
      $now = new DateTime();
      if( $now > $start )
         $fehler = "Startzeitpunkt liegt in der Vergangenheit";
      elseif( $now > $ende )
         $fehler = "Endzeitpunkt liegt in der Vergangenheit";
      elseif( $start >= $ende )
         $fehler = "Startzeitpunkt muss vor dem Endzeitpunkt liegen";
   }

   // Check if the user is allowed to edit this entry, if someone tampered with the POST data
   if( !$fehler ) {
      $result = checkBerechtigung( $mysqli, $editid );
      if( $result[0] != 2 )
         $fehler = "Du hast keine Berechtigung diesen Eintrag zu bearbeiten.";
   }

   // Check if there are any colliding entries
   if( !$fehler ) {
      $stmt = $mysqli->prepare( "SELECT start, ende FROM z10_proberaumbelegung, z10_probebands WHERE z10_probebands.id = z10_proberaumbelegung.probebands_id AND ((start<=? AND ende>?) OR (start<? AND ende>=?) OR (start>=? AND ende<=?)) AND z10_proberaumbelegung.id!=? AND room=?" );
      $stmt->bind_param( 'ssssssii', $sqlstart, $sqlstart, $sqlend, $sqlend, $sqlstart, $sqlend, $editid, $query_room );
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result( $colstart, $colend );
      if ( $stmt->fetch() ) {
         $fehler = "Konnte Belegung von $sqlstart bis $sqlend nicht eintragen:<br>Es existiert bereits eine kollidierende Belegung:<br>$colstart bis $colend";
      }
   }
   // We can now finally insert the new entry
   if( !$fehler ) {
      $stmt = $mysqli->prepare( "UPDATE z10_proberaumbelegung SET start=?, ende=? WHERE id=?" );
      $stmt->bind_param( 'ssi', $sqlstart, $sqlend, $editid );
      $stmt->execute();
      if( $stmt->affected_rows == 1 ) {
         echo "<div align='center'><br><br>Belegung erfolgreich aktualisiert<br><br><a href='main.php'>Zur&uuml;ck</a><br></div>";
      }
      else
         $fehler = 'Belegung konnte nicht aktualisiert werden. Bitte wende dich an einen Administrator.';
   }

   if( $fehler )
      echo "<div align='center'><b>Fehler!</b><br><br>$fehler<br><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div>";
}
else {
   $belegungsid = arrayKey( 'id', $_GET );
   $result = checkBerechtigung( $mysqli, $belegungsid );
   if( $result[0] == 0 ) 
      echo "<div align='center'><b>Fehler!</b><br><br>" . $result[1] . "<br><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div>";
   elseif( $result[0] == 1 ) {
      $stmt = $mysqli->prepare( "SELECT name, start, ende FROM z10_probebands, z10_proberaumbelegung WHERE z10_probebands.id = z10_proberaumbelegung.probebands_id AND z10_proberaumbelegung.id=? AND z10_probebands.room=?" );
      $stmt->bind_param( 'si', $belegungsid, $query_room );
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result( $name, $start, $ende );

      if( $stmt->fetch() ) {
         list( $datum, $stime ) = explode( ' ', $start );
         list( $datum, $etime ) = explode( ' ', $ende );
         $stime = substr( $stime, 0, 5 );
         $etime = substr( $etime, 0, 5 );
         $datum = new DateTime( $datum );
         $dshow = $datum->format( 'd.m.Y' );
?>
   <h1>Belegung anzeigen</h1>
      <table>
         <tr>
            <td>Band:</td>
            <td>&nbsp;&nbsp;<?php echo $name ?></td>
         </tr>
         <tr>
            <td>Datum:</td>
            <td>&nbsp;&nbsp;<?php echo $dshow ?></td>
         </tr>
         <tr>
            <td>Von:</td>
            <td>&nbsp;&nbsp;<?php echo $stime ?></td>
         </tr>
         <tr>
            <td>Bis:</td>
            <td>&nbsp;&nbsp;<?php echo $etime ?></td>
         </tr>
      </table><br><br>
      Info: <?php echo $result[1]; ?><br><br>
      <div align='center'><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div><br>
<?php
         $stmt->close();
      }
      else {
         echo "Unbekannter Fehler. Wende dich an einen Administrator";
      }
   }
   elseif( $result[0] == 2 ) {
      $stmt = $mysqli->prepare( "SELECT start, ende FROM z10_proberaumbelegung WHERE id=?" );
      $stmt->bind_param( 's', $belegungsid );
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result( $start, $ende );

      if( $stmt->fetch() ) {
         $dates = genDates();
         list( $datum, $stime ) = explode( ' ', $start );
         list( $datum, $etime ) = explode( ' ', $ende );
         $stime = substr( $stime, 0, 5 );
         $etime = substr( $etime, 0, 5 );
         $datum = new DateTime( $datum );

         $dateselect = "<select name='belegdatum'>";
         foreach( $dates as $date ) {
            list( $day, $month, $year, $dayname, $shortyear ) = $date;
            $dateselect .= "<option value='$year-$month-$day'";
            if( $datum->format( 'Y-m-d' ) == "$year-$month-$day" ) 
               $dateselect .= ' selected';

            $dateselect .= ">$dayname, $day.$month.$shortyear</option>\n";
         }
         $dateselect .= '</select>';
         $startselect = buildTimeSelect( 'startzeit', '08:00', '21:30', $stime );
         $endselect = buildTimeSelect( 'endzeit', '08:30', '22:00', $etime );
?>
   <h1>Belegung bearbeiten</h1>
   <form action="editbelegung.php" method="post">
      <input type="hidden" value="<?php echo $belegungsid ?>" name="id">
      <table>
         <tr>
            <td>Datum:</td>
            <td>&nbsp;&nbsp;<?php echo $dateselect ?></td>
         </tr>
         <tr>
            <td>Von:</td>
            <td>&nbsp;&nbsp;<?php echo $startselect ?></td>
         </tr>
         <tr>
            <td>Bis:</td>
            <td>&nbsp;&nbsp;<?php echo $endselect ?></td>
         </tr>
      </table><br><br>
      <div align="center"><input type="submit" value="Aktualisieren"></div>
   </form>
   <div align='center'><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div><br>
   <div align='right'><a href='delbelegung.php?delid=<?php echo $belegungsid ?>'>Belegung l&ouml;schen</a></div>
<?php
      }
      else {
         echo "Unbekannter Fehler. Wende dich an einen Administrator";
      }
   }
}


include("footer.php");
?>
