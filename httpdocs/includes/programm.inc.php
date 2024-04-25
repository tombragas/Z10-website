<?php

use Illuminate\Support\Facades\HTML;

$filepath = $ROOTDIR . 'imgs/programme/';
$urlpath = $ROOTURL . 'imgs/programme/';

echo '<h1 class="title">Programmhefte</h1>';
echo '<p style="text-align: center;">Hier findest du aktuelle und frühere Programmhefte zum Download<br></p>';
echo '<div class="contentbox" id="programm" style="text-align:center">';

$stmt = $mysqli->prepare("SELECT jahr, semester, seite, width, height, color FROM z10_programme ORDER BY jahr DESC, semester DESC");
$stmt->execute();
$stmt->bind_result($jahr, $semester, $seite, $width, $height, $color);
$stmt->store_result();

$programme = array();
$first = True;
while ($stmt->fetch()) {
   $filename = 'programm_' . $semester . $jahr . '_seite' . $seite;
   $thumbname = "tb_$filename";
   $h = ($width != NULL && $height != NULL) ? "height=" . round($height / $width * 300) : "";
   $c = ($color != NULL) ? "background-color:" . $color . ";" : "";
   $lazy = $first ? "" : "loading='lazy'";
   $bigImg = $first ? "max-width: 600px; height: auto; width: 100%;" : "";
   if (file_exists($filepath . $thumbname . ".webp")) {
      $avif = file_exists($filepath . $thumbname . ".avif") ? "<source srcset='$urlpath$thumbname.avif 2x' type='image/avif' />" : "";
      $image = <<<HTML
      <a href='$urlpath$filename.png' target='_blank'>
         <picture>
            $avif
            <img border='0' width='300' $h $lazy src='$urlpath$thumbname.webp' alt='Programmheft aus dem $semester aus $jahr.' style='$c $bigImg'>
         </picture>
      </a>
HTML;
   } else if (file_exists($filepath . $filename . ".png")) {
      $image = "<a href='$urlpath$filename.png' target='_blank'><img border='0' width='300' $h $lazy src='$urlpath$thumbname.png' alt='Programmheft aus dem $semester aus $jahr.' style='$c'></a>";
   } else {
      $image = '(Datei fehlt: ' . $filepath . $filename . ')';
   }

   $programme[$semester . $jahr][$seite] = array(
      'text'  => strtoupper($semester) . "$jahr",
      'image' => $image,
   );
   $first = $first && $seite == 2;
}
$stmt->close();

$first = True;
foreach ($programme as $key => $pages) {
   $gridSpan = $first || $key == "ss2012" ? "grid-column: span 2; display: block" : "";
   if (count($pages) == 2) {
      echo <<<HTML
          <div class="programme2page" style="$gridSpan">
            <div class="programmp1">
               {$pages[1]['text']}
               <div class="programmimg">{$pages[1]['image']}</div>
            </div>
            <div class="programmp2">
               <div class="programmimg">{$pages[2]['image']}</div>
            </div>
         </div>
HTML;
   } else {
      echo <<<HTML
          <div class="programme1page" style="$gridSpan">
            <div class="programmsingle">
               {$pages[1]['text']}
               <div class="programmimg">{$pages[1]['image']}</div>
            </div>
         </div>
HTML;
   }
   $first = False;
}
echo '&nbsp;</div>';
