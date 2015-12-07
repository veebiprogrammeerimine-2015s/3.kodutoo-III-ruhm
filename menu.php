<h2>Menüü</h2>
<ul>
	
	<?php if($page_file_name == "home.php"){ ?>
		<li>
			Home
		</li>
	<?php }else{ ?>
		<li>
			<a href="home.php">Home</a>
		</li>
	<?php } ?>
	
	<?php
		// Kontrollin mis lehega on tegu ja vastavalt kas trükin lingi või mitte
		
		if($page_file_name == "login.php"){
			echo '<li>Log in</li>';
		} else {
			echo '<li><a href="login.php">Log in</a></li>';
		}
	?>
	
	
</ul>