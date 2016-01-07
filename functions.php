<?php 
	
	// Loon AB'i ühenduse
	require_once("../config.php");
	$database = "np3799_abprojekt";
	
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	// võtab andmed ja sisestab ab'i
	// võtame vastu 2 muutujat
	function createUser($create_email, $hash, $is_admin){
		
		// Global muutujad, et kätte saada config failist andmed
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO k3_subjects (email, password, role) VALUES (?,?,?)");
		$stmt->bind_param("sss", $create_email, $hash, $is_admin);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("SELECT id, email, role, vanus, riik FROM k3_subjects WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db, $role_from_db, $vanus_from_db, $riik_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			if ($role_from_db== ""){
			$role_from_db = 1;
			}
			$_SESSION["logged_in_user_role"] = $role_from_db;
			$_SESSION["logged_in_user_vanus"] = $vanus_from_db;
			$_SESSION["logged_in_user_riik"] = $riik_from_db;
			
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	
	// uute andmete lisamine
	function addMedicalItem($med_category, $med_daignose, $med_comment) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO k3_medical_history (sub_id, category, diagnose, comment) VALUES (?,?,?,?)");
		$stmt->bind_param("isss", $_SESSION["logged_in_user_id"], $med_category, $med_daignose, $med_comment);
		
		
		
		if($stmt->execute()){
			// kui on tõene,
			//siis INSERT õnnestus
			$message = "Sai edukalt lisatud";
			 
			
		}else{
			// kui on väärtus FALSE
			// siis kuvame errori
			echo $stmt->error;
			
		}
		
		return $message;
		
		
		$stmt->close();
		
		$mysqli->close();
		
		
	}
	


function getAllData($user_id_in, $role_id_in, $keyword_in){

       $search = "%".$keyword_in."%";
       $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // deleted IS NULL - ei ole kustutatud
        if ($role_id_in == 9) {
        	$stmt = $mysqli->prepare("SELECT id, sub_id, category, diagnose, comment FROM k3_medical_history WHERE deleted IS NULL AND (category LIKE ? OR diagnose LIKE ? OR comment LIKE ?)");
		}
		else {
		
        	$stmt = $mysqli->prepare("SELECT id, sub_id, category, diagnose, comment FROM k3_medical_history WHERE deleted IS NULL AND sub_id=$user_id_in AND (category LIKE ? OR diagnose LIKE ? OR comment LIKE ?)");
        }
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->bind_result($id, $sub_id, $category, $diagnose, $comment);
        $stmt->execute();
        // massiiv kus hoiame medical history
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame  andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $med = new StdClass();
            
            $med->id = $id;
            $med->sub_id = $sub_id; 
            $med->category = $category; 
            $med->diagnose = $diagnose; 
            $med->comment = $comment; 
            
            //lisan andmed massivi
            array_push($array, $med);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
    
    function deleteCarData($car_id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        // uuendan välja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE k3_medical_history SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: data.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    function updateMedicalItem($item_id, $category, $diagnose, $comment){
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE k3_medical_history SET category=?, diagnose=?, comment=? WHERE id=?");
        $stmt->bind_param("sssi", $category, $diagnose, $comment, $item_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location:data.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    
 ?>