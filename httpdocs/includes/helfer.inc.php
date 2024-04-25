<h1 class="title stay-where-you-are">Helferfest<br><small style="font-size: 1.2rem;">Adressliste für Fassleertrinken</small></h1>
<div class="contentbox" id="programm" style="text-align:center">
   <?
   if ($_POST) {
      $names = false;

      for ($i = 1; $i <= 2; $i++) {
         $name = arrayKey("name$i", $_POST);
         $mail = arrayKey("email$i", $_POST);
         $zeit = date('Y-m-d H:i:s');

         if ((strlen($name) < 2) or (strlen($mail) < 8))
            continue;

         //keine email?
         if (strpos($mail, '@') === false) {
            $mail = preg_replace("/[^0-9]/i", null, $mail);
         }

         $stmt = $mysqli->prepare("INSERT INTO z10_helfer (created_at, name, email) VALUES (?, ?, ?)");
         $stmt->bind_param('sss', $zeit, $name, $mail);
         $stmt->execute();

         if ($stmt->affected_rows > 0)
            $names .= "$name ($mail)<br>";
      }

      if ($names) {
         echo "Eingetragen:<br>$names<hr><br>";
      } else {
         echo "Kein Eintrag vorgenommen. Um euch einladen zu k&ouml;nnen muss eine Email/Telefonnummer angegeben werden<br>";
      }
   } else {
   ?>
      Diese Liste benutzen wir um euch auf das Helferfest (Fassleertrinken) einzuladen.<br>
      Die Namen auf der Liste sind meist zu unleserlich um was damit anfangen zu können. ;)
      <br><br>
      <form action="?topic=helfer" method="post">
         <table border="0">
            <tr>
               <th>Name (oder zumindest Vorname oder Spitzname)&nbsp;&nbsp;&nbsp;</th>
               <th>eMail (oder falls keine vorhanden: Telefon)</th>
            </tr>
            <tr>
               <td><input class="textfield" type="text" name="name1" size="40" maxlength="120" placeholder="RJ"></td>
               <td><input class="textfield" type="text" name="email1" size="40" maxlength="250" placeholder="contact@example.com"></td>
            </tr>
            <tr>
               <td><input class="textfield" type="text" name="name2" size="40" maxlength="120" placeholder="INT"></td>
               <td><input class="textfield" type="text" name="email2" size="40" maxlength="250" placeholder="pfeffifee@z10.info"></td>
            </tr>
         </table>
         <br />
         <input class="textfield" type="submit" value="Abschicken">
      </form>
      </center>
   <? }

// Das Z10 braucht deine Hilfe!
// Damit wir zuverlässig geöffnet haben können, sind wir auf eure Hilfe angewiesen, denn jeder kann uns im Ausschank zur Seite stehen.

// Ihr wollt den Verein unterstützen? Ihr wollt einen Abend hinter der Bar verbringen? Dann tragt euch gerne beim nächsten Besuch in unsere Helferliste ein!



// Bleibt gesund, und bis zum nächsten Besuch

// Euer Z10 Team