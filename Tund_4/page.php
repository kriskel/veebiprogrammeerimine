<?php
	//kutusme välja funtsioonide faili
	require("functions.php");
	
  $firstName = "Kodanik";
  $lastName = "Tundmatu";
  $fullName = "";

  
  //kontrollime kas kasutaja on midagi kijrutanud
  //var_dump($_POST);
  if (isset($_POST["firstName"])) {
	  //$firstName = $_POST["firstName"];
	  $firstName = test_input($_POST["firstName"]);
  }
  if (isset($_POST["lastName"])) {
	  //$lastName = $_POST["lastName"];
	  $lastName = test_input($_POST["lastName"]);
  }
  

//täiesti mõtetu harjutamiseks mõeldud funktsioon

function fullName() {
  $GLOBALS["fullName"] = $GLOBALS["firstName"] ." " .$GLOBALS["lastName"];
}

 fullName();

  
  ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>
    <?php
      echo $firstName;
      echo " ";
      echo $lastName;
    ?>
       , õppetöö</title>
</head>
<body>
  <h1><?php
	echo $firstName ." " .$lastName;
  ?></h1>
  <p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a>õppetöö raames, ei puugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>

	<hr>
	
	<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi:</label>
	<input type="text" name="firstName">
	<label>Perekonnanimi:</label>
	<input type="text" name="lastName">
	<label>Sünniaasta:</label>
	<input type="number" min="1914" max="2000" value="1999" name="birthYear">
	<label>Sünnikuu:</label>
	
	<select name="birthMonth"> <option value="9" selected>september</option>
		<option value="1">jaanuar</option>
		<option value="2">veebruar</option>
		<option value="3">märts</option>
		<option value="4">aprill</option>
		<option value="5">mai</option>
		<option value="6">juuni</option>
		<option value="7">juuli</option>
		<option value="8">august</option>
		<option value="9">september</option>
		<option value="10">oktoober</option>
		<option value="11">november</option>
		<option value="12">detsember</option>
</select>
	
	<br>
	<input type="submit" name="submitUserData" value="Saada andmed">
	</form>
	
	<hr>
	<?php
	  if (isset($_POST["firstName"])) {
	  echo "<p>" .$fullName .", olete elanud järgmistel aastatel: </p>\n";
	  echo "<ol> \n";
		for ($i = $_POST["birthYear"]; $i <=date("Y"); $i++){
		echo "<li>" .$i ."</li> \n";
		
		}
	  echo "</ol> \n";
	  }
	
	?>
</body>
</html>
