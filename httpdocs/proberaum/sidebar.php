<?php
include("siteconfig.inc.php");
session_start();
if( !isset( $_SESSION['bandid'] ) ) {
   header( 'Location: index.php' );
   exit();
}

include("../includes/config.inc.php");
?>
<html>
<head>
<title>Z10 <?php echo($roomstrings["general:title"]);?></title>
  <style type="text/css">
  <!--
  table, tr, td {
    border-collapse: collapse;
    padding: 0px;
  }

   .datecell {
      background-color:#5AA1DF;
   }

   .owncell {
      background-color:#2CDF5A;
   }

   .entrycell {
      background-color:#DFA35A;
   }
   .emptycell {
      background-color:#FFFFE0;
   }
   
   .caltable {
      text-align: center;
      border: 1px solid;
      width: 100%;
      background-color:#FFFFE0;
   }
   
   .caltd {
      font-size: 10px;
   }
  
  hr {
    margin:0px;
    padding:0px;
    border:solid #000000 1px;
    background-color:#aa0000;
    color:#aa0000;
    height:4px;
  }
  
  input, select, input:focus, select:focus {
    color: #000000; 
    margin: 1px;
    border: 1px solid #808080; 
    background-color: #EFEFEF; 
  }
    
  input:focus, select:focus  {
    background-color: #FFFFFF; 
  }
  
  input:hover, select:hover  {
    background-color: #E0E0FF; 
  }
  
  .section {
    font-weight:bold;
    font-variant: small-caps;
  }
  
  h1, h2, h3, h4 {
    font-family: frutiger, segoe, verdana, helvetica, arial, sans-serif;
  }

  h1 {
    font-size:16px;
  }

  h2 {
    font-size:15px;
  }

  h3 {
    font-size:14px;
  }

  h4 {
    font-size:13px;
  }

  body, div, a, p, form, input, td, table {
    font-size: 14px;
    font-family: frutiger, segoe, verdana, helvetica, arial, sans-serif;
  }


  -->
  </style>
  
</head>
<body style="font-family:Verdana; font-size:12px">

<div style="border:1px solid;background-color:#FFFFE0;">
<hr />
<span style="font-size:26px;font-weight:bold; padding:8px;width:100%;">
  <?php echo($roomstrings["general:title"]);?> - <b><?php print $_SESSION['bandname']; ?> </b>
</span>
<hr />
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td valign="top">
   <table border="0" style="background-color:#FFFFE0;" cellpadding="8" cellspacing="0">
    <tr height="100%">
     <td>
      <br>
      <span class="section">Hauptmen&uuml;</span><br>
      <a href="main.php">Kalender</a><br>
      <br>
      <span class="section">Account:</span><br>
      <a href="changepw.php">Passwort &aumlndern</a><br>
      <a href="logout.php">Ausloggen</a><br>
      <br>
      <span class="section">Belegungen:</span><br>
      <a href="eintragen.php">Neu eintragen</a><br>
      <a href="showbelegungen.php">Meine Belegungen</a><br>
      <br>
      <span class="section">Sonstiges:</span><br>
      <a href="faq.php">Fragen?</a><br>
     </td>
     <td>
       &nbsp;
       &nbsp;
     </td>
    </tr>
   </table>
  </td>
  <td valign="top" width="85%" style="background-color:#FFFFD0;">
   <table border="0"  width="100%" cellpadding="8" cellspacing="0">
    <tr>
     <td width="100%">
