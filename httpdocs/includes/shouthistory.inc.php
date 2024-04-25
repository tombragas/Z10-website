<?
require_once('shoutbox.inc.php');
?>

<h1 class="title">Shout-Archiv</h1>
<div class="contentbox" id="shouthistory" style="word-break: break-word;">

   <?
   $off = arrayKey('off', $_GET) * 1;
   $navi = '';
   $theme = !empty($_GET['theme']) ? "&theme=" . urlencode(htmlspecialchars(strip_tags($_GET['theme']))) : "";

   $shouts = getShouts($mysqli, ($off * 40), 40);

   if (empty($shouts)) {
      http_response_code(404);
      echo <<<HTML
         <div>
            <h2>404 - Nichts gefunden</h2>
            <p>Hier gibt es nichts zu sehen.</p>
         </div>
HTML;
   } else {
      if ($off > 0) {
         $navi .= '<a href="/shouthistory/' . ($off - 1) . $theme . '" id="shoutnavi">&lt;&lt;&lt; Neuer</a> | ';
      }
      $navi .= '<a href="/shouthistory/' . ($off + 1) . $theme . '" id="shoutnavi">&Auml;lter &gt;&gt;&gt;</a>';

      echo $navi;
      echo '<div class="shouthistory">' . $shouts . '</div>';
      echo $navi;
   }


   ?>
   &nbsp;</div>