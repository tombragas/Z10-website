<?php

/* hier gibts $header, $picsstart, $picitem, $picsend und $footer */
require_once( 'headers.php' );

/* enthält $content['BAND'] mit Unterarrays 'text' und 'pics' */
require_once( 'content.php' );

function arrayKey( $key, $array ) {

   if ( array_key_exists( $key, $array ) and !empty( $array[$key] ) )
      return $array[$key];
   else
      return false;
}

$was = arrayKey( 'w', $_GET );

/* Wenn ?w=.. gesetzt ist und auch Conent dazu existiert, wird er angezeigt */
if( $was AND array_key_exists( $was, $content ) ) {

   $cont = $content[$was];

   echo str_replace( '__WAS__', $was, $header );

   /* Wenn es Bilder gibt, fügen wir sie ein */
   if( array_key_exists( 'pics', $cont ) ) {
      $first = true;
      echo $picsstart;
      foreach( $cont['pics'] as $pic ) {
         if( $first ) {
            echo str_replace( '__PICFILE__', $pic, $picitem );
            $first = false;
         }
         else {
            echo str_replace( '__PICFILE__', $pic, $picitemmore );
         }
      }

      echo $picsend;
   }

   echo $cont['text'];
   echo $footer;
}



?>
