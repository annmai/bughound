<!DOCTYPE html>

<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location:index.php");
		die();
	}
	else {
	   $name = $_SESSION['name'];
	   $userlevel = $_SESSION['userlevel'];
	}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to Bughound</title>
		<link rel="stylesheet" type="text/css" href="menu-style.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body id="main">
		<div id="header"><img src="img/dog.png" id="dog-pic"></div>
		<h1> Welcome to Bughound!</h1>
		<br>
		<h2>Main Menu</h2>

		<?php

			if($userlevel == 1) {
				echo "<div class='btn'><a href='newbug.php'>Enter New Bug</a></div>";
			}
			else {
				echo"<div class='btn'><a href='newbug_admin.php'>Enter New Bug</a></div>";
			}

			if($userlevel == 3 || $userlevel == 2) {
				echo "<div class='btn'><a href='bugs_search.php'>Update Existing Bug</a></div>";
			}

			if($userlevel == 3) {
				echo "<div class='btn'><a href='db-menu.php'>Database Maintenance</a></div>";
			}
		?>

		<br>
		<a href="logout.php"><div class="btn">Logout</div></a>
		<br><br>
		<div>User: <?php echo $_SESSION['name']; ?>  &nbsp;&nbsp;User Level: <?php echo $_SESSION['userlevel']; ?></div>
    </body>
</html>
