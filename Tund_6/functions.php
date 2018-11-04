<?php

	function signup($firstName, $lastName, $birthDate, $gender, $email, $password)
	{
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//valmistame parooli ette salvestamiseks - krüpteerime, teeme räsi (hash)
		$options = [
			"cost" => 12,
			"salt" => substr(sha1(rand()), 0, 22),];
		$pwdhash = password_hash($password, PASSWORD_DEFAULT, $options);
		$stmt->bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $password);
			if($stmt->execute()){
				$notice = "Uue kasutaja lisamine õnnestus";
			} else {
				$notice = "Kasutaja lisamisel tekkis viga:" .$stmt->error;
			}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
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

require("../../../config.php");
session_start();

function escapePostData($index) {
    $str = '';
    if(isset($_POST[$index])) {
        $str = escapeStr($_POST[$index]);
    }
    return $str;
}

function escapeStr($str) {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
}

$connection = null;

function setDbConnection() {
    if(is_null($GLOBALS['connection']) or !isset($GLOBALS['connection'])) {
        $GLOBALS['connection'] = new mysqli($GLOBALS['db']['host'], $GLOBALS['db']['user'], $GLOBALS['db']['pass'], $GLOBALS['db']['database']);
    }
}

function getAllComments() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT comment FROM comment');
    $msg = "";
    $stmt->bind_result($msg);
    $stmt->execute();
    $comments = [];

    while($stmt->fetch()) {
        $comments[] = $msg;
    }
    $stmt->close();
    $connection->close();
    $connection = null;
    return $comments;
}

function getAllAnimals() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT * FROM animal ORDER BY id DESC');
    $id = "";
    $name = "";
    $color = "";
    $tail_length = "";
    $type = "";
    $stmt->bind_result($id, $name, $color, $tail_length, $type);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'name' => $name,
            'color' => $color,
            'tail_length' => $tail_length,
            'type' => $type,
        ];
    }
    $stmt->close();
    $connection->close();
    $connection = null;
    return $entities;
}

function getAllUnvalidatedComments() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT id, user_id, comment, created_at FROM comment WHERE accepted = 0 AND accepted_id = 0 ORDER BY id DESC');
    $id = "";
    $user_id = "";
    $comment = "";
    $created_at = "";
    $stmt->bind_result($id, $user_id, $comment, $created_at);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'user_id' => $user_id,
            'comment' => $comment,
            'created_at' => $created_at
        ];
    }
    $stmt->close();
    $connection->close();
    $connection = null;
    return $entities;
}

function getAllValidatedComments() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT id, user_id, comment, created_at FROM comment WHERE accepted = 1 AND accepted_id > 0 ORDER BY id DESC');
    $id = "";
    $user_id = "";
    $comment = "";
    $created_at = "";
    $stmt->bind_result($id, $user_id, $comment, $created_at);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'user_id' => $user_id,
            'comment' => $comment,
            'created_at' => $created_at
        ];
    }
    $stmt->close();
    $connection->close();
    $connection = null;
    return $entities;
}

function getAllUsersWithEmail($email) {
    setDbConnection();
    $email = escapeStr($email);

    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare("SELECT id, firstname, lastname, email, gender, birthdate, created_at FROM vpusers WHERE email = '{$email}'");
    $id = "";
    $firstname = "";
    $lastname = "";
    $email = "";
    $gender = "";
    $birthdate = "";
    $created_at = "";
    $stmt->bind_result($id, $firstname, $lastname, $email, $gender, $birthdate, $created_at);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'gender' => $gender,
            'birthdate' => $birthdate,
            'created_at' => $created_at,
        ];
    }

    return $entities;
}

function getAllUsersWithoutEmail($email) {
    setDbConnection();
    $email = escapeStr($email);

    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare("SELECT id, firstname, lastname, email, gender, birthdate, created_at FROM vpusers WHERE email NOT LIKE '{$email}'");
    $id = "";
    $firstname = "";
    $lastname = "";
    $email = "";
    $gender = "";
    $birthdate = "";
    $created_at = "";
    $stmt->bind_result($id, $firstname, $lastname, $email, $gender, $birthdate, $created_at);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'gender' => $gender,
            'birthdate' => $birthdate,
            'created_at' => $created_at,
        ];
    }

    return $entities;
}

/*
 * $table - table name in database
 * $value = [
 *      'field_name' => 'field_name',
 *      'value' => 'value'
 * ]
 * $condition = [
 *      'field_name' => 'field_name',
 *      'value' => 'value'
 * ]
 * */
function updateSet($table, $value, $condition) {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    //var_dump($connection);die;
    $fieldName = $value['field_name'];
    $condName = $condition['field_name'];
    $stmt = $connection->prepare("UPDATE {$table} SET {$fieldName} = ? WHERE {$condName} = ?");
    //var_dump($stmt);die;
    echo $connection->error;
    $stmt->bind_param("ss", $value['value'], $condition['value']);

    //$stmt->bindParam(':fieldVal', $value['value'], PDO::PARAM_STR);
    //$stmt->bindParam(':condVal', $condition['value'], PDO::PARAM_STR);

    $notice = "";

    if($stmt->execute()) {
        $notice = "Kasutajat ei leitud.";
    } else {
        $notice = "Päringu tegemisel viga.";
    }

    return $notice;
}

/*
 * $table - table name in database
 * $values = [
 *      'field_name1' => 'field_value1',
 *      'field_name2' => 'field_value2',
 *      'field_name3' => 'field_value3',
 *      ...
 * ]
 * */
function insertInto($table, $values) {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $sql = "INSERT INTO {$table} (";
    $lastPartOfSql = "";
    $valuesInStr = "";
    $_values = [];
    $paramTypes = "";

    if($table == 'vpusers' && isset($values['email'])) {
        $usersWithSameEmail = getAllUsersWithEmail($values['email']);
        if(count($usersWithSameEmail) > 0) {
            $connection->close();
            $connection = null;
            return "Sellise emailiga kasutaja on juba olemas.";
        }
    }

    foreach($values as $key => $value) {
        if(is_string($value)) $paramTypes .= "s";
        else if(is_integer($value)) $paramTypes .= "i";
        else if(is_float($value) || is_double($value)) $paramTypes .= "d";
    }
    $_values[] = & $paramTypes;
    foreach($values as $key => $value) {
        $sql .= $key.',';
        $lastPartOfSql .= '?,';
        $valuesInStr .= $value.',';
        $_values[] = & $values[$key];
    }
    $sql = rtrim($sql,",");
    $lastPartOfSql = rtrim($lastPartOfSql,",");
    $sql .= ") VALUES (";
    $sql .= $lastPartOfSql.')';

    $stmt = $connection->prepare($sql);
    echo $connection->error;
    call_user_func_array(array($stmt, 'bind_param'), $_values);

    if($stmt->execute()) {
        $notice = "Salvestati: {$valuesInStr}";
    } else {
        $notice = "Tekkis viga: {$stmt->error}";
    }

    $stmt->close();
    $connection->close();
    $connection = null;
    return $notice;
}

function GetFieldValue($index) {
    if(isset($GLOBALS['fields'][$index])) return $GLOBALS['fields'][$index];
    return '';
}

function ShowError($index) {
    if(isset($GLOBALS['errors'][$index])) return $GLOBALS['errors'][$index];
    return '';
}


function signIn($email, $password) {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare("SELECT id, firstname, lastname, password_hash FROM vpusers WHERE email = ? LIMIT 1");
    echo $connection->error;
    $stmt->bind_param("s", $email);
    $resultPassword = "";
    $id = "";
    $firstname = "";
    $lastname = "";
    $stmt->bind_result($id, $firstname, $lastname, $resultPassword);
    $notice = "";

    if($stmt->execute()) {
        if($stmt->fetch()) {
            if(password_verify($password, $resultPassword)) {
                $notice = "Sisselogimine õnnestus.";
                $stmt->close();
                $connection->close();
                $connection = null;
                $_SESSION['id'] = $id;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['email'] = $email;
                header("Location: main.php");
                exit();
            } else {
                $notice = "Parool ei klapi.";
            }
        } else {
            $notice = "Kasutajat ei leitud.";
        }
    } else {
        $notice = "Päringu tegemisel viga.";
    }

    $stmt->close();
    $connection->close();
    $connection = null;

    return $notice;
}
?>