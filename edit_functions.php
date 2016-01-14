<?php

	require_once("../config_global.php");
	$database = "if15_raoulk";



	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($boot_brand, $model);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->boot_brand=$boot_brand;
			$review->model=$model;

			
		}else{
			header("Location:table.php");
		}
		return $review;
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getAllData(){

       
       $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // deleted IS NULL - ei ole kustutatud
        /*if ($role_id_in == 9) {
        	$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE id=? AND deleted IS NULL");
		}
		else {
		
        	$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE deleted IS NULL");
        }*/
		$stmt = $mysqli->prepare("SELECT id, user_id, boot_brand, model FROM footyboots");
        //$stmt->bind_param("s", $_SESSION["logged_in_user_id"], $id, $boot_brand, $model);
        echo $mysqli->error;
		$stmt->bind_result($id, $user_id, $boot_brand, $model);
        $stmt->execute();
       
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame  andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $footyboots = new StdClass();
            
			$footyboots->id = $id;
			$footyboots->user_id = $user_id;
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
