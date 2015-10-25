
<?php
	
	require_once("../../config_global.php");
	$database= "if15_mats_3";

	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt=$mysqli->prepare("SELECT post,  FROM posts WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($post);
		$stmt->execute();
		
		$posts=new StdClass();
	
		if($stmt->fetch()){
			
			$posts->post=$post;
		
			
		}else{	
			header("Location:poststable.php");
			
		}
		return $posts;
		
		$stmt->close();
		$mysqli->close();
	}
		
	function updatePosts ($id, $post){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE posts SET post=? WHERE id=?");
        $stmt->bind_param("si", $post, $id);
        if($stmt->execute()){
			
		
        
        
        header("Location: poststable.php");
        }
        $stmt->close();
        $mysqli->close();
		
		
	}



?>