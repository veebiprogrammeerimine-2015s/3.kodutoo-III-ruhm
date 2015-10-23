<?php
	require_once("functionsk.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		}
		$raviminimi ="";
		$hinnang = "";
		$kommentaar = "";
		$raviminimi_error = "";
		$hinnang_error = "";
		$kommentaar_error = "";
		
	if(isset($_POST["add_review"])){
		if ( empty($_POST["raviminimi"]) ) {
				$raviminimi_error = "See väli on kohustuslik";
			}else{
				//kõik korras, test_input eemaldab pahatahtlikud osad
				$raviminimi = test_input($_POST["raviminimi"]);
				}
	

		if ( empty($_POST["hinnang"]) ) {
				$hinnang_error = "See väli on kohustuslik";
			}else{
				//kõik korras, test_input eemaldab pahatahtlikud osad
				$hinnang = test_input($_POST["hinnang"]);
				}
				
		if ( empty($_POST["kommentaar"]) ) {
				$kommentaar_error = "See väli on kohustuslik";
			}else{
				//kõik korras, test_input eemaldab pahatahtlikud osad
				$kommentaar = test_input($_POST["kommentaar"]);
				}
				
		//kõik on kohustuslikud
		if($raviminimi_error == "" && $hinnang_error == "" && $kommentaar_error = ""){
			//salvestate ab'i fn kaudu addReview
			//message funktsioonist
			
			$message = addReview($raviminimi, $hinnang, $kommentaar);
			if($message != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$raviminimi = "";
				$hinnang = "";
				$kommentaar = "";
				
				echo $message;
			}
		}
	}
	if(isset($_GET["logout"])){
		//sessiooni peatus
		session_destroy();
		
		header("Location: login.php");
	}
	
	function test_input($data) {	
		$data = trim($data);	//võtab ära tühikud,enterid,tabid
		$data = stripslashes($data);  //võtab ära tagurpidi kaldkriipsud
		$data = htmlspecialchars($data);	//teeb htmli tekstiks, nt < läheb &lt
		return $data;
	}
?>

<p>Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja <a>
</p>
	
<h2>Lisa arvustus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<label for ="raviminimi">Kirjuta ravimi nimi</label><br>
		<input id="raviminimi" name="raviminimi" type="text" value="<?php echo $raviminimi; ?>" > <?php echo $raviminimi_error; ?><br><br>
		<label for ="hinnang">Määra hinnang</label><br>
		<input id="hinnang" name="hinnang" type="text" value="<?php echo $hinnang; ?>"> <?php echo $hinnang_error; ?> <br><br>
		<label for ="kommentaar">Kirjuta kommentaar</label><br>
		<input id="kommentaar" name="kommentaar" type="text" value="<?php echo $kommentaar; ?>"> <?php echo $kommentaar_error; ?> <br><br>
		<input type="submit" name="add_review" value="Sisesta"><br>
		</form>	