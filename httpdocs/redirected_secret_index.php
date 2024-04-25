<?php

function minify_output($buffer)
{
   $search = array(
      '/\>[^\S ]+/s', //strip whitespaces after tags, except space
      '/[^\S ]+\</s', //strip whitespaces before tags, except space
      '/(\s)+/s'  // shorten multiple whitespace sequences
   );
   $replace = array('>', '<', '\\1');
   $buffer = preg_replace($search, $replace, $buffer);
   global $topic;
   if ($topic != "mail") {
      $buffer = preg_replace_callback('/<a href="mailto:(.*)".*>(.*)<\/a>/Usi', 'protectMail', $buffer);
   }
   return $buffer;
}

function protectMail($addr)
{
   $mail = unpack('H*', $addr[1]);
   $maillink = '<a href="mail?to=' . array_shift($mail) . '" target="_blank" rel="nofollow">';
   $display  =  str_replace("@", '<img src="includes/bl_white.gif" border=0 alt="@" width=16 height=16 style="transform: translateY(2px)">', $addr[2]) .  '</a>';
   return $maillink . $display;
}


require("includes/config.inc.php");
require_once("includes/content.inc.php");
// require_once("includes/shoutbox.inc.php");
$topic = arrayKey('topic', $_GET);
if (!$topic)
   $topic = 'home';

// Allowed topics
$allowed = array(
   'home',
   // Static
   'cafe', 'historie', 'karte', 'kontakt', 'spiele', 'rauminfo', '403', 'stadtgeburtstag', 'spenden', 'awareness',
   // Kurse
   'kurs', 'kurse',    'kurs_delete',    'kurs_verify', 'kurs_anmeldung',
   //  Kram
   'archiv',   'shouthistory',   'wer',         'programm',       'termineics',
   // Hilfsfunktionen
   'helfer',   'hotlink',        'mail',       /* 'shout',*/    'chat',    'impressum',   'datenschutz',
);
if (!in_array($topic, $allowed)) {
   error_log(">>> TRIED TO ACCESS $topic <<<");
   $topic = "home";
}

ob_start("minify_output");

// Diese Unterseiten werden direkt eingebunden anstatt den Umweg über ein Include zu gehen
$loadContent = array(
   'historie',
   'karte',
   'cafe',
   'rauminfo',
   'stadtgeburtstag',
   '403',
   'impressum',
   'datenschutz',
   'spenden',
   'awareness'
);
?>
<!DOCTYPE html>
<html lang="de">

<head>

   <title><?= ucfirst($topic) ?> | Studentenzentrum Z10 e.V.</title>
   <?php // the version at the end of the css file updates the css immediately instead of 14 days or longer 
   ?>
   <link rel="stylesheet" type="text/css" href="/styles/style_ws1718_update.min.css?v=2.0">
   <?php if (!empty($_GET['theme']) && $_GET['theme'] == "ws22") : ?>
      <link rel="stylesheet" type="text/css" href="/styles/style_ws22.min.css?v=1.0.2">
   <?php elseif (!empty($_GET['theme']) && $_GET['theme'] == "ss23") : ?>
      <link rel="stylesheet" type="text/css" href="/styles/style_ss23.css?">
   <?php elseif (empty($_GET['theme']) || $_GET['theme'] != "old") : ?>
      <link rel="stylesheet" type="text/css" href="/styles/style_ss23.css?v=1">
      <link rel="stylesheet" type="text/css" href="/styles/style_ws23.css?">
   <?php endif; ?>
   <link rel="preload" href="/styles/basicLightbox.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
   <noscript>
      <link rel="stylesheet" href="/styles/basicLightbox.min.css">
   </noscript>
   <?php if ($topic == "home") {
      echo <<<HTML
         <link rel="canonical" href="https://z10.info" />
HTML;
   } elseif ($topic == "archiv" && !empty($_GET['y'])) {
      $y = intval($_GET['y']);
      echo <<<HTML
         <link rel="canonical" href="https://z10.info/archiv/{$y}" />
HTML;
   } elseif ($topic == "shouthistory" && !empty($_GET['off'])) {
      $o = intval($_GET['off']);
      echo <<<HTML
         <link rel="canonical" href="https://z10.info/shouthistory/{$o}" />
HTML;
   } else {
      echo <<<HTML
         <link rel="canonical" href="https://z10.info/$topic" />
HTML;
   } ?>
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta name="content-language" content="de">
   <meta name="language" content="de">
   <meta property="og:image" content="https://z10.info/imgs/Z10-Logo_low_square.png">
   <meta name="description" content="<?= in_array($topic, $loadContent) ? substr(htmlspecialchars(strip_tags(getContent($mysqli, $topic))), 0, 200) :  'Kulturzentrum von Studenten für Studenten, um Kultur kostenlos anbieten zu können!' ?>">
   <link rel="icon" type="image/x-icon" href="/favicon.ico" />
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <script defer src="/scripts/basicLightbox.min.js"></script>

<body class="body body-<?= $topic ?> <?= !empty($_GET['theme']) ? "theme-" . urlencode(htmlspecialchars(strip_tags($_GET['theme']))) : "" ?>">

   <header class="maincontainer">

      <div class="header">
         <div class="logo"><a href="/"><img src="/imgs/Z10-Logo_low.png" alt="Z10 Logo" width="260" height="147"></a></div>
         <div class="headertitle">
            <h1>Studentenzentrum Zähringerstraße 10 e.V.</h1>
            <h2>von Studis, für Studis</h2>
         </div>
      </div>

      <nav class="headermenu">
         <?= getMenu() ?>
      </nav>

   </header>

   <?php if ($topic == "home" && !empty($_GET['theme']) && $_GET['theme'] == "ss23") : ?>
      <div class="cover-image">
         <picture class="background">
            <source srcset="/imgs/ss23/leaves_background_420.webp" media="(orientation: portrait) and (max-width: 420px)">
            <img src="/imgs/ss23/leaves_background.webp" role="presentation">
         </picture>
         <div class="snake-container">
            <picture class="snake">
               <img src="/imgs/ss23/snake_600.webp" alt="" height="970" width="627" role="presentation">
            </picture>
            <a href="/">
               <img src="/imgs/Z10-Logo_low.png" alt="Z10 Logo" width="260" height="147" class="z10-logo">
            </a>
            <span class="wood anniversary" onpointerenter="burstConfetti(event.clientX, event.clientY)" id="woodPlank">40 Jahre</span>
         </div>
         <div class="text">
            <h1 class="title">Willkommen!</h1>
            <article class="welcometext" id="welcometext">
               <?php
               $intro = getContent($mysqli, 'intro');
               $news  = getContent($mysqli, 'news');
               echo $intro ?>
            </article>
         </div>
         <a class="arrow-wrapper" href="#dates" title="zu den Veranstaltungen"><span class="arrow"></span></a>
         <canvas style="position: absolute; top:0; bottom: 0; width: 100%; height: 100%; pointer-events: none;" id="canvasConfetti"></canvas>
      </div>
      <div id="confetti"></div>
      <script src="scripts/confetti.browser.min.js" defer></script>
      <script src="scripts/burstConfetti.min.js" defer></script>
   <?php endif; ?>


   <div class="maincontainer2">

      <main class="centercontent">
         <?php if ($topic == "home" && empty($_GET['theme'])) : ?>
            <style>
            </style>
            <picture class="retro-logo">
               <img src="/imgs/z10_bitfehler.gif" class="glitch" alt="" style="max-width: 350px; height: auto;" height="322" width="570" role="presentation">
            </picture>
         <?php endif; ?>

         <?php if (isMobile()) : ?>
            <section class="info_left opening_hours_center" id="Öffnungszeiten">
               <button style="
                   background-color: transparent;
                   border: none;
                   width: 100%;
                   padding: 3px 0;
                   display: block;
                   font-size: 1rem;
                   position: relative;
                  " aria-expanded="false" onclick="this.parentElement.classList.toggle('opening_hours_center_open'); this.ariaExpanded = !(this.ariaExpanded ==='true')">
                  <h2 class="long-plank">Öffnungszeiten</h2>
               </button>
               <div class=" info_content" style="font-size: 1rem;">
                  <!-- Öffnungszeiten -->
                  <?php echo getOeffnung($semesterferien, $mysqli) ?>
               </div>
            </section>
         <?php endif; ?>

         <?php
         // Statischen Content laden (Admin->Texte)
         if (in_array($topic, $loadContent)) {
            echo '<h1 class="title">' . ucfirst($topic) . '</h1>';
            echo "<section class='contentbox' id='$topic'>";
            echo getContent($mysqli, $topic);
            echo "</section>";
         } else {
            // FIXME
            include("includes/$topic.inc.php");
         }
         ?>
      </main>

      <div class="infobox_left">
         <?php if (!isMobile()) : ?>
            <section class="info_left" id="times">
               <h3>Öffnungszeiten</h3>
               <div class="info_content">
                  <!-- Öffnungszeiten -->
                  <?php echo getOeffnung($semesterferien, $mysqli) ?>
               </div>
            </section>
         <?php endif; ?>
         <?php /*
         <aside class="info_left" id="onlineOffering">
            <h3>Zusätzliches Angebot</h3>
            <div class="info_content">
               <?php echo getContent($mysqli, 'onlineoffering') ?>
            </div>
         </aside>
         <!--
         <div class="info_left" id="facebook">
            <h3>Facebook</h3>
            <div class="info_content">
               <!-- Facebookquatsch 
               <?php // echo getFacebook(200, 275) 
               ?>
            </div>
         </div>-->
*/ ?>

         <div class="info_left" id="randompicture">
            <h3>Zufallsbild</h3>
            <div class="info_content">
               <!-- Zufallsbild -->
               <?php echo !isMobile() ? getRandomImage() : "" ?>
            </div>
         </div>

         <?php /*         <aside class="info_left" id="links">
            <h3>Links</h3>
            <div class="info_content">
               <!-- Links -->
               <?php echo getContent($mysqli, 'links') ?>
            </div>
         </aside> */
         ?>
      </div> <!-- END infobox_left -->


      <div class="infobox_right">
         <?php /*
            <aside class="info_right" id="shoutbox">
               <h3>Shoutbox</h3>
               <div class="info_content">
                  <!-- Shoutbox -->
                  <? echo getShoutbox($mysqli) ?>
               </div>
            </aside>
         */ ?>
      </div> <!-- END infobox_right -->
      <div class="bottomspacer"></div>
   </div> <!-- END centercontetn -->

   </div>

   <dif class="footer-wrapper">
      <footer class="footer">
         <div class="info_left">
            <h3>Links</h3>
            <div class="info_content" style="display: flex; flex-direction: column;">
               <a href='https://z10.info/impressum'>Impressum</a>
               <a href='https://z10.info/datenschutz'>Datenschutz</a>
               <a href='https://z10.info/karte'>Anfahrt</a>
               <a href='https://z10.info/spiele'>Spiele</a>
            </div>
         </div>
         <div class="info_left" id="onlineOffering">
            <h3>Social Media</h3>
            <div class="info_content">
               <?php echo getContent($mysqli, 'onlineoffering') ?>
            </div>
         </div>
         <div class="info_left" id="links">
            <h3>Freunde</h3>
            <div class="info_content" style="column-count: 2; gap: 2rem; min-width: 250px;">
               <!-- Links -->
               <?php echo getContent($mysqli, 'links') ?>
            </div>
         </div>
         <div class="info_left" id="didyouknow" style="max-width: 270px;">
            <h3>Did you know?</h3>
            <div class="info_content">
               <!-- Did you know? -->
               <?php echo getDYK($mysqli) ?>
            </div>
         </div>

      </footer>
      <div class="sponsor-wrapper">
         <a href="https://www.sw-ka.de/de/" class="sponsor">
            <img src="/imgs/sponsor/swka.svg" width="85" height="100" loading="lazy" decoding="async" alt="Studierendenwerk Karlsruhe">
         </a>
         <a href="https://www.studentisches-kulturzentrum-am-kit.de" class="sponsor">
            <img src="/imgs/sponsor/skuz.png" width="200" height="173" loading="lazy" decoding="async" alt="Studentisches Kulturzentrum am KIT (SKUZ)">
         </a>
         <a href="https://www.akk.org" class="sponsor">
            <img src="/imgs/sponsor/akk.png" width="100" height="40" loading="lazy" decoding="async" alt="AKK">
         </a>
         <a href="https://studierendenschaft.org/" class="sponsor">
            <img src="/imgs/sponsor/foerderverein_studierendenschaft.svg" width="100" height="92" loading="lazy" decoding="async" alt="Förderverein der Studierendenschaft des KIT">
         </a>
      </div>
      <div class="foot">
         Mit freundlicher Unterstüzung der <a href='http://www.netcup.de'>netcup GmbH </a>
      </div>
   </dif>
</body>

</html>

<?php

ob_end_flush();
exit();

?>