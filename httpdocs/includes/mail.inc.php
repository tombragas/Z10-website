<?

if (array_key_exists('to', $_GET) and !empty($_GET['to']))
   $addr = $_GET['to'];
else
   exit;

$s = explode('@', pack('H*', $addr));
?>
<html>

<head>
   <title>email</title>
   <meta name="robots" content="noindex,disallow" />
</head>
<SCRIPT TYPE="text/javascript">
   goeEO = '@';
   fgeJS = 'mailto:' + '<? echo $s[0]; ?>' + goeEO + '<? echo $s[1]; ?>';
   //window.location.href = fgeJS;
   self.close();
</script>

<body><noscript>Requires Javascript</noscript>
   <a href="mailto:<?= $s[0]; ?>@<?= $s[1]; ?>">E-Mail an <?= $s[0]; ?>@<?= $s[1]; ?></a>
</body>

</html>