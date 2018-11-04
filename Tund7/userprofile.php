<?php
  require("functions.php");
  if(!isset($_SESSION["userId"])){
	 header("Location: index_1.php");
	 exit();
  }
	$notice = null;
	if (isset($_POST["submitMessage"])){
		if($_POST["description"]!="Kirjuta siia midagi enda kohta" and !empty($_POST["description"])){ // !-ei tohi olla empty
			$message = test_input($_POST["description"]);
			$bgcolor = test_input($_POST["bgcolor"]);
			$textcolor = test_input($_POST["textcolor"]);
			$notice = description($message, $bgcolor,$textcolor);
			
		}else{
			$notice = "Kirjuta ka midagi";
			}
		
	}
	$message = "";
	$bgcolor="#FFFFFF";
	$textcolor="#000000";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Tutvustus</title>
  </head>
  <body>
    <h1>Kasutajaprofiili tutvustus</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma väärtuslikku sisu.</p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<textarea rows="10" cols="80" name="description">Kirjuta siia midagi enda kohta <?php echo $message; ?> </textarea><br>
	<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $bgcolor; ?>"><br>
	<label>Minu valitud tekstivärv: </label><input name="textcolor" type="color" value="<?php echo $textcolor; ?>"><br>
	<input type="submit" name="submitMessage" value="Salvesta Kirjeldus">
	</form>
	<hr>
	<p><a href="index_1.php">Tagasi</a> avalehele!</p>
	
  </body>
</html>