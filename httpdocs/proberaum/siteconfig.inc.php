<?php
/*
 * 2017-08-31 GIR
 * Pruefe ob Proberaum- oder Klangraumverwaltung angezeigt werden soll,
 * basierend auf der REQUEST_URI. 
 * Definiert eine Tabelle $roomstrings mit Textfragmenten zur Anzeige auf div.
 * Unterseiten und einen numerischen selektor fuer den aktuellen Raum, $query_room
 * der in SQL anfragen verwendet wird.
 */
if(strpos($_SERVER["REQUEST_URI"], "/klangraum/") === 0) {
   $query_room = 1; // Klangraum
   $roomstrings = [
      "general:title" => "Klangraumbelegung",
      ];
   session_name("klangraumverwaltung");
   session_set_cookie_params(24*60*60*31, "/klangraum/", "z10.info");
} else if(strpos($_SERVER["REQUEST_URI"], "/proberaum/") === 0) {
   $query_room = 0; // Proberaum
   $roomstrings = [
   "general:title" => "Proberaumbelegung",
   ];
   session_name("proberaumverwaltung");
   session_set_cookie_params(24*60*60*31, "/proberaum/", "z10.info");
} else {
   exit();
}

?>
