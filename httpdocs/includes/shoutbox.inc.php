<?php
require_once("UrlLinker.inc.php");

function getShoutbox($mysqli)
{
   $antispam = rand(11111, 99999);
   $scrmbled = md5($antispam * 5);
   $return = <<<HTML
<style>
   .infobox_right {
      max-width: 250px;
   }

   .show-on-form-focus {
      overflow-y: hidden;
      max-height: 0;
      transition: max-height .2s ease-out;
      text-align: left;
      background-color: var(--background-color-dark-blue);
      margin-bottom: .5rem;
   }

   form:focus-within > .show-on-form-focus,
   .show-on-form-focus:hover {
      max-height: 400px;
   }
</style>
<form action="/shout?theme=ws22" method="post">
    <input type="hidden" name="antispam1" value="$antispam">
    <input type="hidden" name="antispam2" value="$scrmbled"><span>
    nick</span><input name="nick" type="text" class="textfield" maxlength="32" placeholder="Nickname"><br>
    <span>txt</span><textarea name="txt" type="text" class="textfield" rows=4 maxlength="512"></textarea><br>
    <span>pwd=$antispam &nbsp;(wiederholen)</span>
    <br><input name="pwd" type="text" class="textfield" maxlength="6"><br>
    <br>
<div class="show-on-form-focus">
   <p> <b>Disclaimer</b>: Kritik, Feedback, Fragen und Wünsche sind immer gern gesehen und erwünscht.
    Guidelines:</p>
    <ul>
      <li>kein Sexismus</li>
      <li>kein Rassismus</li>
      <li>keine Klarnamen oder Kürzel</li>
    </ul>
    <p>
    Bei Beschwerden, Anregungen, etc. schreibt eine Mail an: <a href="mailto:vorstand@z10.info">vorstand@</a>, <a href="mailto:gezi@z10.info">gezi@</a> oder <a href="mailto:z10@z10.info">z10@</a>.<br>
    Posts, die gegen diese Richt&shy;linien verstoßen, werden gelöscht.</p>
</div>
    <input type="submit" class="sendbutton" value="senden" id="shoutsend">
</form>
HTML;
   $theme = !empty($_GET['theme']) ? "?theme=" . urlencode(htmlspecialchars(strip_tags($_GET['theme']))) : "";
   $return .= getShouts($mysqli, 0);
   $return .= "<br><div style='text-align:center'><a href='/shouthistory{$theme}'>Chat-History</a></div>";

   return $return;
}

function sbformat($msg, $name, $ip, $time)
{

   if (ip2long($ip) === false)
      $ip = "\nunknown";
   else {
      $ipparts = explode('.', $ip);
      array_shift($ipparts);
      $ip = implode('.', $ipparts) . '.xxx';
   }
   // FIXME we only need this because "back in the days" tags were not stripped _before_ saving
   $msg = htmlEscapeAndLinkUrls(strip_tags($msg));
   $msg = "<b>$name</b>: $msg";

   $datetime = new DateTime($time);
   $date = $datetime->format('d.m.y H:i');
   switch ($date) {
      case '30.01.23 22:02':
      case '22.01.23 19:38':
      case '30.01.23 21:53':
         $class = "highlighted-box";
         break;
      default:
         $class = "";
         break;
   }


   return "<div class='shout $class'>$msg<br><small class='shout-ip'>$date IP: $ip</small></div>";
}

function getShouts($mysqli, $offset, $count = 13)
{

   $off = $offset;
   $till = $off + $count;
   $stmt = $mysqli->prepare("SELECT msg, name, ip, created_at FROM z10_shouts ORDER BY created_at DESC LIMIT ?, ?");
   $stmt->bind_param('ii', $off, $count);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($msg, $name, $ip, $time);
   $out = '';
   while ($stmt->fetch()) {
      $out .= sbformat($msg, $name, $ip, $time);
   }
   $stmt->close();

   return $out;
}

function shout($mysqli)
{
   $nick = strip_tags(arrayKey('nick', $_POST));
   $txt = trim(str_replace(array("\r", "\t", "\n"), ' ', strip_tags(arrayKey('txt', $_POST))));
   $ip   = $_SERVER['REMOTE_ADDR'];
   $date = new DateTime();
   $date->setTimestamp(time());
   $time = $date->format('Y-m-d H:i:s');

   $okay = (md5($_POST['antispam1'] * 5) == $_POST['antispam2']) && ($_POST['pwd'] == $_POST['antispam1']);

   if ($nick && $txt && $okay) {
      $stmt = $mysqli->prepare("INSERT INTO z10_shouts (name, msg, ip, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param('sssss', $nick, $txt, $ip, $time, $time);
      $stmt->execute();
      if ($stmt->affected_rows == 0) {
         error_log("Konnte Shout nicht übernehmen: " . $mysqli->error);
      }
   }
   $theme = !empty($_GET['theme']) ? "?theme=" . urlencode(htmlspecialchars(strip_tags($_GET['theme']))) : "";

   header("Location: /$theme");
}
