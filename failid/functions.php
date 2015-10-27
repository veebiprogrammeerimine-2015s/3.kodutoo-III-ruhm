 <?php
	require_once("../../config_global.php");
	$database = "if15_janekos_3";
	
	session_start();
	
	function createUser($create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			header("Location: data.php");
			
		}else{
			echo "Email või parool valed.";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function addArmor($logged_in_user_id, $armor_type, $armor_race, $armor_color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO armorid (user_id, type, race, color) VALUES (?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("isss",$logged_in_user_id, $armor_type, $armor_race, $armor_color);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "Sai edukalt lisatud!";
		}else{
			echo $stmt->error;
		}
		return $message;
		echo $stmt->error;
		$stmt->close();
		$mysqli->close();
	}
	
 ?>