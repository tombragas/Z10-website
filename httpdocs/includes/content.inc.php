<?php
$__isMobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $_SERVER['HTTP_USER_AGENT']) || preg_match(
   '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
   substr($_SERVER['HTTP_USER_AGENT'], 0, 4)
);
function isMobile(): bool
{
   global $__isMobile;
   return $__isMobile == True;
}

function getMenu()
{
   $curYear = date('Y');
   $items = array(
      "/#dates"                   => ['name' => "Termine", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14.5 18q-1.05 0-1.775-.725T12 15.5q0-1.05.725-1.775T14.5 13q1.05 0 1.775.725T17 15.5q0 1.05-.725 1.775T14.5 18ZM5 22q-.825 0-1.413-.588T3 20V6q0-.825.588-1.413T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.588 1.413T19 22H5Zm0-2h14V10H5v10Z"/></svg>'],
      "/kurs"               => ['name' => "Kurse", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.5 12a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 17.5 9a1.5 1.5 0 0 1 1.5 1.5a1.5 1.5 0 0 1-1.5 1.5m-3-4A1.5 1.5 0 0 1 13 6.5A1.5 1.5 0 0 1 14.5 5A1.5 1.5 0 0 1 16 6.5A1.5 1.5 0 0 1 14.5 8m-5 0A1.5 1.5 0 0 1 8 6.5A1.5 1.5 0 0 1 9.5 5A1.5 1.5 0 0 1 11 6.5A1.5 1.5 0 0 1 9.5 8m-3 4A1.5 1.5 0 0 1 5 10.5A1.5 1.5 0 0 1 6.5 9A1.5 1.5 0 0 1 8 10.5A1.5 1.5 0 0 1 6.5 12M12 3a9 9 0 0 0-9 9a9 9 0 0 0 9 9a1.5 1.5 0 0 0 1.5-1.5c0-.39-.15-.74-.39-1c-.23-.27-.38-.62-.38-1a1.5 1.5 0 0 1 1.5-1.5H16a5 5 0 0 0 5-5c0-4.42-4.03-8-9-8Z"/></svg>'],
      "/programm"           => ['name' => "Flyer", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M8.11 19.45a6.948 6.948 0 0 1-4.4-5.1L2.05 6.54c-.24-1.08.45-2.14 1.53-2.37l9.77-2.07l.03-.01c1.07-.21 2.12.48 2.34 1.54l.35 1.67l4.35.93h.03c1.05.24 1.73 1.3 1.51 2.36l-1.66 7.82a6.993 6.993 0 0 1-8.3 5.38a6.888 6.888 0 0 1-3.89-2.34M20 8.18L10.23 6.1l-1.66 7.82v.03c-.57 2.68 1.16 5.32 3.85 5.89c2.69.57 5.35-1.15 5.92-3.84L20 8.18m-4 8.32a2.962 2.962 0 0 1-3.17 1.39a2.974 2.974 0 0 1-2.33-2.55L16 16.5M8.47 5.17L4 6.13l1.66 7.81l.01.03c.15.71.45 1.35.86 1.9c-.1-.77-.08-1.57.09-2.37l.43-2c-.45-.08-.84-.33-1.05-.69c.06-.61.56-1.15 1.25-1.31h.25l.78-3.81c.04-.19.1-.36.19-.52m6.56 7.06c.32-.53 1-.81 1.69-.66c.69.14 1.19.67 1.28 1.29c-.33.52-1 .8-1.7.64c-.69-.13-1.19-.66-1.27-1.27m-4.88-1.04c.32-.53.99-.81 1.68-.66c.67.14 1.2.68 1.28 1.29c-.33.52-1 .81-1.69.68c-.69-.17-1.19-.7-1.27-1.31m1.82-6.76l1.96.42l-.16-.8l-1.8.38Z"/></svg>'],
      "/cafe"               => ['name' => "Caf&eacute;&nbsp;&amp;&nbsp;Bar", 'icon' => '<svg class="icon icon-caffee" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 32 32"><path class="icon-caffee" fill="currentColor" d="M2 28h28v2H2zm22.5-17H8a2.002 2.002 0 0 0-2 2v8a5.006 5.006 0 0 0 5 5h8a5.006 5.006 0 0 0 5-5v-1h.5a4.5 4.5 0 0 0 0-9zM22 21a3.003 3.003 0 0 1-3 3h-8a3.003 3.003 0 0 1-3-3v-8h14zm2.5-3H24v-5h.5a2.5 2.5 0 0 1 0 5zM19 9h-2v-.146a1.988 1.988 0 0 0-1.105-1.789L13.21 5.724A3.979 3.979 0 0 1 11 2.146V1h2v1.146a1.99 1.99 0 0 0 1.105 1.789l2.684 1.341A3.98 3.98 0 0 1 19 8.854z"></path></svg>'],
      "/rauminfo"           => ['name' => "Räume", 'icon' => '<svg class="icon icon-rooms" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 32 32"><path class="icon-rooms" fill="currentColor" d="M16.612 2.214a1.01 1.01 0 0 0-1.242 0L1 13.419l1.243 1.572L4 13.621V26a2.004 2.004 0 0 0 2 2h20a2.004 2.004 0 0 0 2-2V13.63L29.757 15L31 13.428ZM18 26h-4v-8h4Zm2 0v-8a2.002 2.002 0 0 0-2-2h-4a2.002 2.002 0 0 0-2 2v8H6V12.062l10-7.79l10 7.8V26Z"></path></svg>'],
      "/wer"                => ['name' => "Wer?", 'icon' => '<svg class="icon icon-verein" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 32 32"><path class="icon-verein" fill="currentColor" d="M26 14h-2v2h2a3.003 3.003 0 0 1 3 3v4h2v-4a5.006 5.006 0 0 0-5-5zM24 4a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0-2a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm-1 28h-2v-2a3.003 3.003 0 0 0-3-3h-4a3.003 3.003 0 0 0-3 3v2H9v-2a5.006 5.006 0 0 1 5-5h4a5.006 5.006 0 0 1 5 5zm-7-17a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0-2a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm-8 3H6a5.006 5.006 0 0 0-5 5v4h2v-4a3.003 3.003 0 0 1 3-3h2zM8 4a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0-2a5 5 0 1 0 5 5a5 5 0 0 0-5-5z"></path></svg>'],
      "/historie"           => ['name' => "Historie", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89l.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7s-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.25 2.52l.77-1.29l-3.52-2.09V8H12z"/></svg>'],
      // "/gallery/"           => ['name' => "Photogalerie", 'icon' => '<svg class="icon icon-photo" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 32 32"><path class="icon-photo" fill="currentColor" d="M4 22H2V4a2.002 2.002 0 0 1 2-2h18v2H4zm17-5a3 3 0 1 0-3-3a3.003 3.003 0 0 0 3 3zm0-4a1 1 0 1 1-1 1a1 1 0 0 1 1-1z"></path><path fill="currentColor" d="M28 7H9a2.002 2.002 0 0 0-2 2v19a2.002 2.002 0 0 0 2 2h19a2.002 2.002 0 0 0 2-2V9a2.002 2.002 0 0 0-2-2Zm0 21H9v-6l4-3.997l5.586 5.586a2 2 0 0 0 2.828 0L23 22.003L28 27Zm0-3.828l-3.586-3.586a2 2 0 0 0-2.828 0L20 22.172l-5.586-5.586a2 2 0 0 0-2.828 0L9 19.172V9h19Z"></path></svg>'],
      // "/archiv/$curYear"    => ['name' => "Terminarchiv", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M8 14q-.425 0-.713-.288T7 13q0-.425.288-.713T8 12q.425 0 .713.288T9 13q0 .425-.288.713T8 14Zm4 0q-.425 0-.713-.288T11 13q0-.425.288-.713T12 12q.425 0 .713.288T13 13q0 .425-.288.713T12 14Zm4 0q-.425 0-.713-.288T15 13q0-.425.288-.713T16 12q.425 0 .713.288T17 13q0 .425-.288.713T16 14ZM5 22q-.825 0-1.413-.588T3 20V6q0-.825.588-1.413T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.588 1.413T19 22H5Zm0-2h14V10H5v10ZM5 8h14V6H5v2Zm0 0V6v2Z"/></svg>'],
      // "/karte"              => ['name' => "Wo?", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9a2.5 2.5 0 0 1-2.5 2.5M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Z"/></svg>'],
      // "/spiele"             => ['name' => "Spiele", 'icon' => '<svg class="icon icon-games" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 32 32"><path class="icon-games" fill="currentColor" d="M23 23h-.132l.964-1.445A1 1 0 0 0 24 21v-9c0-9.885-7.92-10-8-10a1 1 0 0 0-1 1v2h-1a.996.996 0 0 0-.581.186l-7 5a1 1 0 0 0-.368 1.13l1 3a.998.998 0 0 0 1.09.674l4.87-.696l-3.86 6.176a1 1 0 0 0 .017 1.085L10.132 23H10a3.003 3.003 0 0 0-3 3v4h19v-4a3.003 3.003 0 0 0-3-3Zm-7.152-9.47a1 1 0 0 0-.99-1.52l-6.174.882l-.502-1.508L14.32 7h1.679a1 1 0 0 0 1-.999L17 4.129c1.501.335 4.217 1.541 4.86 5.871H19v2h3v2h-3v2h3v2h-3v2h3v.697L20.465 23h-7.93l-1.345-2.018ZM24 28H9v-2a1 1 0 0 1 1-1h13a1 1 0 0 1 1 1Z"></path></svg>'],
      "/spenden"            => ['name' => "Helfen", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16 2c-2.76 0-5 2.24-5 5s2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5m0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3m3 6h-2c0-1.2-.75-2.28-1.87-2.7L8.97 11H1v11h6v-1.44l7 1.94l8-2.5v-1c0-1.66-1.34-3-3-3M5 20H3v-7h2v7m8.97.41L7 18.5V13h1.61l5.82 2.17c.34.13.57.46.57.83c0 0-2-.05-2.3-.15l-2.38-.79l-.63 1.9l2.38.79c.51.17 1.04.25 1.58.25H19c.39 0 .74.24.9.57l-5.93 1.84Z"/></svg>'],
      "/kontakt"            => ['name' => "Kontakt", 'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 1536"><path fill="currentColor" d="M1024 1003q0 64-37 106.5t-91 42.5H384q-54 0-91-42.5T256 1003t9-117.5t29.5-103t60.5-78t97-28.5q6 4 30 18t37.5 21.5T555 733t43 14.5t42 4.5t42-4.5t43-14.5t35.5-17.5T798 694t30-18q57 0 97 28.5t60.5 78t29.5 103t9 117.5zM867 483q0 94-66.5 160.5T640 710t-160.5-66.5T413 483t66.5-160.5T640 256t160.5 66.5T867 483zm925 445v64q0 14-9 23t-23 9h-576q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h576q14 0 23 9t9 23zm0-252v56q0 15-10.5 25.5T1756 768h-568q-15 0-25.5-10.5T1152 732v-56q0-15 10.5-25.5T1188 640h568q15 0 25.5 10.5T1792 676zm0-260v64q0 14-9 23t-23 9h-576q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h576q14 0 23 9t9 23zm128 960V160q0-13-9.5-22.5T1888 128H160q-13 0-22.5 9.5T128 160v1216q0 13 9.5 22.5t22.5 9.5h352v-96q0-14 9-23t23-9h64q14 0 23 9t9 23v96h768v-96q0-14 9-23t23-9h64q14 0 23 9t9 23v96h352q13 0 22.5-9.5t9.5-22.5zm128-1216v1216q0 66-47 113t-113 47H160q-66 0-113-47T0 1376V160Q0 94 47 47T160 0h1728q66 0 113 47t47 113z"/></svg>'],
      //      "?topic=chat"    => "Chat",
   );

   $result = array();
   $theme = !empty($_GET['theme']) ? "?theme=" . urlencode(htmlspecialchars(strip_tags($_GET['theme']))) : "";
   foreach ($items as $url => $prop) {
      $result[] = "<li><a href='$url$theme'>{$prop['icon']}{$prop['name']}</a></li>";
   }

   $mobile = <<<HTML
	<input type="checkbox" name="main-nav" id="main-nav" class="burger-check">
	<label for="main-nav" class="burger menu"><span></span></label>
HTML;
   $themeButton = !!empty($_GET['theme']) ? "<li class='theme-header-link'><a href='?theme=ws22'>WS22 Design</a></li>" : "";
   $boardGames = '<li class="theme-header-link"><a href="/spiele"><svg class="icon icon-games" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 32 32"><path class="icon-games" fill="currentColor" d="M23 23h-.132l.964-1.445A1 1 0 0 0 24 21v-9c0-9.885-7.92-10-8-10a1 1 0 0 0-1 1v2h-1a.996.996 0 0 0-.581.186l-7 5a1 1 0 0 0-.368 1.13l1 3a.998.998 0 0 0 1.09.674l4.87-.696l-3.86 6.176a1 1 0 0 0 .017 1.085L10.132 23H10a3.003 3.003 0 0 0-3 3v4h19v-4a3.003 3.003 0 0 0-3-3Zm-7.152-9.47a1 1 0 0 0-.99-1.52l-6.174.882l-.502-1.508L14.32 7h1.679a1 1 0 0 0 1-.999L17 4.129c1.501.335 4.217 1.541 4.86 5.871H19v2h3v2h-3v2h3v2h-3v2h3v.697L20.465 23h-7.93l-1.345-2.018ZM24 28H9v-2a1 1 0 0 1 1-1h13a1 1 0 0 1 1 1Z"></path></svg>Spiele</a></li>';
   return "<div class='a-header'>" . $mobile . "<ul>" . implode('', $result) . $boardGames . $themeButton . "</ul></div>";
}

function getOeffnung($semesterferien, $mysqli)
{

   if ($semesterferien) {
      $zeittext = 'zeitenferien';
   } else {
      $zeittext = 'zeitensemester';
   }

   $stmt = $mysqli->prepare("SELECT content FROM z10_texte WHERE name=?");
   $stmt->bind_param('s', $zeittext);
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($content);

   if ($stmt->fetch()) {
      $return = $content;
   } else {
      $return = '';
   }

   $stmt->close();
   return $return;
}

// 13/02/2018 AK - aktualisiert auf aktuelle API
function getFacebook($width = null, $height = null)
{

   $wtext = '';
   if ($width) {
      $wtext = " data-width='$width'";
   }
   $htext = '';
   if ($height) {
      $htext = " data-height='$height' ";
   }

   $return = <<<HTML
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.12';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-page" data-href="https://www.facebook.com/Z10eVKarlsruhe" data-tabs="timeline,events" $wtext $htext data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Z10eVKarlsruhe" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Z10eVKarlsruhe">Studentenzentrum Z10 e.V.</a></blockquote></div>
HTML;
   return $return;
}

// 13/02/2018 AK - alte API

function getFacebook_old($width = null, $height = null)
{

   $wtext = '';
   if ($width) {
      $wtext = " width='$width'";
   }
   $htext = '';
   if ($height) {
      $htext = " height='$height' ";
   }

   $return = <<<EOF
<div id="fb-root"></div>
<script src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<fb:like-box href="https://www.facebook.com/Z10eVKarlsruhe"$wtext$htext colorscheme="light" show_faces="true" stream="false" header="false"></fb:like-box>
EOF;

   return $return;
}

function getDYK($mysqli)
{

   $stmt = $mysqli->prepare("SELECT text FROM z10_dyk ORDER BY RAND() LIMIT 1");
   $stmt->execute();
   $stmt->store_result();
   $stmt->bind_result($text);

   if ($stmt->fetch()) {
      $return = $text;
   } else {
      $return = '';
   }

   $stmt->close();
   return $return;
}

function getRandomImage()
{
   $stream_opts = [
      "ssl" => [
         "verify_peer" => false,
         "verify_peer_name" => false,
      ]
   ];

   return file_get_contents(
      "https://z10.info/gallery/randimg?size=resize&width=202",
      false,
      stream_context_create($stream_opts)
   );
}
