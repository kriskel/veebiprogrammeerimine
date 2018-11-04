<?php
  require("functions.php");
  
  //kui pole sisseloginud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	header("Location: index_1.php");
	exit();  
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	session_destroy();
    header("Location: index_1.php");
	exit();
  }
  //piltide laadimise osa
	<?php
	$target_dir = "../vp_pic_uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submitImage"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File on - " . $check["mime"] . "pilt.";
			//$uploadOk = 1;
		} else {
			echo "File ei ole pilt, sorry.";
			$uploadOk = 0;
		}
			// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, selline file on juba olemas.";
			$uploadOk = 0;
		}
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 2500000) {
			echo "Sorry, su pilt on nati liiga suur, piirdume 2,5MB-ga.";
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, ainuly JPG, JPEG, PNG & GIF filid on lubatud.";
			$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, valitud file ei saa alla laadida.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "Teie file ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt ülesse.";
			} else {
				echo "Sorry, file üleslaadimisel oli mingi error.";
			}
		}
	?>
		
		
	}//siin lõppeb nupuvajutuse kontroll
	
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, selline file on juba olemas.";
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 2500000) {
		echo "Sorry, su pilt on nati liiga suur, piirdume 2,5MB-ga.";
		$uploadOk = 0;
	}
	
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, ainuly JPG, JPEG, PNG & GIF filid on lubatud.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, valitud file ei saa alla laadida.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "Teie file ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt ülesse.";
		} else {
			echo "Sorry, file üleslaadimisel oli mingi error.";
		}
	}
	?>

  
  
  
  // lehe päise laadimine
  $pageTitle = "Fotode ülesse laadimine";
  reguire("header.php");
  
?>


	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust,
	mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"] ."."; ?></p>
	<ul>
      <li><a href="?logout=1">Logi välja</a>!</li>
	  <li>Tagasi <a href="main.php">pealehele</a>.</li>
	</ul>
	<hr>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
	<label>Vali üleslaetava pildifile (soovitavalt mahuga 2,5MB):</label><br>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Lae pilt ülesse" name="submitImage">
	</form>

	
  </body>
</html>





