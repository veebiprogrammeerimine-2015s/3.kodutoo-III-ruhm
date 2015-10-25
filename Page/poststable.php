<?php
	
	require_once("tablefunctions.php");
	
	
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		
		deletePosts($_GET["delete"]);
		
	}
	if(isset($_POST["save"])){
		
		updatePosts($_POST["id"], $_POST["post"]);
		
	}
	$keyword="";
	if(isset($_GET["keyword"])){
		
		$keyword=$_GET["keyword"];
		$array_of_posts=getPostsData($keyword);
		
	}else{

	$array_of_posts=getPostsData();
	
	}

?>

<h2>Tabel</h2>
<table  >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>Postitus</th>
		<th>kustuta</th>
		<th>edit</th>
	
	</tr>
<?php
		
	for($i=0; $i< count($array_of_posts) ; $i++){
			
			
		if(isset($_GET["edit"]) && $array_of_posts[$i]->id == $_GET["edit"]){
				
			echo"<tr>";
			echo"<form action='table.php' method='post'>";
			echo"<input type='hidden' name='id' value='".$posts_array[$i]->id."'>";
			echo"<td>".$array_of_posts[$i]->id."</td>";
			echo"<td>".$array_of_posts[$i]->user_id."</td>";
			echo"<td><input name='post' value='".$array_of_posts[$i]->post."'></td>";
			echo"<td><a href='table.php'>cancel<a></td>";
			echo"<td><input type='submit' name='save'></td>";
			echo"</form>";
			echo"</tr>";
				
		}else{
			echo"<tr>";
			echo"<td>".$array_of_posts[$i]->id."</td>";
			echo"<td>".$array_of_posts[$i]->user_id."</td>";
			echo"<td>".$array_of_posts[$i]->post."</td>";
			echo"<td><a href='?delete=".$array_of_posts[$i]->id."'>X</a><td>";
			echo"<td><a href='?edit=".$array_of_posts[$i]->id."'>edit</a><td>";
			echo"</tr>";
				
				
				
		}
				
				
	}
			
			
			
	
	
?>
</table>