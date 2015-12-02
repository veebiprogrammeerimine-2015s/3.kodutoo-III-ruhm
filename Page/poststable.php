<?php
	require_once("functions.php");
	require_once("tablefunctions.php");
	
	
	
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		
		deletePosts($_GET["delete"]);
		
	}
	if(isset($_POST["save"])){
		
		updatePosts($_POST["id"], $_POST["post"]);
		
	}
	$keyword= "";
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$array_of_posts = getPostsData($keyword);
		
	}else{
		$array_of_posts=getPostsData();
	
	}

?>
<a href="data.php">Lisa uus postitus</a>
<h2>Tabel</h2>
<form action="poststable.php" method="get" >
	<input type="search" name="keyword" value="<?=$keyword;?>" >
	<input type="submit">
</form>

<table border=1 >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>Postitus</th>
		<th>X</th>
		<th></th>
	</tr>
<?php
		
	for($i=0; $i< count($array_of_posts) ; $i++){
			
			
		if(isset($_GET["edit"]) && $array_of_posts[$i]->id == $_GET["edit"]){
				
			echo"<tr>";
			echo"<form action='poststable.php' method='post'>";
			echo"<input type='hidden' name='id' value='".$array_of_posts[$i]->id."'>";
			echo"<td>".$array_of_posts[$i]->id."</td>";
			echo"<td>".$array_of_posts[$i]->user_id."</td>";
			echo"<td><input name='post' value='".$array_of_posts[$i]->post."'></td>";
			echo"<td><a href='poststable.php'>cancel<a></td>";
			echo"<td><input type='submit' name='save'></td>";
			echo"</form>";
			echo"</tr>";
				
		}else{
			echo"<tr>";
			echo"<td>".$array_of_posts[$i]->id."</td>";
			echo"<td>".$array_of_posts[$i]->user_id."</td>";
			echo"<td>".$array_of_posts[$i]->post."</td>";
			
			if($_SESSION["logged_in_user_id"]==$array_of_posts[$i]->user_id){
				echo"<td><a href='?delete=".$array_of_posts[$i]->id."'>X</a></td>";
				echo"<td><a href=edit.php?edit_id=".$array_of_posts[$i]->id."'>edit</a></td>";
			}
			
			
			echo"</tr>";
				
				
				
		}
				
				
	}
			
			
			
	
	
?>
</table>