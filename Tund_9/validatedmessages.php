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
  
  $messages = readallvalidatedmessagesbyuser();

  $pageTitle = "Valideeri sõnumeid";
  require("header.php");

?>

  <h1>Sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>

	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  <h2>Valideeritud sõnumid valideerijate kaupa</h2>
  <?php
    echo $messages;
  ?>
</body>
</html>







