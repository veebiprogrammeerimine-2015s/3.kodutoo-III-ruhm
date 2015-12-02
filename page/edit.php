<?php 

	require_once("edit_functions.php");
	
	if(isset($_POST["update_post"])){

		updateThread($_POST["id"], $_POST["thread"], $_POST["post"]);
	
	}

	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];

		
		$forum = getEditData($_GET["edit_id"]);
		var_dump($forum);
		
	}else{

		header("Locaton: table.php");
	}


?>

<h2>Edit post</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
	<label for="post">Post</label><br>
	<input id="post" name="post" type="text" value="<?=$forum->post;?>"><br><br>
	<input type="submit" name="update_post" value="Save>
</form>