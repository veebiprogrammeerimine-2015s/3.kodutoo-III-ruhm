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
	
?>
<?php
	$page_title = "Minu konto";
	$page_file_name = "data.php";
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
<h2>Seaded</h2>
<p>
<table>
	<tr>
		<td>Kasutajanimi: </td>
		<?php echo "<td>".$_SESSION['logged_in_user_username']."</td>"; ?>
	</tr>
	<tr>
		<td>Krediit: </td>
		<?php echo "<td>".$_SESSION['logged_in_user_credits']."</td>"; ?>
	<tr>
	<tr>
		<td>Eesnimi: </td>
		<?php echo "<td>".$_SESSION['logged_in_user_name']."</td>"; ?>
	</tr>
	<tr>
		<td>Email: </td>
		<?php echo "<td>".$_SESSION['logged_in_user_email']."</td>"; ?>
	<tr>
	<tr>
		<td>Vanus: </td>
		<?php echo "<td>".$_SESSION['logged_in_user_age']."</td>"; ?>
	</tr>
	<tr>
		<td>Kasutaja loodi: </td>
		<?php echo "<td>".$_SESSION['logged_in_user_created']."</td>"; ?>
	</tr>
</table>
<br>
<a href="changepw.php">Muuda parooli</a><br>
</p>
</div>
</div>
</div>
</div>
<br>
<center>Lehe tegi Hendrik Vallimägi</center>