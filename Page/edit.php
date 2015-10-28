<?php
	
	require_once("edit_functions.php");
	
	if(isset($_POST["update_post"])){	
			updatePosts($_POST["id"], $_POST["post"]);
	}		
	
	if(isset($_GET["edit_id"])){
		echo $_GET ["edit_id"];
		
		$posts=getEditData($_GET ["edit_id"]);
		var_dump($posts);
	}else{
		echo "VIGA";
		
		header("Location:poststable.php");
	}
	

?>
<h2>Muuda postitust </h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
		<label for="post">Postitus</label><br>
		<input id="post" name="post" type="text"  value="<?=$posts->post;?>"> <br><br>
		<input type="submit" name="update_post" value="Salvesta">
  </form>	