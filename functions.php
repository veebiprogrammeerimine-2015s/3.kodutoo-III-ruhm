<?php
	// functions.php
	// siia tulevd funktsioonid, kõik mis seotud AB'ga
	
	// Loon AB'i ühenduse
	require_once("../configGlobal.php");
	$database = "if15_toomloo_3";
	
	// tekitatakse sessioon, mida hoitakse serveris
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	function register($create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO MVP (email, password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		
	}
	
	function cleanInput($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
  	  return $data;
    }
	
	function login($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM MVP WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		//Kontrollin kas tulemusi leiti
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			// suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
				
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function addBet($teamname, $summa){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE MVP SET teamname=?, summa=? WHERE id=? ");
		$stmt->bind_param("ssi", $teamname, $summa, $_SESSION["logged_in_user_id"]);
		
		// sõnum
		$message = "";
		
		if($stmt->execute()){
			// kui on tõene, siis INSERT õnnestus
			$message = "Sai edukalt lisatud";
		
		}else{
			// kui on väär, siis kuvame errori
			echo $stmt->error;
		}
		
		return $message;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function getTeamData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, teamname, player1, player2, player3, player4, player5 FROM tiimid");
		$stmt->bind_result($id, $teamname, $player1, $player2, $player3, $player4, $player5);
		$stmt->execute();
		
		// tekitan tühja massiivi, kus edaspidi hoian objekte
		$team_array= array();
		
		// tee midagi seni, kuni saame ab'st ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse nii mitu korda kuni on ridu
			
			//tekitan objekti, kus hakkan hoidma väärtusi
			$team = new StdClass();
			$team->id = $id;
			$team->teamname = $teamname;
			$team->player1 = $player1;
			$team->player2 = $player2;
			$team->player3 = $player3;
			$team->player4 = $player4;
			$team->player5 = $player5;
			
			// lisan massiivi ühe rea juurde
			array_push($team_array, $team);
			// var_dump ütleb muutuja nime ja stuffi
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		// tagastan massiivi, kus kõik read sees
		return $team_array;
		
		$stmt->close();
		$mysqli->close();
	}

?>