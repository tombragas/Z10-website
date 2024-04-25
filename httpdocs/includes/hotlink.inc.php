<?php

/*
 * SVB 13.2011
 * Siehe auch .htaccess:
 * ----------------------
 * RewriteEngine on
 * RewriteCond %{REQUEST_FILENAME} .*jpg$|.*gif$|.*png$ [NC]
 * RewriteCond %{HTTP_REFERER} !^$ 
 * RewriteCond %{HTTP_REFERER} !z10\.info [NC]
 * RewriteCond %{HTTP_REFERER} !google\. [NC] 
 * RewriteCond %{HTTP_REFERER} !search\?q=cache [NC]
 * RewriteRule (.*) /?topic=hotlink&img=$1 [NC]
 * ----------------------
 * Hotlinked Images werden auf den Kopf gestellt und 
 * mit einem Tag versehen, dass sie von uns kommen.
 */

$iname = trim( $_GET['img'], '/' );
if (!file_exists( $iname ) ) {
   exit();
}

// Wir stellen das Bild auf den Kopf und blenden nen Text ein
$img = new Imagick( $iname );
$img->rotateImage(new ImagickPixel('none'), 180 );

// Draw-Objekt
$draw = new ImagickDraw();
$draw->setFillColor( 'white' );
$draw->setFont( '/home/z10/z10.info/admin/verdanai.ttf' );
$draw->setFontSize( 50 );
$text = "Image from https://www.z10.info";

$img->annotateImage( $draw, 50, 50, 0, $text );
$img->drawImage( $draw );

header('Content-Type: image/' . $img->getImageFormat()  );
echo $img;
