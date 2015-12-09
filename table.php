<?php
$i = 0;
$array_menu = array();

$array_menu[$i]['url']="data.php";
$array_menu[$i++]['name']='Lisa märkuse';


echo "<ul>\n";
for ($i=0;$i<count($array_menu);$i++)
{
       echo ($_SERVER["REQUEST_URI"] == $array_menu[$i]['url']) ? '<li class="active">': '<li>';
       echo "<a href=\"".$array_menu[$i]['url']."\">".$array_menu[$i]['name']."</a></li>\n";
}
echo "</ul>";
?>


<?php
	require_once("functions.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
	header("Location: newfile.php");
	}
	
	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteNote($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		var_dump($_POST);
		updateNote($_POST["id"], $_POST["title"], $_POST["note"]);
	}
	
		$keywod = "";
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$array_of_notes = getNoteData($keyword);
		
	}else{
		
		//kusin koik andmed
	
	
	//käivitan funktsiooni
	$array_of_notes = getNoteData();
	
	}
	
?>

<h2>Tabel</h2>

<form action="table.php" method="get" >
	<input type="search" name="keyword" >
	<input type="submit" >
</form>

<table border=1 >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>pealkiri</th>
		<th>märkus</th>
		<th>X</th>
		<th>edit</th>
		<th></th>
	</tr>
	
<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_notes); $i++){
			//echo $array_of_notes[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_notes[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_notes[$i]->id."'>";
				echo "<td>".$array_of_notes[$i]->id."</td>";
				echo "<td>".$array_of_notes[$i]->user_id."</td>";
				echo "<td><input name='title' value='".$array_of_notes[$i]->title."'></td>";
				echo "<td><input name='note' value='".$array_of_notes[$i]->note."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$array_of_notes[$i]->id."</td>";
				echo "<td>".$array_of_notes[$i]->user_id."</td>";
				echo "<td>".$array_of_notes[$i]->title."</td>";
				echo "<td>".$array_of_notes[$i]->note."</td>";
				
				
				
				echo "<td><a href='?delete=".$array_of_notes[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_notes[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_notes[$i]->id."'>edit.php</a></td>";
				
				
				echo "</tr>";
				
			}
			
		}
	
	
?>
</table>
