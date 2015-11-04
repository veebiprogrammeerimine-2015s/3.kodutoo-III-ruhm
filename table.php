<?php
	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$grade = "";

	if(isset($_GET["delete"])){
		echo "Kustutame id" .$_GET["delete"];
		deleteReview($_GET["delete"]);
	}
	if(isset($_POST["save"])){
		updateReview($_POST["id"], $_POST["exam"], $_POST["grade"], $_POST["mistakes"]);
	}
	
	$keyword="";
	
	if(isset($_GET["keyword"])){
		$keyword= $_GET["keyword"];
		$review_array = getReviewData($keyword);
	}
	else{
		$review_array = getReviewData();
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../style.css">
	</head>
	<body>
		<p>Tere, <?=$_SESSION["logged_in_user_email"];?>
			<a href="?logout=1"> Logi välja <a>
		</p>

		<h2>Lisa Arvestus töö</h2>
		<form class="form-style-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<label for ="exam">Määra arvestus töö</label><br>
				<input id="exam" name="exam" type="text" placeholder="Arvestus töö" value="<?php echo $exam; ?>" > <?php echo $exam_error; ?><br><br>
				<label for ="grade">Tulemus</label><br>
				
				<input id="grade" type="radio" value="F" name="grade"  > F
				<input id="grade" type="radio" value="D" name="grade"  > D
				<input id="grade" type="radio" value="C" name="grade"  > C
				<input id="grade" type="radio" value="B" name="grade"  > B
				<input id="grade" type="radio" value="A" name="grade"  > A

				<br><br>
				<label for ="mistakes">Anna tagasiside töökohta</label><br>
				<textarea id="mistakes" name="mistakes" col=40 rows=8 placeholder="Kirjuta siia oma mistakes" value="<?php echo $mistakes; ?>"> <?php echo $mistakes_error; ?> </textarea><br><br>
				<input type="submit" name="add_review" value="Sisesta"><br>
		</form>	
		<h2>Arvestustööde tulemused</h2>

		<form class="form-style-4" action="data.php" method="get"> 
			<input type="search" name="keyword" placeholder="otsing" value="<?=$keyword;?>">
			<input type="submit" value="Otsi">
		</form>
		<table border="1">
			<tr>
				<th>Id</th>
				<th>User id</th>
				<th>exam</th>
				<th>grade</th>
				<th>mistakes</th>
				<th>X</th>
				<th>Edit</th>
				
			</tr>

			<?php
				for($i = 0; $i < count($review_array); $i++){
					if(isset($_GET["edit"]) && $review_array[$i]->id == $_GET["edit"]){
						echo "<tr>
						<form action='data.php' method='post'>
						<input type='hidden' name='id' value='".$review_array[$i]->id."'>
						<td>".$review_array[$i]->id."</td>
						<td>".$review_array[$i]->user_id."</td>
						<td><input name='exam' value ='".$review_array[$i]->exam."'></td>
						<td><input name='grade' value ='".$review_array[$i]->grade."'></td>
						<td><input name='mistakes' value ='".$review_array[$i]->mistakes."'></td>
						<td><a href='data.php'>Tühista</a></td>
						<td><input type='submit' name='save'></td>
						</tr>
						</form>";
						
					}else{

						echo "<tr>
						<td>".$review_array[$i]->id."</td>
						<td>".$review_array[$i]->user_id."</td>
						<td>".$review_array[$i]->exam."</td>
						<td>".$review_array[$i]->grade."</td>
						<td>".$review_array[$i]->mistakes."</td>";
						
						if($_SESSION["logged_in_user_id"] == $review_array[$i]->user_id){
							echo "<td><a href='?delete=".$review_array[$i]->id."'>Kustuta</a></td>";
							echo "<td><a href='?edit=".$review_array[$i]->id."'>muuda</a></td>";
						}
						echo "</tr>";
					}
				}
			?>
		</table>
	</body>
</html>