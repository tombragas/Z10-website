<?php
include("sidebar.php");
include("functions.inc.php");
$maintableheight = 560;
// Select für vergangene Termine
$daysback = arrayKey( 'daysback', $_POST );
?>
<form action='main.php' method='post' name='pastselect'>
Zeitraum: <select name='daysback' onchange='javascript:document.pastselect.submit()'>
<?php
$select = '';
for( $i = 0; $i < 15; $i++ ) {
   $goback = $i * 28;
   $select .= "<option value='$goback'";
   if( $goback == $daysback )
      $select .= ' selected';
   $select .= '>';

   if( $i == 0 )
      $select .= 'aktuell';
   else
      $select .= 'vor ' . $i * 4 . ' Wochen';
      
   $select .= "</option>\n";
}
echo $select;
echo"</select></form>\n";

$now = new DateTime();
$calstart = clone $now;
// Option to see past entries
if( $daysback > 0 )
   $calstart->modify( "-$daysback days" );

$in_4_weeks = clone $now;
$in_4_weeks->modify( '+27 days' );

// Start the fun...
$calentries = array();
for( $idate = clone $calstart; $idate <= $in_4_weeks; $idate->modify( '+1 day' ) ) {
   $sqlday = $idate->format( 'Y-m-d' );
   $stmt = $mysqli->prepare( "SELECT z10_proberaumbelegung.id, name, probebands_id, start, ende FROM z10_probebands, z10_proberaumbelegung WHERE z10_probebands.id = z10_proberaumbelegung.probebands_id AND DATE(start)=DATE(?) AND z10_probebands.room=?" );
   $stmt->bind_param( 'si', $sqlday, $query_room );
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result( $belegid, $bandname, $bandid, $start, $ende );

   $dayentries = array();
   while( $stmt->fetch() ) {

      $edit = false;
      if( $bandid == $_SESSION['bandid'] and new DateTime( $ende ) > $now )
         $edit = true;

      array_push( $dayentries, array( 
         'start' => $start,
         'end'   => $ende,
         'name'  => $bandname,
         'edit'  => $edit, 
         'id'    => $belegid,
      ) );
   }
   $stmt->close();

   $calentries[$idate->format( 'd.m.Y' )] = processDay( $dayentries );
}

// CALENDAR START
$idate = clone $calstart;
// Outer loop = weeks
for( $i = 1; $i <= 4; $i++ ) {
   // first we generate the date headers
   $tday = clone $idate;
   echo "<table class='caltable'>\n<tr class='datecell' style='height:10'>\n";
   for( $k = 1; $k <= 7; $k++ ) {
      $headerdate = getGerDayname( $tday->format( 'N' ) ) . ", " . $tday->format( 'd.m.y' );
      echo "<td width='14%'>$headerdate</td>\n";
      $tday->modify( '+1 day' );
   }
   echo "</tr></table>\n";
   // now the main table
   echo "<table class='caltable' height='$maintableheight'>\n";
   echo '<tr>';
   // Inner loop = days
   for( $j = 1; $j <= 7; $j++ ) {
      $thisdate = $idate->format( 'd.m.Y' );
      echo genDayTd( $calentries[$thisdate], $maintableheight );
      $idate->modify( '+1 day' );
   }
   echo "</tr>\n</table>\n";
}
// CALENDAR END

include("footer.php");
?>
