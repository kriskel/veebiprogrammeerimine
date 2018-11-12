<?php
	//$_SESSION["userId"] = 6;

	require_once("functions.php");
	//require_once("photoupload.php");
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	  header("Location: index_1.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index_1.php");
	exit();
  }
  
  $mydescription = "Pole tutvustust lisanud!";
  $mybgcolor = "#FFFFFF";
  $mytxtcolor = "#000000";
  
  if(isset($_POST["submitProfile"])){
	$notice = storeuserprofile($_POST["description"], $_POST["bg_color"], $_POST["txt_color"]);
	if(!empty($_POST["description"])){
	  $mydescription = $_POST["description"];
	}
	$mybgcolor = $_POST["bg_color"];
	$mytxtcolor = $_POST["txt_color"];
  } else {
	$myprofile = showmyprofile();
	if($myprofile->description != ""){
	  $mydescription = $myprofile->description;
    }
    if($myprofile->bg_color != ""){
	  $mybgcolor = $myprofile->bg_color;
    }
    if($myprofile->txt_color != ""){
	  $mytxtcolor = $myprofile->txt_color;
    }
  }
	$pageTitle = "Kasutaja profiil";
	require("header.php");

//piltide laadimise osa
$target_dir = "../vp_pic_uploads/vp_profile_pic/";
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submitImage"])) 
{
	if(!empty($_FILES["fileToUpload"]["name"]))
	{
		//var_dump($_FILES["fileToUpload"]["name"]);
			//echo $_FILES["fileToUpload"]["fileName"];
		
		$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
		
		//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$timeStamp = microtime(1) * 10000;
		
		$target_file_name = "pp_" .$timeStamp ."." .$imageFileType;
		$target_file = $target_dir .$target_file_name;
		
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "Fail on " . $check["mime"] . " pilt.";
			//$uploadOk = 1;
		} else {
			echo "Fail pole pilt!";
			$uploadOk = 0;
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Vabandage, selle nimega fail on juba olemas!";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 2500000) {
			echo "Vabandage, pilt on liiga suur!";
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Vabandage, ainult JPG, JPEG ja PNG failid on lubatud!";
			$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Vabandage, valitud faili ei saa üles laadida!";
		// if everything is ok, try to upload file
		} else {
			//sõltuvalt failitüübist loon sobiva pildiobjekti
			if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
			}
			if($imageFileType == "png"){
				$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
			}

			
			//pildi originaalsuurus
			$imageWidth = imagesx($myTempImage);
			$imageHeight = imagesy($myTempImage);
			//leian suuruse muutmise suhtarvu
			if($imageWidth > $imageHeight){
				$sizeRatio = $imageWidth / 300;
			} else {
				$sizeRatio = $imageHeight / 300;
			}
			
			$newWidth = round($imageWidth / $sizeRatio);
			$newHeight = round($imageHeight / $sizeRatio);
			
			$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
			

			
			
			//faili salvestamine, jälle sõltuvalt failitüübist
			if($imageFileType == "jpg" or $imageFileType == "jpeg")
			{
				if(imagejpeg($myImage, $target_file, 90)){
					echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles!";
					$pic_id = addPhotoData($target_file_name, $_POST["altText"]);
				} else {
					echo "Vabandame, faili üleslaadimisel tekkis tehniline viga!";
				}
			}
			else if($imageFileType == "png")
			{
				if(imagepng($myImage, $target_file, 6))
				{
					echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles!";
					$pid_id = addPhotoData($target_file_name, $_POST["altText"]);
				} 
				else 
				{
					echo "Vabandame, faili üleslaadimisel tekkis tehniline viga!";
				}
			} 
			else
			{ echo "Valitud failitüüp pole sobilik!"; }

			if ($pic_id > 0)
			{
				$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("UPDATE vpusers_profiles SET profile_pic_id = ? WHERE user_id = ?");
				$stmt->bind_param("ii", $pic_id, $_SESSION["userId"]);
				if($stmt->execute())
				{ echo "<br/>Profiili update õnnestus"; } 
				else 
				{ echo "<br/>Andmebaasiga läks nihu"; }
					$stmt->close();
					$mysqli->close();
			}

			}
			
			imagedestroy($myTempImage);
			imagedestroy($myImage);
			
			/* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles!";
			} else {
				echo "Vabandame, faili üleslaadimisel tekkis tehniline viga!";
			} */
	}
	//if !empty lõppeb
}//siin lõppeb nupuvajutuse kontroll

function resizeImage($image, $ow, $oh, $w, $h){
	$newImage = imagecreatetruecolor($w, $h);
	imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
	return $newImage;
}

?>



    <h1>
	  <?php
			echo $_SESSION["firstName"] ." " .$_SESSION["lastName"];
	  ?>
	
	profiil</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<ul>
	  <li><a href="?logout=1">Logi välja</a>!</li>
	  <li><a href="main.php">Tagasi pealehele</a></li>
	</ul>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bg_color" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txt_color" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil">
		<br />
		<br />
		<hr />
		<br />
		<label><b>Profiili pildi üles laadimine:</b></label><br>
    <label>Vali üleslaetav pildifail (soovitavalt mahuga kuni 2,5MB):</label><br>
		<input type="file" name="fileToUpload" accept=".jpg" id="fileToUpload"><br>
		<label>Alt tekst: </label>
		<input type="text" name="altText">
		<br>
    <input type="submit" value="Lae profiili pilt üles" name="submitImage">
	</form>
	
	
  </body>
</html>