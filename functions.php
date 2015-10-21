<?php 
	
	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	
	function getNoteData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, pealkiri, märkus from p2evik WHERE deleted IS NULL ");
		$stmt->bind_result($id, $user_id_from_database, $pealkiri, $märkus);
		$stmt->execute();
		
		// tekitan tuhja massiivi, kus edaspidi hoian objekte
		$note_array = array();
		
		//tee midagi seni, kuni saame ab'ist uhe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			// tekitan objekti, kus hakkan hoidma vaartusi
			$note = new StdClass();
			$note->id = $id;
			$note->pealkiri = $pealkiri;
			$note->user_id = $user_id_from_database;
			$note->märkus = $märkus;
			
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
		$stmt = $mysqli->prepare("UPDATE pealkiri SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tuhjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateNote($id, $pealkiri, $märkus){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE p2evik SET pealkiri=?, märkus=? WHERE id=?");
		$stmt->bind_param("ssi", $pealkiri, $märkus, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tuhjaks
			// header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
?>