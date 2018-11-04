<?php
  //echo "see on minu esimene php!";
  $firstName = "Kristjan";
  $lastName = "Kelk";
  $dateToday = date("d.m.Y");
  $hourNow = date ("G");
  $partOfDay = "";
  if ($hourNow < 8) {
	  $partOfDay = "varajane hommik";
  }
  if ($hourNow >= 8 and $hourNow < 16) {
	  $partOfDay = "koolipäev";
  }
  if ($hourNow >= 16 and $hourNow < 16) {
	  $partOfDay = "suht vaba";
  }
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
<?php
echo "<p>Tänen kuupäev on: " . $dateToday .".</p>" ;
echo "<p>lehe avamise hetkel oli kell " .date("H:i:s") .". Käes oli ". $partOfDay."</p> \n";


?>
 
 <!--<img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="TLÜ Terra Õppehoone">-->
 
 <img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="TLÜ Terra Õppehoone">
  
  <p> minu pinginaabri <a href="../../~randtal">veeb</a><p/>
</body>
</html>
