<?php
require("includes/config.inc.php");
require_once("includes/content.inc.php");

?>
<!DOCTYPE html>
<html><head>

  <title>Studentenzentrum Z10 e.V.</title>
  <link rel="stylesheet" type="text/css" href="styles/style_sepross14.css">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">

<body class="body">

<div class="maincontainer">

<div class="header">
   <div class="logo"><a href=index.php?topic=home><img src="imgs/z10-logo.png"></a></div>
   <div class="headertitle">
   <h1>Studentenzentrum Zähringerstraße 10 e.V.</h1>
   <h2>von Studis, für Studis</h2>
   </div>
</div>

<div class="headermenu">
   <!-- jeden Link einfach nur mit <a href=$href>$name</a> einbinden -->
   <?php echo getMenu() ?>
   </div>
</div>



<div class="centercontent">
<h3 style="width:414px; margin: auto; margin-top: 200px; ">Sorry ...</h3>
        <div class="welcometext" style="width:400px; margin: auto; text-align: center;">
        <!-- Willkommenstext -->

        Der Zugriff auf diesen Teil der Homepage wurde aus Gründen der Sicherheit vorübergehend deaktiviert.
        </div>
</div>
</body></html>

