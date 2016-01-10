<?php
	require_once("functions.php");
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan login.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$category = $daignose = $comment = "";
	$category_error = $daignose_error = $comment_error = "";
	
	// uue rea lisamine
	if(isset($_POST["add_medical_item"])){
		
		
		// valideerite väljad
		if ( empty($_POST["category"]) ) {
			$category_error = "See väli on kohustuslik";
		}else{
			$category = cleanInput($_POST["category"]);
		}
		
		if ( empty($_POST["daignose"]) ) {
			$daignose_error = "See väli on kohustuslik";
		}else{
			$daignose = cleanInput($_POST["daignose"]);
		}
		$comment = cleanInput($_POST["comment"]);
		// mõlemad on kohustuslikud
		if($category_error == "" && $daignose_error == ""){
			//salvestate ab'i fn kaudu addCarPlate
			// message funktsioonist
			$msg = addMedicalItem($category, $daignose, $comment);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$category = "";
				$daignose = "";
				$comment = "";
				
				echo $msg;
				
			}
			
		}
		
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	

?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="UTF-8">
</head>
<body>
<p>
	Kasutajanimi: <?=$_SESSION["logged_in_user_email"];?> <br>
	Roll: 
	 <? if($_SESSION["logged_in_user_role"] ==9){
	 	echo " olete sisse loginud kui administrator" ;
	 }
	 else{
	 	echo " olete sisse loginud kui tavakasutaja";
	 }
	 ?>
	<a href="?logout=1"> Logi välja  <a> 
	<?php
	if($_SESSION["logged_in_user_role"] == 9){
		echo '<a href="users.php"> Halda kasutajaid <a>';
	}
	?>
	<br>
	Vanus: <?=$_SESSION["logged_in_user_vanus"];?>
	<br>
	Riik: <?=$_SESSION["logged_in_user_riik"];?>
	

</p>

<?php 
	$role_id = 
    require_once("functions.php");
        	
    // kuulan, kas kasutaja tahab kustutada
    // ?delete=... on aadressireal
    if(isset($_GET["delete"])) {
        ///saadan kustutatava auto id
        deleteCarData($_GET["delete"]);
    }
    
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        
        updateMedicalItem($_GET["update_id"], $_GET["update_cat"], $_GET["update_diagnose"], $_GET["update_comment"]);
        print_r("222");
        
    }
    
    //sesiooni muutujad
    $role_id_for_data = $_SESSION["logged_in_user_role"];
    $user_id_for_data = $_SESSION["logged_in_user_id"];
    
    //aadressireal on otsingu keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$med_array = getAllData($user_id_for_data, $role_id_for_data, $keyword);
	}else{
		$keyword = "";
		// küsin kõik andmed
		
		//käivitan funktsiooni
		$med_array = getAllData($user_id_for_data, $role_id_for_data, $keyword);
	}
    
    
?>

<h1>Sinu andmed</h1>

<H2> Lisa uus kirje</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="number_plate" >Kategooria</label>
	<input id="category" name="category" type="text" value="<?php echo $category; ?>"> <?php echo $category_error; ?>
	<label for="daignose">Diagnoos</label>
	<input id="daignose" name="daignose" type="text" value="<?php echo $daignose; ?>"> <?php echo $daignose_error; ?>
	<label for="comment">Kommentaar</label>
	<input id="comment" name="comment" type="text" value="<?php echo $comment; ?>"> <?php echo $comment_error; ?>
	
	<input type="submit" name="add_medical_item" value="Lisa">
</form>

<form action="data.php" method="get" >
	<input type="search" name="keyword" value="<?=$keyword;?>" >
	<input type="submit">
</form>

<table border=1>
<tr>
    <th>id</th>
    <th>kasutaja id</th>
    <th>Haiguse kategooria</th>
    <th>Diagnoos</th>
    <th>Kommentaar</th>
   <?php
   if ($role_id_for_data == 9){
    echo "<th></th>";
    echo "<th></th>";
    }
    ?>
    
    
</tr>
<?php 
    
    // objektid ükshaaval läbi käia
    for($i = 0; $i < count($med_array); $i++){
        
        // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $med_array[$i]->id){
            echo "<tr>";
            echo "<form action='data.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='update_id' value='".$med_array[$i]->id."'>";
            echo "<td>".$med_array[$i]->id."</td>";
            echo "<td>".$med_array[$i]->sub_id."</td>";
            echo "<td><input name='update_cat' value='".$med_array[$i]->category."' ></td>";
            echo "<td><input name='update_diagnose' value='".$med_array[$i]->diagnose."' ></td>";
            echo "<td><input name='update_comment' value='".$med_array[$i]->comment."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='data.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }
        
        if ($role_id_for_data <> 9){
        
        // lihtne vaade admin
            echo "<tr>";
            echo "<td>".$med_array[$i]->id."</td>";
            echo "<td>".$med_array[$i]->sub_id."</td>";
            echo "<td>".$med_array[$i]->category."</td>";
            echo "<td>".$med_array[$i]->diagnose."</td>";
            echo "<td>".$med_array[$i]->comment."</td>";
          
            echo "</tr>";
        
        }
        else{
            // lihtne vaade admin
            echo "<tr>";
            echo "<td>".$med_array[$i]->id."</td>";
            echo "<td>".$med_array[$i]->sub_id."</td>";
            echo "<td>".$med_array[$i]->category."</td>";
            echo "<td>".$med_array[$i]->diagnose."</td>";
            echo "<td>".$med_array[$i]->comment."</td>";
            echo "<td><a href='?delete=".$med_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$med_array[$i]->id."'>edit</a></td>";
            echo "</tr>";
            
        }
        
        
        
        
    }
    
?>
</table>


<body>
<html>
