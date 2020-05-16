<!DOCTYPE html>

<?php 
   	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] != 3){
		header("location:main.php");
	}
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // information sent from form
	  
	  $myid = $_GET["id"];
      
	  $con = mysqli_connect("localhost","root");
	  mysqli_select_db($con, "bughound");
	  
	  $myname = mysqli_real_escape_string($con,$_POST['name']);
      $myusername = mysqli_real_escape_string($con,$_POST['username']);
      $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
	  $myuserlevel = mysqli_real_escape_string($con,$_POST['userlevel']);
	  $con = mysqli_connect("localhost","root");
	  mysqli_select_db($con, "bughound");
	
	  $result = false;
	  
	  if(!empty($myname)) {
		  $query = "UPDATE employees SET name='$myname' WHERE emp_id = $myid";
		  $result = mysqli_query($con, $query);  
	  }
	  if(!empty($myusername)) {
		  $query = "UPDATE employees SET username='$myusername' WHERE emp_id = $myid";
		  $result = mysqli_query($con, $query); 
	  }
	  if(!empty($mypassword)) {
		  $query = "UPDATE employees SET password='$mypassword' WHERE emp_id = $myid";
		  $result = mysqli_query($con, $query); 
	  }
	  if(!empty($myuserlevel)) {
		  $query = "UPDATE employees SET userlevel='$myuserlevel' WHERE emp_id = $myid";
		  $result = mysqli_query($con, $query); 
	  }
	  
      if($result) {
		 $msg = "Employee was successfully updated.";
		 
      }
	  
   }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Edit Employee</title>
		
		<style>
			a:link {
			  text-decoration: none;
			  color: black;
			}

			a:visited {
			  text-decoration: none;
			  color: black;
			}

			a:hover {
			  text-decoration: none;
			  color: black;
			}

			a:active {
			  text-decoration: none;
			  color: black;
			}
		</style>
		
    </head>
    <body style="background-color:lightyellow;">
	<div style="border:1px solid black;">
		<h2 class="title">Edit Employee Record</h2>
		<br>
		<?php
			$myid = $_GET['id'];
			
			$con = mysqli_connect("localhost","root");
			mysqli_select_db($con, "bughound");
			$query = "SELECT * FROM employees WHERE emp_id=$myid";
			$result = mysqli_query($con, $query);
			$row = mysqli_fetch_row($result);
			$count = mysqli_num_rows($result);
			
			$myname = "";
			$myusername = "";
			$mypassword = "";
			$myuserlevel = "";
			
			if($count == 0) {
				Echo "<h3>No records found.</h3>\n";
			}
			else {
				$myname = $row[1];
				$myusername = $row[2];
				$mypassword = $row[3];
				$myuserlevel = $row[4];
			}
		?>
		<form action="" method="POST">
				<table style="margin-bottom:20px;">
                <tr><td>Name</td><td><input size="50" type="text" name="name" value="<?php echo $myname ?>"></td></tr>
                <tr><td>Username</td><td><input size="50" type="text" name="username" value="<?php echo $myusername ?>"></td></tr>
                <tr><td>Password</td><td><input size="50" type="text" name="password" value="<?php echo $mypassword ?>"></td></tr>
                </table>
			<label for="userlevel">User level: <?php echo $myuserlevel ?></label><br>
			<select name="userlevel">
			  <option label=""></option>
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			</select>
			<br><br>
			<button type="submit">Update</button> 
			<button><a href="edit-emp.php">Cancel</a></button>

			<p style="color:blue;"><?php 
					if(!empty($msg))
						echo $msg;
				?>
			</p>
		</form>
		
	</div>
	<br><br>
	<a href="db-menu.php" style="text-decoration:underline;">Back to Menu</a>
  
    </body>
</html>