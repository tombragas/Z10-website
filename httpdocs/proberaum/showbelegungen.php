<?php
include("sidebar.php");
include("functions.inc.php");

// first shown entry: today
$calstart = new DateTime();

// if the user wants old entries, he gets old entries. Set calstart to 1.1.2012
if( array_key_exists( 'showold', $_GET ) )
   $calstart = new DateTime( '2012-01-01' );

$sqlcalstart = $calstart->format( 'Y-m-d' );


$stmt = $mysqli->prepare( "SELECT id, start, ende FROM  z10_proberaumbelegung WHERE probebands_id=? AND DATE(start)>=DATE(?) ORDER BY start" );
   $stmt->bind_param( 'is', $_SESSION['bandid'], $sqlcalstart );
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result( $belegid, $start, $ende );


   echo "<h1>Meine Belegungen (<a href='showbelegungen.php?showold'>Vergangenheit anzeigen</a>)</h1>\n<ul>\n";

   $usedslots = 0;
   while( $stmt->fetch() ) {

      list( $datum, $stime )        = explode( ' ', $start );
      list( $shour, $smin, $temp ) = explode( ':', $stime );
      $sslot =  ( ( ( $shour - 8 ) * 60 ) + $smin ) / 30;

      list( $datum, $etime )        = explode( ' ', $ende );
      list( $ehour, $emin, $temp ) = explode( ':', $etime );
      $eslot = ( ( ( $ehour - 8 ) * 60 ) + $emin ) / 30;

      $usedslots += $eslot - $sslot;

      $datum = new DateTime( $datum );
      $datum = getGerDayname( $datum->format( 'N' ) ) . ", " . $datum->format( 'd.m.y' );

      $edit   = "<a href='editbelegung.php?id=$belegid'>bearbeiten</a>";
      $delete = "<a href='delbelegung.php?delid=$belegid'>l&ouml;schen</a>";

      echo "<li> $datum: $shour:$smin - $ehour:$emin; $edit $delete</li>\n";
   }
   $stmt->close();
   echo "</ul>\n<br>";
   $belegungszeit = sprintf( "%d:%02d", floor( $usedslots * 30 / 60 ), ( $usedslots * 30 ) % 60 );

   echo "<div align='center'>Die gesamte Belegungszeit betr&auml;gt $belegungszeit</div><br>";
include("footer.php");
?>
