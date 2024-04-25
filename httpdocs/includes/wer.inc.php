<h1 class="title">Wer?</h1>
<div class="contentbox" id="wer" style="text-align:center">
   <style>
      html,
      body {
         scroll-behavior: smooth;
      }

      .member-pictures {
         display: grid;
         grid-template-columns: 1fr 1fr;
         max-width: 100vw;
         gap: .5rem;
      }

      .member-pictures a {
         position: relative;
      }

      .member-name {
         position: absolute;
         bottom: 10px;
         left: 50%;
         color: white;
         transform: translateX(-50%);
         color: white;
      }

      .member-pictures a:hover .member-name {
         color: #166;
      }

      .member-pictures img {
         aspect-ratio: 3/4;
         max-width: 100%;
         height: fit-content;
         object-fit: cover;
         scroll-margin: 100px;
      }

      .member-pictures-links a {
         padding: .5rem;
         display: inline-block;
      }

      .member-pictures-links {
         padding-bottom: 10px;
      }
   </style>
   <?php
   $inmitgl = true;
   $content = '';
   $heading = '';

   $stmt = $mysqli->prepare("SELECT kuerzel, mitglied, RAND() AS random FROM z10_mitglieder ORDER BY mitglied DESC, random");
   $stmt->execute();
   $stmt->bind_result($nick, $mitglied, $random);
   $stmt->store_result();

   while ($stmt->fetch()) {
      if ($inmitgl and $mitglied == 0) {
         $inmitgl = false;
         $content .= '</div><p><br></p><hr><p>ehemalige Mitglieder (die ihr vielleicht auch hin und wieder hier antreffen werdet ;)</p><div class="member-pictures">';
         $heading .= '<div class="former-member-links" style="display: none;"><br>Ehemalige<br>';
      }

      $picid = strtolower($nick) . '.jpg';
      $picid_300 = strtolower($nick) . '_300.jpg';
      $picid_190 = strtolower($nick) . '_190.jpg';

      $lazy = $inmitgl ? "" : "loading=lazy";

      $content .= <<<HTML
   <a href="#$nick" onclick= 'const instance = basicLightbox.create(`<img src="${ROOTURL}imgs/mitglieder/$picid">`); instance.show()'>
   <picture>
      <source srcset="${ROOTURL}imgs/mitglieder/$picid_190 190w" media="(max-width: 450px)">
      <source srcset="${ROOTURL}imgs/mitglieder/$picid_300 300w">
      <img id='$nick' width='300' height="400" $lazy src='${ROOTURL}imgs/mitglieder/$picid' alt='$nick hat leider kein Bild hochgeladen'>
   </picture>
   <div class="member-name wood">$nick</div>
   </a>
HTML;
      $heading .= "<a href='#$nick'>$nick</a> ";
   }

   $stmt->close();
   $heading .= "</div>";

   echo <<<HTML
<div>Aktive Mitglieder in zufälliger Reihenfolge</div>
<div class="member-pictures-links">$heading</div>
<div class="member-pictures active-member-pictures">
$content 
</div>
</div>
HTML;
