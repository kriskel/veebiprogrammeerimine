<?php
	//kutusme välja funtsioonide faili
	require("functions.php");
	
	$notice = listallmessages();
	
  ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsete sõnumite lisamine</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a>õppetöö raames, ei puugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>

	<hr>
	<?php
		echo $notice;
	
	?>
	
</body>
</html>
