<?php
	require_once("hidden/functions.php");
	// kui kasutaja ei ole sisse logitud
	// siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	// kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		// kustutame kõik session muutujad ja peateme sessiooni
		session_destroy();
		
		header("Location: login.php");
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
	
	$password_current_error = "";
	$password_new_error = "";
	$password_new_again_error = "";
	$password_repear_error = "";
	
	$password_current = "";
	$password_new = "";
	$password_new_again = "";
	
	$id_from_db = $_SESSION["logged_in_user_id"];
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["changepw"])){
			
			if(empty($_POST["password_current"])){
				$password_current_error = "VEATEADE: Praegune parool on kohustuslik!";
			} else {
				$password_current = test_input($_POST["password_current"]);
			}
			if(empty($_POST["password_new"])){
				$password_new_error = "VEATEADE: Uus parool on kohustuslik!";
			} else {
				$password_new = test_input($_POST["password_new"]);
			}
			if(empty($_POST["password_new_again"])){
				$password_new_again_error = "VEATEADE: Uus parool on kohustuslik!";
			} else {
				$password_new_again = test_input($_POST["password_new_again"]);
			}
			if($_POST["password_new"] != $_POST["password_new_again"]){
				$password_repeat_error = "VEATEADE: Uued paroolid peavad kattuma!";
			}
			
			
			if($password_current_error == "" && $password_new_error == "" && $password_new_again_error == "" && $password_repear_error == ""){
				$newhash = hash("sha512", $password_new);
				$oldhash = hash("sha512", $password_current);
				changePass($newhash, $id_from_db, $oldhash);
				
				
			}
		}
		
		
	}
	
?>
<?php
	$page_title = "Muuda parooli";
	$page_file_name = "changepw.php";
?>
<div id="container">
<div id="header">
<div class="headerblock">
<?php require_once("header.php"); ?>
</div>
<div class="loginblockleft">
<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>" placeholder="Otsing">
	<input type="submit" value="Otsi">
</form>
</div>
<div class="loginblockright">
<div class="loginblockright">
<?php if(isset($_SESSION["logged_in_user_id"])){echo "<span class='login'>Teretulemast ".$_SESSION["logged_in_user_name"]."! <a href='?logout=1'>Logi välja</a><br>Krediit: ".$_SESSION["logged_in_user_credits"]."</span>"; 
} else { echo "<span class='login'><a href='login.php'>Logi sisse</a> / <a href='register.php'>Registreeri</a></span>"; } ?><br>
</div>
</div>
</div>
<div id="content" class="clearfix">
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
<h2>Muuda parooli</h2>
<form action="changepw.php" method="post">
	Praegune parool:<br>
	<input name="password_current" type="password" placeholder="Praegune parool"> <?php echo $password_current_error; ?><br>
	Uus parool:<br>
	<input name="password_new" type="password" placeholder="Parool"> <?php echo $password_new_error; ?><br>
	Uus parool uuesti:<br>
	<input name="password_new_again" type="password" placeholder="Parool uuesti"> <?php echo $password_new_again_error; ?><br><br>
	<input name="changepw" type="submit" value="Muuda parool"><br>
</form>
</div>
</div>
</div>
</div>
<br>
<center>Lehe tegi Hendrik Vallimägi</center>