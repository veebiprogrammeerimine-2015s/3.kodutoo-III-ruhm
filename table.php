<?php
	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$rating = "";
	
	//kas kustutame, ?delete = vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		echo "Kustutame id" .$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id
		deleteReview($_GET["delete"]);
	
	}
	//salvestan andmebaasi
	if(isset($_POST["save"])){
		updateReview($_POST["id"], $_POST["footballer"], $_POST["rating"], $_POST["comment"]);
	}
	
	$keyword="";
	
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin	
		$keyword= $_GET["keyword"];
		$review_array = getReviewData($keyword);
		
	}else{
	$review_array = getReviewData();
	}
	
?>
<html>
<body>
<h2>Pildid</h2>

<form action="table.php" method="get"> 
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit">
</form>
<table border="1">
	<tr>
		<th>Id</th>
		<th>User id</th>
		<th>footballer</th>
		<th>rating</th>
		<th>comment</th>
		<th>X</th>
		<th>Edit</th>
		
	</tr>
</body>
</html>
	<?php
		//trükime välja read
		//massiivi pikkus count()
		for($i = 0; $i < count($review_array); $i++){
			//echo $review_array[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $review_array[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$review_array[$i]->id."'>";
				echo "<td>".$review_array[$i]->id."</td>";
				echo "<td>".$review_array[$i]->user_id."</td>";
				echo "<td><input name='footballer' value ='".$review_array[$i]->footballer."'></td>";
				echo "<td><input name='rating' value ='".$review_array[$i]->rating."'></td>";
				echo "<td><input name='comment' value ='".$review_array[$i]->comment."'></td>";
				echo "<td><a href='table.php'>Cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</tr>";
				echo "</form>";
				
			}else{
				echo "<tr>";
				echo "<td>".$review_array[$i]->id."</td>";
				echo "<td>".$review_array[$i]->user_id."</td>";
				echo "<td>".$review_array[$i]->footballer."</td>";
				echo "<td>".$review_array[$i]->rating."</td>";
				echo "<td>".$review_array[$i]->comment."</td>";
				
				if($_SESSION["logged_in_user_id"] == $review_array[$i]->user_id){
					echo "<td><a href='?delete=".$review_array[$i]->id."'>X</a></td>";
					echo "<td><a href='?edit=".$review_array[$i]->id."'>edit</a></td>";
				}
				echo "</tr>";
			}
			
			
		}
	
	?>
</table>