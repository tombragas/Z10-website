<?php
include("siteconfig.inc.php");
session_start();

include("../includes/config.inc.php");
$bandid = $_POST["bandid"];
$pass   = $_POST["pass"];

$stmt = $mysqli->prepare( "SELECT name, allowfuture FROM z10_probebands  WHERE id=? AND password=MD5(?) AND room=?" );
$stmt->bind_param( 'isi', $bandid, $pass, $query_room );
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $bandname, $allowfuture );
if ( $stmt->fetch() ) {
   $_SESSION['bandname'] = $bandname;
   $_SESSION['bandid']   = $bandid;
   $_SESSION['allowfuture'] = $allowfuture;
   $stmt->close();
   header( 'Location: main.php' );
   exit( 0 );
}
else {
   $stmt->close();
   echo "<div align='center'><b>Login fehlgeschlagen!</b><br><br><br><a href='javascript:history.back()'>Zur&uuml;ck</a><br></div>";
}

?>

