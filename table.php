<?php
	
	require_once("functions.php");
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id".$_GET["delete"];
		deletePost($_GET["delete"]);	
	}
	
	if(isset($_POST["save"])){
		
		updatePost($_POST["id"],$_POST["tweet"]);
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		
		$keyword = ($_GET["keyword"]); 
		$array_of_tweets = getPostData($keyword);
	}else{
		
		$array_of_tweets = getPostData();
	}
	
?>

<h2>Minu säutsud</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="Submit" value="Otsi">
	<input type="Submit" value="Tagasi" onclick="window.open('data.php')">
</form>
<table border="1">
	<tr>
		<th>Säuts</th>
		<th>Kustuta</th>
		<th>Muuda</th>
	</tr>
	
	<?php
		//trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_tweets); $i++){
			//echo $array_of_cars[$i]->id;
			//echo "<tr>";
			
			if($array_of_tweets[$i]->user_id == $_SESSION["logged_in_user_id"]){
				
				if(isset($_GET["edit"]) && $array_of_tweets[$i]->id == $_GET["edit"]){
				
				echo"<tr>";
				echo"<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_tweets[$i]->id."'>";
				echo "<td><input name='tweet' value='".$array_of_tweets[$i]->tweet."'></td>";
				echo "<td><a href ='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo"</form>";
				echo"</tr>";
				
				}else{
				echo"<tr>";
				echo "<td>".$array_of_tweets[$i]->tweet."</td>";
				echo "<td> <a href ='?delete=".$array_of_tweets[$i]->id."'>X</a></td>";
				echo "<td> <a href ='?edit=".$array_of_tweets[$i]->id."'>edit</a></td>";
				echo"</tr>";
				}
			
			}
				
		}
	
	?>
</table>