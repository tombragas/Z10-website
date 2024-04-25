<?php

//
// Skript um eine ics Datei zu erzeugen
// AK, 11.09.2013
// SVB, 24.03.2015 - Da das mit unserem Outputbuffering so schlichtweg nicht funktioniert, hab ich es berichtigt und die ob_* Funktionen und das exit am Ende eingefügt
//                   Wenn wir nicht buffern wuerden, käme die halbe Seite beim Browser an, dann der neue Header in Zeile 18 und dann der Rest. Das wäre genauso ein 
//                   großer Fuckup, der User würde es aber nicht merken. Durch das Buffern wird halt der gesamte Content am Schluss erst gesendet und dann enthalten
//                   die .ics den gesamten Text der Homepage...
//
// mit Argument "event=nnn", wobei nnn die event id ist, wird eine
// ics Datei mit dem spezifizierten Event erzeugt
//

# erstmal den Buffer leeren und beenden
ob_end_clean();
# dann nen neuen Buffer anfangen
ob_start("ob_gzhandler");

header( "Content-type: text/calendar; charset=utf8" );

$event = $_GET['event'];

// eine Datei mit allen offenen Events
if( $event == '' ) {
    header( "Content-Disposition: attachment; filename=Z10events_" . date( 'Ymd' ) . ".ics" );
}

// VCALENDAR 2.0 Header
$output_begin = <<<EOO
BEGIN:VCALENDAR
VERSION:2.0
X-LOTUS-CHARSET:UTF-8
PRODID:https://www.z10.info
METHOD:PUBLISH
BEGIN:VTIMEZONE
TZID:Europe/Berlin
X-LIC-LOCATION:Europe/Berlin
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;BYDAY=-1SU;BYMONTH=3
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
TZOFFSETTO:+0100
TZNAME:CET
DTSTART:19701025T030000
RRULE:FREQ=YEARLY;BYDAY=-1SU;BYMONTH=10
END:STANDARD
END:VTIMEZONE
EOO;

// VCALENDAR 2.0 Footer
$output_end = <<<EOO
END:VCALENDAR
EOO;

// Alle offenen Termine
$termine = getTermine( $mysqli );

// VCALENDAR Header ausgeben
echo $output_begin."\n";

// jeden einzelnen Termin bearbeiten
foreach ($termine as $termin) {

    // Termin Daten lesen und verarbeiten (charset aus der DB nach UTF8)
    $id = $termin['id'];
    $name = $termin['name'];
    $zeit = date( 'Ymd', $termin['zeitpunkt'] ) . 'T' . date( 'His', $termin['zeitpunkt'] );
    $kat = $termin['kategorie'];
    $text = preg_replace('/\s(www\.)(\S+)/', '<a href="https://\\1\\2" target="_blank">\\1\\2</a>', $termin['text']);
    $text_out = strip_tags( $termin['text'] );

    // nur ein einzelnes Event, falls event-Parameter vorhanden
    if( $event != '' && $event != $id )	continue;

    // Datei mit einem einzelnen Event
    if( $event != '' ) {
	header( "Content-Disposition: attachment; filename=Z10event_${id}_${zeit}.ics" );
    }

    // VCALENDAR Event erstellen...
    $output_ics = <<<EOO
BEGIN:VEVENT
UID:event$id-$zeit@z10.info
CLASS:PUBLIC
SUMMARY:$name
DTSTART;TZID=Europe/Berlin:$zeit
DTEND;TZID=Europe/Berlin:$zeit
DTSTAMP:$zeit
DESCRIPTION:$text_out
LOCATION:Studentenzentrum Z10, Zähringerstr. 10, 76131 Karlsruhe
CATEGORIES:Z10,$kat
END:VEVENT
EOO;

    // ... und ausgeben
    echo $output_ics."\n";
}

// VCALENDAR Footer ausgeben
echo $output_end;

# Buffer ausgeben und durch exit() alles beenden (wir sind hier ja immernoch in nem include). Ist zwar egal, weil die Daten ja schon weg sind, aber ist sauberer
ob_end_flush();
exit();

?>
