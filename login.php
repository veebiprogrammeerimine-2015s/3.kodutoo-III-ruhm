<?php

	require_once("../config.php");
	require_once("hidden/functions.php");
	$database = "if15_hendval";

	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
	
	// LOGIN.PHP
	$email_error = "";
	$password_error = "";

	// muutujad andmebaasi väärtuste jaoks
	$email = "";
	$password = "";
	$password_repeat = "";	

	// kontrollime, et keegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//echo "keegi vajutas nuppu";
		
		//vajutas login nuppu
		if(isset($_POST["login"])){
			
			
			if(empty($_POST["email"]))  {
				$email_error = "VEATEADE: Email on kohustuslik!";
			} else {
				$email = test_input($_POST["email"]);
				
			}
			
			if(empty($_POST["password"])) {
				$password_error = "VEATEADE: Parool on kohustuslik!";
			} else {
				
				//kui oleme siia jõudnud siis parool ei ole tühi
				$password = test_input($_POST["password"]);
			}
			
			if($email_error == "" && $password_error == ""){
				
				$hash = hash("sha512", $password);
				loginUser($email, $hash);
				
			}
			
		}
		
		
		
	}
	
	function test_input($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		// tagurpidi kaldkriipsud
		$data = stripslashes($data);
		// teeb htmli tekstiks
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<?php
	$page_title = "Login leht";
	$page_file_name = "login.php";
?>
<div id="container">
<div id="header">
<div class="headerblock">
<?php require_once("header.php"); ?>
</div>
<div class="loginblock">
<?php if(isset($_SESSION["logged_in_user_id"])){echo "<span class='login'>Teretulemast ".$_SESSION["logged_in_user_name"]."! <a href='?logout=1'>Logi välja</a></span>"; 
} else { echo "<span class='login'><a href='login.php'>Logi sisse</a> / <a href='register.php'>Registreeri</a></span>"; } ?><br>
<?php if(isset($_SESSION["logged_in_user_id"])){echo "<span class='login'>Krediit: ".$_SESSION["logged_in_user_credits"]."</span>";} ?>
</div>
</div>
<div id="content">
<div id="menu">
<div class="menublockupper">
<?php require_once("menu.php"); ?>
</div>
<?php if(isset($_SESSION["logged_in_user_id"])){
	echo "<div class='menublocklower'><ul><li><a href='data.php'>Seaded</a></li><li><a href='?logout=1'>Logi välja</a></li></ul></div>";
} ?>
</div>
<div id="main">
<div class="mainblock">
		<h2>Logi sisse</h2>
			<form action="login.php" method="post">
				E-mail:<br>
				<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br>
				Parool:<br>
				<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?><br><br>
				<input name="login" type="submit" value="Logi sisse"><br>
			</form>
<a href="register.php">Pole kasutajat? Registreeri siin!</a>
</div>
</div>
</div>
</div>
<br>
<center>Lehe tegi Hendrik Vallimägi</center>