<?php 
	require_once("hidden/functions.php");

?>
<h2>Menüü</h2>
<ul>
	<?php if($page_file_name == "index.php"){
			echo '<li>Avaleht</li>';
		} else {
			echo '<li><a href="index.php">Avaleht</a></li>';
		} ?>
	<?php if($page_file_name == "jackpot.php"){
		echo '<li>Mängi jackpoti</li>';
	} else {
		echo '<li><a href="jackpot.php">Mängi jackpoti</a></li>';
	} ?>
</ul>