<?php
include("sidebar.php");
session_destroy();
echo "<div align='center'><b>Erfolgreich ausgeloggt!</b><br><br><a href='index.php'>Zur&uuml;ck zum Login</a><br></div>";
echo "<meta http-equiv='refresh' content='3' />";
include("footer.php");
?>
