<?php
/**
 * Builds a html select (dropdown) to select times
 * Contains half and full hours
 * @param $name - name for the html element (ends up in $_POST later)
 * @param $start - first element (e.g. 08:00)
 * @param $end - last element. Has to be "later" than start
 * @param $selected - the selected element
 * @return void
 **/ 
function buildTimeSelect( $name, $start, $end, $selected ) { 

   $select = "<select name='$name'>\n";
   $st = explode( ':', $start );
   $en = explode( ':', $end   );  

   $min = $st[1];
   for( $hour = $st[0]; $hour <= $en[0]; ) { 
      $time = sprintf( "%02d:%02d", $hour, $min );
      $select .= "<option value ='$time'";
      if( $time == $selected ) {
         $select .= ' selected';
      }

      $select .= ">$time</option>\n";

      $min += 30;
      if( $min == 60 ) {
         $min = 0;
         $hour++;
      }
      if( $time == $end )
         $hour++;
   }

   $select .= "</select>\n";
   return $select;
}

/**
 * Generates a list of dates starting today ending in 4 weeks
 * @return array( 'dd', 'mm', 'yyyy', 'DAYNAME', 'yy' )
 **/ 
function genDates() {

   $maxfuture = $_SESSION['allowfuture'];

   $mydate = new DateTime();
   $dates = array();
   for( $i = 0; $i < $maxfuture; $i++ ) {
      $datearr = explode( '-', $mydate->format( 'd-m-Y-N-y' ) );
      $datearr[3] = getGerDayname( $datearr[3] );
      if( $mydate->format( 'N' ) != 7 ) {
         array_push( $dates, $datearr );
      }
      $mydate->modify( '+1 day' );
   }
   return $dates;
}

/**
 * Since PHP's date() function only returns english day names, I do it myself
 * takes input created by date( 'N' )
 * @param $dayofweek - date( 'N' )
 * @return german weekday name
 **/ 
function getGerDayname( $dayofweek ) {
   $days = array( 'none', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So' );
   return $days[$dayofweek];
}


/**
 * Checks if the logged in user is allowed to edit a given entry
 * ACCESS can have the following values: 
 * * 0: no access (e.g. data not found)
 * * 1: read only 
 * * 2: read/write access
 * @param $mysqli - a mysqli object for the db connection
 * @param $belegid - the id of the entry
 * @return array( ACCESS, INFOTEXT )
 **/ 
function checkBerechtigung( $mysqli, $belegid ) {
   $stmt = $mysqli->prepare( "SELECT probebands_id, ende FROM z10_proberaumbelegung WHERE id=?" );
   $stmt->bind_param( 's', $belegid );
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result( $bandid, $ende );

   if( $stmt->num_rows == 0 )
      return array( 0, "Belegung mit Id '$belegid' konnte nicht in der Datenbank gefunden werden." );

   if( $stmt->fetch() ) {
      $now  = new DateTime();
      $end = new DateTime( $ende );

      if( $end > $now AND $bandid == $_SESSION['bandid'] ) {
         return array( 2, "Alles super" );
      }
      elseif( $bandid != $_SESSION['bandid'] ) {
         return array( 1, "Belegung mit Id '$belegid' geh&ouml;rt einem anderen Benutzer und kann nicht entfernt oder bearbeitet werden" );
      }
      elseif( $end < $now ) {
         return array( 1, "Belegung mit Id '$belegid' liegt in der Vergangenheit und kann nicht mehr entfernt oder bearbeitet werden" );
      }

   }
   return array( 0, "Unbekannter Fehler. Bitte wende dich an einen Administrator" );
}

/**
 * Generates the table for 1 day
 * @param $dayentries - entries for that day
 * @param $rowheight - the height of the table/week row
 * @return - a <td>...</td> string to insert  in the outer table
 **/ 
function genDayTd( $dayentries, $rowheight ) {

   $tdcode = "<td width='14%' style='border:1px solid'><table width='100%' style='text-align:center'>\n";
   foreach( $dayentries as $entry ) {
      $bname = '';
      // Emtpy cells are uncoloured; if a cell is editable it looks different than a non-editable cell
      if( !$entry['id'] ) {
         $cellclass = 'emptycell';
      }
      else {
         $bname = $entry['start'] . "-"  . $entry['end'] . ": ";

         if( isset( $_SESSION ) AND $entry['name'] == $_SESSION['bandname'] ) {
            $cellclass = "owncell";
         }
         else {
            $cellclass = "entrycell";
         }
      }

      // There are 28 time slots, so if we give each slot 3,5% height, we have 2% spare space
      $trh = floor( $entry['slots'] * $rowheight / 28 );

      // if the entry is editable we need to generate a link
      if( $entry['edit'] )
         $bname .= "<a href='editbelegung.php?id=" . $entry['id'] . "'>" . $entry['name'] . "</a>";
      else
         $bname .= $entry['name'];

      $tdcode .= "<tr class='$cellclass' style='height:$trh'><td class='caltd'>$bname</td></tr>\n";
   }
   $tdcode .= "</table></td>\n";

   return $tdcode;
}

/**
 * Helper callback function for usort to sort by the starttime
 **/ 
function sortByStart( $a, $b ) {
   if( $a['startslot'] < $b['startslot'] )
      return -1;
   elseif( $a['startslot'] > $b['startslot'] )
      return 1;
   else
      return 0;
}

/**
 * Takes an almost untouched sql result for 1 day and calculates slot counts and 
 * adds empty slots in between the entries
 * @param $dayentries - entries of a whole day
 * @return - a processed entries array
 **/ 
function processDay( $dayentries ) {

   foreach( $dayentries as &$entry ) {

      list( $temp, $stime )        = explode( ' ', $entry['start'] );
      list( $shour, $smin, $temp ) = explode( ':', $stime );
      $entry['start']              = "$shour:$smin";
      $entry['startslot']          = ( ( ( $shour - 8 ) * 60 ) + $smin ) / 30;

      list( $temp, $etime )        = explode( ' ', $entry['end'] );
      list( $ehour, $emin, $temp ) = explode( ':', $etime );
      $entry['end']                = "$ehour:$emin";
      $entry['endslot']            = ( ( ( $ehour - 8 ) * 60 ) + $emin ) / 30;

      $entry['slots']              = $entry['endslot'] - $entry['startslot'];
   }

   usort( $dayentries, 'sortByStart' );
   $dummy = array( 
      'name'  => '',
      'edit'  => false, 
      'id'    => false,
   );

   $belegung = array();
   $lastendslot = 0;
   foreach( $dayentries as $termin ) {
      // add an empty dummy, if neccessary
      if( $termin['startslot'] > $lastendslot ) {
         $emptyslot = $dummy;
         // Calc the start time. makes 0 to 08:00, 1 to 08:30 and 28 to 22:00
         $emptyslot['start'] = sprintf( "%02d:%02d", floor( $lastendslot * 30 / 60 ) + 8 ,
            ( $lastendslot * 30 ) % 60 );
         $emptyslot['end']   = $termin['start'];
         $emptyslot['slots'] = $termin['startslot'] - $lastendslot;
         array_push( $belegung, $emptyslot );
      }
      array_push( $belegung, $termin );
      $lastendslot = $termin['endslot'];
   }

   // if the last entry doesn't end at 22:00 (slot 28) we need to add another empty slot
   if( $lastendslot < 28 ) {
      $emptyslot = $dummy;
      // Calc the start time. makes 0 to 08:00, 1 to 08:30 and 28 to 22:00
      $emptyslot['start'] = sprintf( "%02d:%02d", floor( $lastendslot * 30 / 60 ) + 8 ,
         ( $lastendslot * 30 ) % 60 );
      $emptyslot['end']   = '22:00';
      $emptyslot['slots'] = 28 - $lastendslot;
      array_push( $belegung, $emptyslot );
   }

   return $belegung;
}

?>
