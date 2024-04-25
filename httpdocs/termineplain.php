<?php
// Für den Facebook-Stream
include("includes/config.inc.php");

echo '<link rel="stylesheet" type="text/css" href="fb.css">';
$tage = array( 'So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' );
$termine = getTermine( $mysqli );
foreach ($termine as $termin) {

   $text = preg_replace('/\s(www\.)(\S+)/', '<a href="https://\\1\\2" target="_blank">\\1\\2</a>', $termin['text']);
   $zeit = $tage[date( 'w', $termin['zeit'] )] . ', ' . date( 'j.m.Y - G:i', $termin['zeit'] );
   $bild = $termin['bild'];
   $thumb = dirname( $bild ) . '/thumb_' . basename( $bild );

   $output = <<<EOO
<div class="vevent"><br>
<table border="0" cellpadding="10" cellspacing="0" width="700" class="inhalt">
<tr>
  <th align="center" class="head1" width="200">
     <b><abbr title="$zeit" style="text-decoration:none;">$zeit</abbr></b>
  </th>
  <th width="650" class="head2" valine="middle">
      {$termin['name']}&nbsp;({$termin['kat']})
  </th>
</tr>
<tr>
  <td align="center" valign="top">
     <a href="{$termin['bild']}"><img src="../$thumb" alt="{$termin['name']}" align="left"
vspace="2" hspace="10" border="0"></a>
  </td>
  <td valign="top">
     <div align="justify" style="padding-right:8px;">$text</div>
     <span class="location" style="display:none">Z10, Zähringerstraße
10, 76131 Karlsruhe </span>
  </td>
</tr>
</table>
</div><br />
EOO;

   // Facebook stinkt. Die fahren offensichtlich noch auf ISO-8859-*.
   // Das hier sollte eigentlich asap wieder raus und pures utf8 ausgeliefert werden.
   // SVB 11.6.2014
   echo utf8_decode( $output );
}

?>
