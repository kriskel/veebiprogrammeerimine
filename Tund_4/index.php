<?php
  //echo "see on minu esimene php!";
  $firstName = "Kristjan";
  $lastName = "Kelk";
  $dateToday = date("d.");
  $monthToday = date("m");
  $yearToday = date("Y");
  $weekdayNow = date("N");
  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  //echo $weekdayNamesET[1];
  //var_dump($weekdayNamesET);
  //echo $weekdayNow;
  $hourNow = date ("G");
  $partOfDay = "koolipäev";
	if ($hourNow < 8) {
	  $partOfDay = "varajane hommik";
  }
	if ($hourNow >= 8 and $hourNow < 16) {
	  $partOfDay = "koolipäev";
  }
	if ($hourNow >= 16 and $hourNow < 16) {
	  $partOfDay = "suht vaba"; 
  }
  
  $picNum = mt_rand(2, 3);
  //echo $picNum
  $picURL = "https://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
  $picEXT = ".jpg";
  $picFile = $picURL .$picNum .$picEXT;
  
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
		<p>Tundides tehtu: <a href="photo.php">photo.php</a></p>
		
<?php
//echo "<p>Täne kuupäev on: " . $dateToday .".</p>" ;
//echo "<p> Täna on " .$weekdayNow .",".$dateToday .". </p> \n";
echo "<p> Täna on " .$weekdayNamesET[$weekdayNow - 1] .", ".$dateToday ." ".$monthNamesET[$monthToday - 1] ." ".$yearToday .". </p> \n";

echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .". Käes oli ".$partOfDay ."</p> \n";


?>
 
 <!--<img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="TLÜ Terra Õppehoone">-->
 
 <!--img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="TLÜ Terra Õppehoone">-->
  <img src="<?php echo $picFile; ?>" alt="suva pildid">
  
  <p> Minu pinginaabri <a href="../../../~randtal">veebileht</a><p/>
</body>
</html>
