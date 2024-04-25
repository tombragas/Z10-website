<?php
exit;
$url = "https://test.z10.whka.de/send_mail.php";


$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

error_reporting(E_NOTICE);

$headers = array(
  "Content-Type: application/x-www-form-urlencoded",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "secret=^ebXF3i@t4g3j8wVPD^#c24ZnQFi4hLZyrjpejzN9p1PGv^hvYNb9VZArWt#h@1^&email=admin@z10.info&course_name=test&first_name=JJ&urltan=123456789";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
echo "<pre>";
var_dump($resp);


// Html body
/*
$message = <<<HTML 
<html>

  <head>
    <meta http-equiv="content-type" content="text/html; charset=">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <title>Kursanmeldung: $kursname</title>
    <!--[if mso]>
	<style type="text/css">
    table {border-collapse:collapse;border:0;border-spacing:0;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
	</style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
    <style type="text/css">
    </style>
  </head>

  <body style="margin: 0px; padding: 0px 0px 1px; word-spacing: normal; background-color: rgb(255, 255, 255); color: black; font-family: Arial, sans-serif;">
    <div role="article" aria-roledescription="email" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ffffff; color: black;" lang="de">
      <table role="presentation" style="width:100%;border:0;border-spacing:0;">
        <!-- header nav-->
        <tbody>
          <tr style="background-color: #222; padding: 5px; width: 100%">
            <td style="background-color: #222; padding: 10px; width: 100%; color: white;" align="center">
              <!--[if mso]>
          <table role="presentation" align="center" style="width:660px;">
          <tr>
          <td style="padding:20px 0;">
          <![endif]-->
              <div style="max-width: 660px; width: 100%; margin: auto">
                <table style="width: 100%">
                  <tbody>
                    <tr>
                      <td style="width: 10%; max-width: fit-content;"> <a href="https://z10.info"> <img src="https://z10.info/imgs/mail/Z10-Logo_mail.gif" height="40">
                        </a> </td>
                      <td style="text-align: right;">
                        <p style="margin: 0; line-height: 38px;"> <a class="hover" style="display: inline-block; color: white; text-decoration: none; font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-transform: uppercase; font-weight: 400; letter-spacing: 1px;" href="https://z10.info">WEBSITE  
                          </a> <a class="hover" style="display: inline-block; color: white; text-decoration: none; font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-transform: uppercase; font-weight: 400; letter-spacing: 1px;" href="https://wiki.z10.info">  WIKI  
                          </a> <a class="hover" style="display: inline-block; color: white; text-decoration: none; font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-transform: uppercase; font-weight: 400; letter-spacing: 1px;" href="https://cloud.z10.info">  CLOUD</a>
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
            </td>
          </tr>
          <!-- end header nav-->
          <tr>
            <td align="center">
              <!--[if mso]>
          <table role="presentation" align="center" style="width:660px;">
          <tr>
          <td style="padding:20px 0;">
          <![endif]-->
              <div class="outer" style="width:96%;max-width:660px;margin:20px auto;">
                <table role="presentation" style="width:100%;border:0;border-spacing:0;">
                  <tbody>
                    <tr>
                      <td style="padding:10px;text-align:left;">
                        <h1 style="margin-top:0;margin-bottom:16px;font-family:Arial,sans-serif;font-size:26px;line-height:32px;font-weight:bold;">Bestätigen
                          der Kursanmeldung $kursname<br>
                        </h1>
                        <p style="margin:0; margin-bottom: 14px;font-family:Roboto,Arial,sans-serif;font-size:16px;line-height: 1.5">
                          Hallo $vorname,<br>
                          <br>
                          Du hast Dich auf der Z10 Homepage (https://www.z10.info) für den Kurs $kursname angemeldet.
                          Bitte bestästige Deine Anmeldung innerhalb von 24 Stunden mit dem Klick auf diesen Link:
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:10px;text-align:left;">
                        <p style="margin:16px 0;font-family:Arial,sans-serif;text-align: center"> <a href="https://www.z10.info/?topic=kurs_verify&amp;mid=$email&amp;tan=$urltan" style="background: #fed136; border: 2px solid #fed135; text-decoration: none; padding: 10px 25px; color: #fff; border-radius: 4px; display:inline-block; mso-padding-alt:0;text-underline-color:#fed136">
                            <!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%;mso-text-raise:20pt">&nbsp;</i><![endif]-->
                            <span style="mso-text-raise:10pt;font-weight:bold;">Anmeldung bestätigen</span>
                            <!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%">&nbsp;</i><![endif]-->
                          </a>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:10px;text-align:left;">
                        <p style="margin:0; margin-bottom: 14px;font-family:Roboto,Arial,sans-serif;font-size:16px; line-height: 1.5">
                          Solltest du Dich wider erwarten doch nicht für den Kurs angemeldet haben dann ignoriere diese
                          Mail einfach.<br>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:10px;text-align:left;">
                        <p style="margin:0; margin-bottom: 14px;font-family:Roboto,Arial,sans-serif;font-size:16px;line-height: 1.5">
                          Solltest Du später merken das du doch nicht am Kurs teilnehmen willst kannst Du deine
                          Anmeldung jederzeit durch Klick auf diesen Link zurücknehmen:<br>
                          <a href="https://www.z10.info/?topic=kurs_delete&amp;mid=$email&amp;tan=$urltan" style="text-decoration: underline; color: rgb(254, 209, 54);">https://www.z10.info/?topic=kurs_delete&amp;mid=$email&amp;tan=$urltan</a>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:10px;text-align:left;">
                        <p style="margin-top:0;margin-bottom:14px;font-family:Arial,sans-serif;">Liebe Grüße<br>
                          Dein Z10-Team</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="spacer" style="line-height:40px;height:40px;mso-line-height-rule:exactly;">  </div>
                <div class="spacer" style="line-height:40px;height:40px;mso-line-height-rule:exactly;">  </div>
              </div>
              <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
            </td>
          </tr>
          <tr style="background-color: #222; padding: 5px; width: 100%">
            <td style="background-color: #222; padding: 40px 20px 50px 20px; width: 100%; color: white;" align="center">
              <!--[if mso]>
          <table role="presentation" align="center" style="width:660px;">
          <tr>
          <td style="padding:20px 0;">
          <![endif]-->
              <div style="max-width: 660px; width: 100%; margin: auto">
                <table style="width: 100%">
                  <tbody>
                    <tr>
                      <td style="width: 50%;" align="center">
                        <p style="margin: 0 auto 20px auto; display: inline-block; text-align: left; font-family: Roboto,Arial,sans-serif;font-size:14px;line-height:22px;">
                          <span style="color: #ffffff;"> Studentenzentrum Zähringerstraße 10 e.V.<br>
                            Zähringerstraße 10<br>
                            76131 Karlsruhe<br>
                            <a href="tel:0721375447" rel="noopener" style="text-decoration: none; color: white;" target="_blank" title="tel:015751172087" class="hover">tel:
                              0721/375447</a> </span>
                        </p>
                      </td>
                      <td style="width: 50%; vertical-align: top" align="center">
                        <p style="margin: 0; display: inline-block; font-family: Roboto,Arial,sans-serif;font-size:14px;line-height:22px; text-align: left">
                          <a href="https://z10.info/?topic=impressum" rel="noopener" style="text-decoration: none; color: white;" target="_blank" class="hover">Impressum</a>
                          <br>
                          <a href="https://z10.info/?topic=datenschutz" rel="noopener" style="text-decoration: none; color: white;" target="_blank" class="hover">Datenschutz</a>
                          <br>
                          <a href="https://z10.info/" rel="noopener" style="text-decoration: none; color: white;" target="_blank" class="hover">Z10.info</a>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <p style="margin:0; margin-top: 10px; color: grey; font-family: Roboto,Arial,sans-serif;font-size:14px;line-height:22px; text-align: center">
                          Diese E-Mail wurde automatisch gesendet und es kann nicht geantwortet werden.<br>
                          Solltest Du eine solche Mail mehrmals erhalten ohne Dich bei einem Kurs eingetragen zu haben,
                          kannst Du dies an <a href="mailto:admin@z10.info" rel="noopener" style="text-decoration: none; color: grey;" target="_blank" class="moz-txt-link-freetext">admin@z10.info</a>
                          melden</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
            <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
          </tr>
        </tbody>
      </table>
    </div>
  </body>

  </html>
HTML;
*/