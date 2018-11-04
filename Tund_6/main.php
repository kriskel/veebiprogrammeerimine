<?php
require("../tund4/functions.php");

if(isset($_GET['logout'])) {
    $_SESSION = null;
    session_destroy();
}

if(!isset($_SESSION['id'])) {
    header("Location: index2.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Pealeht</title>
  </head>
  <body>
    <h1>Pealeht</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
        <li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
    </ul>

    <p>
        Olete sisselogitud, <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?>.
    </p>
    <a href="/logout.php">Logi välja eraldi php faili kaudu</a>

    <div>
        <p>Kõik teised kasutajad peale su enda:</p>
        <ul>
            <?php $users = getAllUsersWithoutEmail($_SESSION['email']); ?>
            <?php foreach($users as $user): ?>
                <li><?= $user['email'] ?> | <?= $user['created_at'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
  </body>
</html>
