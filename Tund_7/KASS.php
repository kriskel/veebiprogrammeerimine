<?php
//var_dump($_POST);
	//kutusme välja funtsioonide faili
	require("functions.php");
	
	$notice = null;
	
	if (isset($_POST['submitUserData']))
	{
		$nimi = clean_form($_POST['catname']);
		$v2rv = clean_form($_POST['catcolor']);
		$saba = clean_form($_POST['tale']);
		$sql = "INSERT IGNORE INTO KASS 
				(nimi, v2rv, saba)  
				VALUES 
				('$nimi','$v2rv',$saba)";
		sql_insert($sql);
	}
	
//	$sql = "SELECT * FROM KASS WHERE id_kiisu = 4"; 
//	list ($row, $rows) = sql_select($sql);
//	if ($rows) 
//	{
//		echo $row['nimi'];
//	} 
//	else
//	{
//		echo "Puudub";
//	}
	
	
	if (isset($_POST["submitMessage"]))
	{
		if ($_POST["message"] != "Siia sisesta oma sõnum..." and !empty($_POST["message"]))
		{
		  $message = test_input($_POST["message"]);
		  $notice = saveamsg($message);
		} 	
		else 
		{
		  $notice = "Palun kirjuta sõnum";
		}
	}
  ?>

<?php
	//kutusme välja funtsioonide faili

	
	$cat_id = "ID";
	$catname = "nimi";
	$catcolor = "värv";
	$tailLength = "Tundmatu";
	

  
  if (isset($_POST["cat_id"])) {
	  //$cat_id = $_POST["cat_id"];
	  $cat_id = test_input($_POST["cat_id"]);
  }
  if (isset($_POST["catcolor"])) {
	  $catcolor = test_input($_POST["catcolor"]);
  }
  

//täiesti mõtetu harjutamiseks mõeldud funktsioon

//function fullName() {
  //$GLOBALS["fullName"] = $GLOBALS["firstName"] ." " .$GLOBALS["lastName"];
//}

 //fullName();

  
  ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kassi andmebaasi andmete lisamine
    </title>
</head>
<body>
  <h1>
  Kassi andmebaasi andmete lisamine
  </h1>
  <p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a>õppetöö raames, ei puugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>

	<hr>
	
	<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<!--label>Kassi ID:</label-->
		<!--input type="text" name="cat_id" required-->
		<label>Kassi nimi:</label>
		<input type="text" name="catname" required>
		<label>Kassi värv:</label>
		<input type="text" name="catcolor" required>
		<label>Saba pikkus (cm):</label>
		<input name="tale" type="number" min="0" max="40" value="20">
	
	
	
		<br>
		<input type="submit" name="submitUserData" value="Saada andmed">
	</form>
	
	<hr>
	
</body>
</html>
