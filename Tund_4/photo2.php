<?php

  $firstName = "Kristjan";
  $lastName = "Kelk";
  //loeme piltide kataloogi sisu
  $dirToRead = "../../pics/";
  $allFiles = scandir($dirToRead);
  $picFiles = array_slice($allFiles, 2);
  //var_dump($picFiles);
  $RandomPic = mt_rand(2,6);
  
 
  
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
  
    //<img src="" alt="pilt">
	for ($i = 0; $i < count($picFiles); $i ++){
		echo '<img src="' .$dirToRead .$picFiles[$i] .'" alt="pilt"><br>' ."\n";
		}
  ?>
</body>
</html>
