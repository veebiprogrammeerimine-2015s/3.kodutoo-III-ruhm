<?php 

	//edit_functions.php
	require_once("../../config_global.php");
	$database = "if15_martin";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt= $mysqli->prepare("SELECT post FROM martin_threads WHERE id=?");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($post);
		$stmt->execute();
		
		$forum = new StdClass();
		
		if($stmt->fetch()){
			$forum->post = $post;
			
		}else{

		}
		
		return $forum;
		
		$stmt->close;
		$mysqli->close();
	}

	function updateThread($id, $post){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE martin_threads SET post=? WHERE id=?");
		$stmt->bind_param("si", $post, $id);
		if($stmt->execute()){

			header("Location: data.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}


?>