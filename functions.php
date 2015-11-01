
<?php 
	
	require_once("../config_global.php");
	$database = "if15_raoulk";
	//****************************************************************************
		//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $create_email, $hash, $first_name, $last_name);
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
			// ab'i oli midagi
			echo "E-mail and password are correct, your users id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	//****************************************************************************
	
	function addBootData($boot_brand, $model) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO football (user_id, boot_brand, model) VALUES (?,?,?)");
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $car_plate, $car_color);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "Operation was successful";
		}else{
			echo $stmt->error;
		}
		
		return $message;
			
		$stmt->close();
		
		$mysqli->close();
		
		
	}
	
	function getBootData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, boot_brand, model from football WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id_from_database, $boot_brand, $model);
		$stmt->execute();
		//tekitan massiivi, kus edaspidi hoian objekte
		$boot_array = array();
		
		
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			
			//tekitan objecti, kus hakkan hoidma väärtusi
			$boot = new StdClass();
			$boot->id = $id;
			$boot->brand = $boot_brand;
			$boot->model = $model;
			$boot->user_id = $user_id_from_database;
			
			//lisan massiivi
			array_push($boot_array, $boot);
			//var dump ütleb muutjua tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus kõik read sees
		return $boot_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteBoot($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE football SET deleted=NOW() WHERE id=?");
		
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadresirea tühjaks
			header("Location: table.php");
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function updateBoot($id, $boot_brand, $model){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE football SET boot_brand=?, model=? WHERE id=?");
		
		$stmt->bind_param("ssi", $boot_brand, $model, $id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadresirea tühjaks
			//header("Location: table.php");
		}
	}
?>