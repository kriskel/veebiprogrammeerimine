<?php

    // ---------------------------------------------------------------------------------------------------------------- OPEN_CONN()
	function open_conn($database="", $user="", $password="")
	{
		$host = $GLOBALS["serverHost"];
		$database = $GLOBALS["database"];
        $user = $GLOBALS["serverUsername"]; 
        $password = $GLOBALS["serverPassword"]; 
        $link = mysqli_connect($host, $user, $password, $database); 
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        mysqli_set_charset($link,'UTF8');
        return $link;
	}
    // ---------------------------------------------------------------------------------------------------------------- CLOSE_CONN()
    function close_conn($connection) { mysqli_close($connection); }

    // ---------------------------------------------------------------------------------------------------------------- SQL INSERT
    function sql_insert($sql)
    {
        $connection = open_conn();
        $data       = mysqli_query($connection, $sql);
        $affected_rows = mysqli_affected_rows($connection); //echo "<br/>### = ".$affected_rows;
        if ($affected_rows < 1) 
        { 
            $message = "# " . mysqli_errno($connection) . "<br/>";
            $message.= mysqli_error($connection)."<br/>";
            $message.= $sql;
            echo $message;
            exit;    
        }
        close_conn($connection);
    }
	
    // ---------------------------------------------------------------------------------------------------------------- SQL SELECT
    function sql_select($sql, $database="", $user="", $password="")
    {
        echo "<span style='background:yellow;'>".$sql."</span></br></br>";
        $connection = open_conn($database, $user, $password);
        $data       = mysqli_query($connection, $sql);
        $rows       = mysqli_num_rows($data);  
        $row        = mysqli_fetch_assoc($data);
        close_conn($connection);

        return array ($row, $rows); 
    }	

    // ---------------------------------------------------------------------------------------------------------------- CLEAN FORM VALUES
    function clean_form($variable)
    {
        $variable = htmlspecialchars($variable);
        $link  = open_conn();
        return mysqli_real_escape_string($link, $variable);        
    }	
	
	//laen andmbaasi info
	
	require("../../../config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_kristjan_ke_1";
	
	//anonüümse sõnumi salvestamine
	function saveamsg($msg){
		$notice = "";
	//serveri ühendus (server, kasutaja, parool, andmebaas)	
		$mysqli  = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		//valmistan ette SQL käsu
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
		echo $mysqli ->error;
		//asendame SSQL käsus küsimärgi päris infoga (andmetüüp, andmed ise)
		//s-string; i- integer; d-decimal;
		$stmt->bind_param("s", $msg);
		if ($stmt->execute()){
			$notice = 'Sõnum: "' .$msg .'" on salvestatud.';
		}	else {
				$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
			}
		$stmt->close();
		$mysqli->close();
		return $notice;
		

		
	}
	
		function addACat($catname, $catcolor, $cattaillength){
		$notice = "";
	//serveri ühendus (server, kasutaja, parool, andmebaas)	
		$mysqli  = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		// SQL query
    $myQuery = $mysqli->prepare("INSERT INTO KASS (nimi, v2rvus, saba) VALUES ( '$catname', '$catcolor', $cattaillength)"); // insert 3 arg VALUES into TABLE KASS
    echo $mysqli->error;
    $myQuery->bind_param("issi", $cat_id, $catname, $catcolor, $cattaillength); // $cat_id = i(nteger) $catname, $catcolor = s(tring) & $cattaillength = i(nteger)
   
    if ($myQuery->execute()){
        $notice = 'Sisestatud: "' . $catname . '" "' . $catcolor . '" "' . $cattaillength . '" andmebaasi.';
    } else {
        $notice = "erur." . $myQuery->error;
    }
   
    $myQuery->close();
    $mysqli->close();
    return $notice;
		
		
		
	}
	
	function listallmessages(){
		$msgHTML = "";
		$mysqli  = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		$stmt->bind_result($msg);
		$stmt->execute();
		while($stmt->fetch()){
			$msgHTML .="<p>" .$msg ."</p> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $msgHTML;
	}
	
	//teks sisestuse kontroll
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
  }

?>