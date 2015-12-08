
<h2>menüü</h2>
<ul>

	<?php if($page_file_name == "page/home.php"){ ?>
	<li>
		Home
	</li>
	<?php } else { ?>
	<li>
		<a href="home.php">Home</a>
	</li>
	<?php } ?>
	
	<?php if($page_file_name == "page/data.php"){ ?>
	<li>
		Data
	</li>
	<?php } else { ?>
	<li>
		<a href="data.php">Data</a>
	</li>
	<?php } ?>
	
	<?php if($page_file_name == "page/table.php"){ ?>
	<li>
		Tabel
	</li>
	<?php } else { ?>
	<li>
		<a href="table.php">Tabel</a>
	</li>
	<?php } ?>
	
	<?php
	//kontrollin mis lehega on tegu ja vastavalt kas trükin lingi või mitte
		if($page_file_name == "page/login.php"){
			echo '<li>Login</li>';
		}else{
			echo '<li><a href="login.php">Login</a></li>';
		}
	?>
	<p>
	Tere,
	<?php 
		if($page_file_name == "page/login.php"){
			echo "";
		}else{
			echo $_SESSION["logged_in_user_email"];?><a href="?logout=1"> Logi välja <a><?php
		}
	?>
	
</p>
</ul>