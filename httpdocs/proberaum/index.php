<?php
// Hier gibts Logins, wir wollen SLL!
if( !array_key_exists( 'HTTPS', $_SERVER ) OR $_SERVER["HTTPS"] != "on") {
   header("HTTP/1.1 301 Moved Permanently");
   header("Location: https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
   exit();
}

include("../includes/config.inc.php");
include("siteconfig.inc.php");
$stmt = $mysqli->prepare( "SELECT id, name FROM z10_probebands WHERE password!='!' AND room=? ORDER BY name" );
$stmt->bind_param("i", $query_room);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name );

?>
<html>
<head>
   <title>Z10 <?php echo($roomstrings["general:title"]);?></title>
   <link rel="shortcut icon" type="image/x-icon" href="../z10favicon.png" />
   <link rel="stylesheet" type="text/css" href="../styles/style_sepross14.css" />
</head>
<body>
<!-- <?php echo($_SERVER["REQUEST_URI"]);?>-->
  <div align="center">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><img width="145px" height="101" src="../imgs/z10-logo_260pxbreit.png" alt="" /></td>
      </tr>
      <tr>
        <td align="center">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td align="center" valign="middle"><span style="font-size:28px;"><?php echo($roomstrings["general:title"]);?></span><br />
              </td>
            </tr>
          </table><!-- main menu -->
          <table border="0" cellpadding="8px" cellspacing="0" width="100%">
            <tr>
              <td width="95%" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td class="boxtop1"></td>
                    <td class="boxtop2">
                      <div class="boxtop3">
                        Bitte einloggen
                      </div>
                    </td>
                    <td class="boxtop4"></td>
                  </tr><!-- middle -->
                  <tr>
                      <div class="boxmid3" align="left">
                        <span style="font-weight: bold;">
<form action="login.php" method="post">
<table cellspacing="10" cellpadding="10">
<tr><td>Name:</td><td> <select name="bandid">
<?php
while ($stmt->fetch() ) {
      echo "<option value='$id'>$name</option>";
   }
$stmt->close();
?>
</select></td></tr>
<tr><td>Passwort:</td><td> <input type="password" style="color: black;" size="24" maxlength="50" name="pass"></td></tr></table>
<div align="center"><input type="submit" style="color: black;" value="Einloggen"></div>
</form>
                        </span>
                      </div>
                    </td>

                  </tr><!-- bottom -->
                  <tr>
                    <td class="boxbot1"></td>
                    <td class="boxbot2"></td>
                    <td class="boxbot3"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table><!-- bottom -->
        </td>
      </tr>
    </table>
  </div>
 </body>
</html>
