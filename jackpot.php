<?php
	require_once("hidden/functions.php");
	
?>
<?php
	$page_title = "Mängi jackpoti";
	$page_file_name = "jackpot.php";
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
<h2>Mängi jackpoti</h2>
<?php if(isset($_SESSION["logged_in_user_id"])){
	echo "Sul on hetkel ".$_SESSION["logged_in_user_credits"]. " krediiti!";
} else {
	echo "<a href='login.php'>Logi sisse</a>, et jackpoti mängida!";
}
?>
</div>
</div>
</div>
</div>
<br>
<center>Lehe tegi Hendrik Vallimägi</center>