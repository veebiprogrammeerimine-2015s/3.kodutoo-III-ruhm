<?php
	require_once("functions.php");
	$page_title = "Avaleht";
	$page_file_name = "home.php";
	require_once("header.php"); 
?>
	
	<h2>Avaleht</h2>
	
<?php
	
	
	
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$array_of_content = getPosts($keyword);
		
	}else{
		
		//käivitan funktsiooni
		$array_of_content = getPosts();
	}
	
	
	

	
?>

<h2>Tabel</h2>

<form action="home.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit" value="Otsi">
</form>

<table >
	<tr>
		
		<th>tiitel</th>
		<th>meedia</th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_content); $i++){
			//echo $array_of_content[$i]->id;
			
			//kasutaja tahab muuta seda rida
			
			
			echo "<tr>";
			
			echo "<td>".$array_of_content[$i]->title."</td>";
			echo "<td><img src='".$array_of_content[$i]->media."' width='200px'></td>";
			echo "</tr>";
			
		
			
		}
	
	
	?>
</table>
	
<?php require_once("footer.php"); ?>