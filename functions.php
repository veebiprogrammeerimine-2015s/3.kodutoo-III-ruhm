<?php 
	
	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	
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
			array_push($note_array, $note);
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
		$stmt->bind_param("i", $id);
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