<?php
$year = arrayKey('y', $_GET);
if (!($year  >= 2003)) {
   $year = date('Y');
}
$top = <<<EOD
<h1 class="title stay-where-you-are">Vergangene Termine</h1>
<div class="contentbox" style="text-align:center">
EOD;

$theme = !empty($_GET['theme']) ? "?theme=" . urlencode(htmlspecialchars(strip_tags($_GET['theme']))) : "";
for ($i = 2003; $i <= date('Y'); $i++) {
   $active = ($i == $year) ? 'active-link' : '';
   $top .= " <a href='/archiv/$i$theme' class='event-archive-year-link $active'><b>$i</b></a>";
}

echo $top . '</div>
<div id="terminarchiv">';

require_once __DIR__ . "/Components/Event.php";

$termine = getTermine($mysqli, false, $year);
$first = True;
foreach ($termine as $termin) {
   echo (new Event(...array_values($termin)))->render(!$first);
   $first = false;
}
echo '</div>';
