<?php

use Illuminate\Support\Facades\HTML;

$content = <<<HTML
<h1 class="title">Spiele</h1>
<div class='contentbox' id='spiele'>
HTML;
$content .= getContent($mysqli, 'spieleintro');
$content .= <<<HTML
<div class="table-wrapper">
<table border="0" class="sortable" cellspacing="0" cellpadding="1" id="gamesTable" style="padding-top: 55px;">
<thead>
<tr>
   <th aria-sort="ascending">Name</th>
   <th>Spieler</th>
   <th>Dauer</th>
   <th>Art</th>
   <th>Ort</th>
   <th>Kommentare</th>
</tr>
</thead>
<tbody>
HTML;
$stmt = $mysqli->prepare("SELECT name, spieler, dauer, art, ort, kommentare, link FROM z10_spiele ORDER BY name ASC");
$stmt->execute();
$stmt->bind_result($name, $spieler, $dauer, $art, $ort, $kommentare, $link);
$stmt->store_result();

while ($stmt->fetch()) {
   if (strlen($link) > 0) {
      $displayname = "<a href='$link' target='_blank'>$name</a>";
   } else {
      $displayname = $name;
   }
   $content .= <<<HTML
<tr>
   <td>$displayname</td>  
   <td>$spieler</td>  
   <td>$dauer</td>  
   <td>$art</td>  
   <td>$ort</td>  
   <td>$kommentare</td>  
</tr>
HTML;
}
$stmt->close();

$content .= <<<HTML
</tbody></table>
</div>
</div>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript" onload=""></script>
<script defer>
window.addEventListener('load', (e) => {
   table = new simpleDatatables.DataTable('#gamesTable', {
   searchable: true,
   perPage: 1000,
   perPageSelect: [1000],
   });
   document.getElementById('gamesTable').style.paddingTop = null;
   });</script>
<style>
   .datatable-dropdown {
      display: none;
   }
   .datatable-sorter::before {
      border-top: 4px solid #fff
   }
   .datatable-sorter::after {
      border-bottom: 4px solid #fff
   }
</style>
HTML;

echo $content;
