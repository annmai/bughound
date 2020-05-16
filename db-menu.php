<!DOCTYPE html>

<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] != 3){
		header("location:main.php");
	}
	else {
	   $name = $_SESSION['name'];
	}
	
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Database Maintenance - Menu</title>
		<link rel="stylesheet" type="text/css" href="menu-style.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
		<div id="header"><img src="img/dog.png" id="dog-pic"></div>
		<h4> User: <?php echo $_SESSION['name']; ?>  &nbsp;&nbsp;User Level: <?php echo $_SESSION['userlevel']; ?></h4>
		
		<h2>Database Maintenance</h2>
		<div class="btn"><a href="editAreas.php">Add/Edit Areas</a></div>
		<div class="btn"><a href="add_prog.php">Add Programs</a></div>
		<div class="btn"><a href="prog_list.php">Edit/Delete Programs</a></div>
		<div class="btn"><a href="add-emp.php">Add Employees</a></div>
		<div class="btn"><a href="edit-emp.php">Edit/Delete Employees</a></div>
		<div class="btn"><a href="export.php">Export</a></div>
		<br>
		<a href="logout.php"><div class="btn">Logout</div></a>
		
    </body>
</html>