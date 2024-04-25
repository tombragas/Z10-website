<?php
$header = <<<EOD
<!DOCTYPE html>
<html lang="en" class="tut">
    <head>
    <link rel="shortcut icon" href="bilder/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="tut-style.css">
     <meta charset="UTF-8" />
        <title>30 Jahre Z10 - Festwoche vom 10. - 15. Juni 2013</title>
        <!--[if lt IE 9]>
         <script src="dist/html5shiv.js"></script>
         <![endif]-->
        <!-- <link href='http://fonts.googleapis.com/css?family=Droid+Serif|Molengo' rel='stylesheet' type='text/css'> -->

        <!--[if IE]>
            <script type="text/javascript" src="js-files/explorercanvas.js"></script>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>
    <!--[if lt IE 7]> <div style=' clear: both; height: 59px; padding:0 0 0 15px; position: relative;'> <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." /></a></div> <![endif]-->
    <div class="maincontentbands">
    <div class="maincontentbox">

    <div class="seperate" style="width:700px; margin-left:50px; margin-top:180px">
    <p style="width:700px; text-align:justify;">
    <div style="margin-left:200px; width:300px; height:100px; background-image:url(fonts/__WAS__font.png);"></div>


EOD;

$picsstart = <<<EOD
    <div class="bandsite" style="border-width:2px; border-style:solid; border-color:#ba3e35; margin-bottom:20px; margin-left:0px; margin-right:20px; width:700px; height:200px;">

EOD;

$picitem = <<<EOD
    <article style="background-image:url(bilder/__PICFILE__); opacity:1; background-position:center; width:700px; height:200px"></article>

EOD;
$picitemmore = <<<EOD
    <article style="background-image:url(bilder/__PICFILE__); opacity:0; background-position:center; width:700px; height:200px; margin-top:-200px"></article>

EOD;

$picsend = "</div>\n";

$footer = <<<EOD
         <p align="center" class="space-top"><mark><a href="index.html">Zurück zur Übersicht</a></mark></p>
      </div>
      <div id="minheight"></div>
   </div>

   <footer class="seperate space-top">
      <p>
         <b><a href="http://www.z10.info">www.z10.info</a></b>
      </p>
   </footer>
</div>

<script type="text/JavaScript" src="changepics.js"></script>

</body>
</html>
EOD;
