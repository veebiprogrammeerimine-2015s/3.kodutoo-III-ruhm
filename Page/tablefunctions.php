
<?php

require_once("../../config_global.php");
	$database= "if15_mats_3";
	
	function getPostData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt= $mysqli->prepare("SELECT id, user_id, post, from posts WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id_from_database, $post, );
		$stmt->execute();
		
		$posts_array = array();
		while($stmt->fetch()){
			
			$posts = new StdClass();
			$posts->id= $id;
			$posts->post = $post;
			$posts->user_id= $user_id_from_database;
			
			
			array_push($posts_array, $posts);
			
		}
		
		//tagastan massiivi,kus kõik read sees
		return $posts_array;
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deletePost($id){
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("UPDATE posts SET deleted=NOW() WHERE id=?");
	$stmt->bind_param("i", $id);
	if($stmt->execute()){
		
		header("Location: table.php");
		
	}
	$stmt->close();
	$mysqli->close();
	
	
	
	}
	
	function updatePosts ($id, $post,){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET post=?,  WHERE id=?");
        $stmt->bind_param("si", $post, , $car_id);
        if($stmt->execute()){
			
		
        
        // tühjendame aadressirea
        header("Location: table.php");
        }
        $stmt->close();
        $mysqli->close();
		
		
	}
	//käivitan funktsiooni
	
?>	