<?php
  require("functions.php");
  //kui pole sisselogitud, siis logimise lehele
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
 //piltide laadimine osa
	$target_dir = "../vp_pic_uploads/";
	$uploadOk = 1;
	// Check if image file is a actual image or fake image
	if(isset($_POST["submitImage"])) {
		if(!empty($_FILES["fileToUpload"]["name"])){
			//var_dump($_FILES["fileToUpload"]["name"]);
			
			
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			$timeStamp= microtime(1)*10000;
			$target_file = $target_dir ."vp_".$timeStamp ."." .$imageFileType;
			
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "Fail on " . $check["mime"] . "pilt.";
				//$uploadOk = 1;
			} else {
				echo "Fail ei ole pilt.";
				$uploadOk = 0;
			}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Vabandust, samanimeline fail on olemas.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 2500000) {
				echo "Fail on liiga suur.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Vabandust, ainult JPG, JPEG, PNG & GIF failid on lubvatud.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Vabandust, tekkis mingi viga, faili üleslaadimine ei õnnestunud.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
				} else {
					echo "Tekksi tehniline viga, faili ei laetud üles";
				}
			}
		}
 //lehepäise laadimine
 $pageTitle="Fotode üleslaadimine";
 require("header.php");
 
?>


	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>

	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]." ".$_SESSION["lastName"] ."."; ?> </p>
	<ul>
	<li>Koduleht</li>

	<li><a href="main.php">Tagasi pealehele</a></li>
	<li><a href="?logout=1">Väljalogimine</a></li>
	</ul>
	<hr>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    <label>Vali üleslaetav pildifail(soovitatavalt väiksem kui 2,5MB): </label><br> 
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
	
    <input type="submit" value="Lae pilt üles" name="submitImage">
</form>
	
  </body>
</html>