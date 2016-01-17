<?php 
	
	// Loon AB'i ühenduse
	require_once("../config_global.php");
	$database = "if15_raoulk";
	
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash){
		
		// Global muutujad, et kätte saada config failist andmed
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
			// ab'i oli midagi
			echo "E-mail and password are correct, your user id is: ".$id_from_db;
			
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
	
	// fn sample
	function hello($name){
		echo $name;
	}
	function getAllData($keyword=""){

	
		$search = "%%";
		
		//kas otsisõna on tühi
		if($keyword == ""){
			//ei otsi midagi
			echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
       
       $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // deleted IS NULL - ei ole kustutatud
        /*if ($role_id_in == 9) {
        	$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE id=? AND deleted IS NULL");
		}
		else {
		
        	$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE deleted IS NULL");
        }*/
		$stmt = $mysqli->prepare("SELECT id, user_id, boot_brand, model FROM footyboots WHERE deleted IS NULL AND (boot_brand LIKE ? OR model LIKE ?");
        $stmt->bind_param("ss", $search, $search);
        echo $mysqli->error;
		$stmt->bind_result($id, $user_id_from_database, $boot_brand, $model);
        $stmt->execute();
		
       
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame  andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $footyboots = new StdClass();
            
			$footyboots->id = $id;
			$footyboots->user_id = $user_id_from_database;
            $footyboots->boot_brand = $boot_brand;
            $footyboots->model = $model; 

            
            //lisan andmed massivi
            array_push($array, $footyboots);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
       
        $stmt->close();
        $mysqli->close();
    }

	
	
	
	// kuigi muuutujad on erinevad jõuab väärtus kohale
	function addBoot($boot_brand, $model) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO footyboots (user_id, boot_brand, model) VALUES (?,?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $boot_brand, $model);
		
		//sõnum
		$message = "";
		
		if($stmt->execute()){
			// kui on tõene,
			//siis INSERT õnnestus
			$message = "Operation was successful";
			 
			
		}else{
			// kui on väärtus FALSE
			// siis kuvame errori
			echo $stmt->error;
			
		}
		
		return $message;
		
		
		$stmt->close();
		
		$mysqli->close();
		
		
	}
	
	function deleteboot($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE footyboots SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateboot($boot_brand, $model, $id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE footyboots SET boot_brand=?, model=? WHERE id=? AND user_id=?");
		$stmt->bind_param("ssii", $boot_brand, $model, $id, $_SESSION["logged_in_user_id"]);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
?>	