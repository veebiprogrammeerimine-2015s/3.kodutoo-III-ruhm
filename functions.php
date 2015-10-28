<?php
  require_once("../config_global.php");
  $database = "if15_robing_3";
  session_start();

  //Kasutaja loomine
  function registerUser($email_reg, $password_reg, $nickname){
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO IRC (email, password, nickname) VALUES (?,?,?)");
    $stmt->bind_param("sss", $email_reg, $password_reg, $nickname);
    $stmt->execute();
    $stmt->close();

  }
  function loginUser($email, $password){

    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT id, email, nickname FROM IRC WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->bind_result($id_from_db, $email_from_db, $nickname_from_db);
    $stmt->execute();
    if($stmt->fetch()){
      $_SESSION["logged_in_user_id"] = $id_from_db;
      $_SESSION["logged_in_user_email"] = $email_from_db;
      $_SESSION["logged_in_user_nickname"] = $nickname_from_db;
      header("Location: home.php");
    }
    else{
      echo "Valed andmed";
    }
  }
  function sendMessage($message, $nickname){
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO chat (message, nickname, timestamp) VALUES (?,?, now())");
    $stmt->bind_param("ss", $message, $nickname);
    $stmt->execute();
    $stmt->close();
  }
  function getMessageData($keyword=""){
	$search= "%%";
	if($keyword == ""){
	}
	else{
		$search= "%".$keyword."%";
	}
	  $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	  //$stmt = $mysqli->prepare("SELECT id, nickname, message, timestamp from chat WHERE deleted IS NULL ");
	  $stmt= $mysqli->prepare("SELECT id, nickname, message, timestamp FROM chat WHERE deleted is NULL AND (nickname LIKE ? OR message LIKE ?)");
	  $stmt->bind_param("ss", $search, $search);
	  $stmt->bind_result($id, $nickname, $message, $timestamp);
	  $stmt->execute();

	  // tekitan tühja massiivi, kus edaspidi hoian objekte
	  $chat_array = array();

	  //tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
		// seda siin sees tehakse
		// nii mitu korda kui on ridu
		// tekitan objekti, kus hakkan hoidma väärtusi
		$chat = new StdClass();
		$chat->id = $id;
		$chat->nickname = $nickname;
		$chat->message = $message;
		$chat->timestamp = $timestamp;

		//lisan massiivi ühe rea juurde
		array_push($chat_array, $chat);
		//var dump ütleb muutuja tüübi ja sisu
		//echo "<pre>";
		//var_dump($car_array);
		//echo "</pre><br>";
	  }

	  //tagastan massiivi, kus kõik read sees
	  return $chat_array;


	  $stmt->close();
	  $mysqli->close();
	}
function updateChat($message, $id){
	echo "updateChat launched";
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE chat SET message=? WHERE id=?");
	$stmt->bind_param("si", $message, $id);
	if($stmt->execute()){
		header("Location: home.php");

	}

	$stmt->close();
	$mysqli->close();
}


?>
