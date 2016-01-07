<?php 

	require_once("../config_global.php");
	$database = "if15_kar1ns";

	function getEditData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT blog_post FROM dream_post WHERE id=? AND deleted IS NULL");
		echo $mysqli->error;
		$stmt->bind_param("i", $edit_id); //bind_param asendab küsimärgid (hetkel id)
		$stmt->bind_result($blog_post); //võtab tabeli tlemused, () tuleb panna kõik mis on selecti järgi
		$stmt->execute();
		
		//object
		$blog = new StdClass();
		
		if($stmt->fetch()){ //fetcf annab ühe re andmed
			$blog->blog_post = $blog_post;
		}else{
			//ei saanud, id ei ole olemas
			//dlited ei ole 0
			header("Location: table.php");
		}
		return $blog;
		
		$stmt->close();
		$mysqli->close();
	}

	function updateDream($id, $blog_post){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE dream_post SET blog_post=? WHERE id=?");
		
		$stmt->bind_param("si", $blog_post, $id);
		if($stmt->execute()){
			//sai kustutatud
			header("Location: table.php");
	
		}
	}
	
?>