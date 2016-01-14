<?php

	require_once("../config_global.php");
	$database = "if15_helepuh_3";




	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT animal, animal_name FROM animals WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);	//bind_param asendab küsimärgid
		$stmt->bind_result($animal, $animal_name);
		$stmt->execute();
		
		$review = new StdClass();
		
		if($stmt->fetch()){
			//sain
			
			$review->animal=$animal;
			$review->animal_name=$animal_name;

			
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
        	$stmt = $mysqli->prepare("SELECT animal, animal_name FROM animals WHERE id=? AND deleted IS NULL");
		}
		else {
		
        	$stmt = $mysqli->prepare("SELECT animal, animal_name FROM animals WHERE deleted IS NULL");
        }*/
		$stmt = $mysqli->prepare("SELECT id, animal, animal_name FROM animals");
        //$stmt->bind_param("s", $_SESSION["logged_in_user_id"], $id, $animal, $animal_name);
        echo $mysqli->error;
		$stmt->bind_result($id, $animal, $animal_name);
        $stmt->execute();
       
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame  andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $animals = new StdClass();
            
			$animals->id = $id;
            $animals->animal = $animal;
            $animals->animal_name = $animal_name; 

            
            //lisan andmed massivi
            array_push($array, $animals);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
       
        $stmt->close();
        $mysqli->close();
    }
	
	
	function deleteAnimal($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE animals SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateAnimal($id, $animal, $animal_name){
	

		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE animals SET user_id=?, animal=?, animal_name=? WHERE id=?");
		$stmt->bind_param("issi", $_SESSION["logged_in_user_id"], $animal, $animal_name, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
?>