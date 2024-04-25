<?php
include("sidebar.php");
include("functions.inc.php");

if (array_key_exists( 'belegdatum', $_POST ) ) {
   $fehler = false;

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
         $fehler = "&Uuml;bermittelte Startzeit ist ung&uuml;ltig<br>"; }
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
   
   // Check if there are any colliding entries
   if( !$fehler ) {
      $stmt = $mysqli->prepare( "SELECT start, ende FROM z10_proberaumbelegung, z10_probebands WHERE z10_probebands.id = z10_proberaumbelegung.probebands_id AND ((start<=? AND ende>?) OR (start<? AND ende>=?) OR (start>=? AND ende<=?)) AND room=?" );
      $stmt->bind_param( 'ssssssi', $sqlstart, $sqlstart, $sqlend, $sqlend, $sqlstart, $sqlend, $query_room );
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result( $colstart, $colend );
      if ( $stmt->fetch() ) {
         $fehler = "Konnte Belegung von $sqlstart bis $sqlend nicht eintragen:<br>Es existiert bereits eine kollidierende Belegung:<br>$colstart bis $colend";
      }
   }
   
   // We can now finally insert the new entry
   if( !$fehler ) {
      $stmt = $mysqli->prepare( "INSERT INTO z10_proberaumbelegung (probebands_id, start, ende) VALUES (?, ?, ?)" );
      $stmt->bind_param( 'iss', $_SESSION['bandid'], $sqlstart, $sqlend );
      $stmt->execute();
      if( $stmt->affected_rows == 1 ) {
         echo "<div align='center'><br><br>Belegung erfolgreich eingetragen<br><br><a href='main.php'>Zur&uuml;ck</a><br></div>";
      }
      else
         $fehler = 'Belegung konnte nicht eingetragen werden. Bitte wende dich an einen Administrator.';
   }

   if( $fehler )
      echo "<div align='center'><b>Fehler!</b><br><br>$fehler<br><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div>";
}
else {
   $dates = genDates();

   $now = new DateTime();
   $dateselect = "<select name='belegdatum'>";
   foreach( $dates as $date ) {
      list( $day, $month, $year, $dayname, $shortyear ) = $date;
      $dateselect .= "<option value='$year-$month-$day'";
      if( $now->format( 'Y-m-d' ) == "$year-$month-$day" ) 
         $dateselect .= ' selected';

      $dateselect .= ">$dayname, $day.$month.$shortyear</option>\n";
   }
   $dateselect .= '</select>';
   $startselect = buildTimeSelect( 'startzeit', '08:00', '21:30', '08:00' );
   $endselect = buildTimeSelect( 'endzeit', '08:30', '22:00', '08:30' );
?>
   <h1>Belegung eintragen</h1>
   <form action="eintragen.php" method="post">
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
      <div align="center"><input type="submit" value="Eintragen"></div>
   </form>
<?php
}
include("footer.php");
?>
