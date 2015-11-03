<?php 
	
	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	session_start();
	
	function createUser($create_email, $hash, $firstname, $lastname){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO newfile (email, password, firstname, lastname) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $create_email, $hash, $firstname, $lastname);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
	}
	
		
	
	
	
	function loginUser($login_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM newfile WHERE email=? AND password=?");
		echo $mysqli->error;
		$stmt->bind_param("ss", $login_email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool oiged, kasutaja id=".$id_from_db;
			
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
		}else{
			echo "Wrong redentials";
		}
				
		$stmt->close();
		
		$mysqli->close();
	}
	
	function addNote($note_title, $note_note){
		
		echo $note_title;
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO note_table (user_id, title, note) VALUES (?,?,?)");
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $note_title, $note_note);
		
		//sonum
		$message = "";
		
		if($stmt->execute()){
			//kui on tõene, siis INSERT õnnestus
			$message = "Sai edukalt lisatud";
		}else{
			//kui on väär, siis kuvame error
			echo $stmt->error;
		}
		
		return $message;
		
		$stmt->close();
		
		$mysqli->close();
	}
		
		
	function getNoteData($keyword=""){
		
				$search = "%%";
		
		//kas otsisona on tuhi
		if($keyword==""){
			//ei otsi midagi
			echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin ".$keyword;
			$search = "%".$keyword."%";
		
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, title, note from note_table WHERE deleted IS NULL AND (title LIKE ? OR note LIKE ?) ");
		
		//echo $stmt->error;
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $title, $note);
		$stmt->execute();
		
		// tekitan tuhja massiivi, kus edaspidi hoian objekte
		$note_array = array();
		
		//tee midagi seni, kuni saame ab'ist uhe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			// tekitan objekti, kus hakkan hoidma vaartusi
			$Note1 = new StdClass();
			$Note1->id = $id;
			$Note1->title = $title;
			$Note1->user_id = $user_id_from_database;
			$Note1->note = $note;
			
			//lisan massiivi uhe rea juurde
			array_push($note_array, $Note1);
			//var dump utleb muutuja tuubi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus koik read sees
		return $note_array;
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	function deleteNote($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE title SET deleted=NOW() WHERE id=?");
		
		echo $mysqli->error;
		
		$stmt->bind_param("i", $id);
		
		echo $stmt->error;
		
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tuhjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateNote($id, $title, $note){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE note_table SET title=?, note=? WHERE id=?");
		$stmt->bind_param("ssi", $title, $note, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tuhjaks
			// header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
?>