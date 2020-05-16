<!DOCTYPE html>

<?php 
    session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] != 3){
		header("location:main.php");
	}
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // information sent from form
      
	  $con = mysqli_connect("localhost","root");
	  mysqli_select_db($con, "bughound");
	  
	  $myname = mysqli_real_escape_string($con,$_POST['name']);
      $myusername = mysqli_real_escape_string($con,$_POST['username']);
      $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
	  $myuserlevel = mysqli_real_escape_string($con,$_POST['userlevel']);
	  
	  $query1 = "SELECT * FROM employees WHERE username = '$myusername'";
      $result1 = mysqli_query($con, $query1);
      $count = mysqli_num_rows($result1);
	  $result = false;
	  
	  if($count == 0){
		  $query2 = "INSERT INTO employees (name, username, password, userlevel) VALUES ('".$myname."','".$myusername."','".$mypassword."','".$myuserlevel."')";
		  $result = mysqli_query($con, $query2);
	  }
	  else {
		  $dup = " Username already exists.";
	  }
	
      if($result) {
		 $msg = "Employee was successfully added.";
		 
      }else {
         $error = "Error: Employee was not added.";
		 $error = $error.$dup;
      }
   }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Add Employee</title>
		
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
    <body style="background-color:powderblue;">
	<div style="border:1px solid black;">
		<h2 class="title">Add Employee</h2>
		<br>
		
		<form action="" method="POST" onsubmit="return validate(this)">
			<label for="name">Name: </label><br>
			<input type="text" name="name" size="50" placeholder="Enter Name"></input>
			<br><br>
			<label for="username">Username: </label><br>
			<input type="text" name="username" size="50" placeholder="Enter Username"></input>
			<br><br>
			<label for="password">Password: </label><br>
			<input type="text" name="password" size="50" placeholder="Enter Password"></input>
			<br><br>
			<label for="userlevel">User level: </label><br>
			<select name="userlevel">
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			</select>
			<br><br>
			<button type="submit">Submit</button> 
			<button type="cancel"><a href="add-emp.php">Cancel</a></button>
			<p style="color:#FF3361;"><?php 
					if(!empty($error))
						echo $error;
				?>
			</p>
			<p style="color:blue;"><?php 
					if(!empty($msg))
						echo $msg;
				?>
			</p>
		</form>
	</div>
	<br><br>
	<a href="db-menu.php" style="text-decoration:underline;">Back to Menu</a>
	
	        <script language=Javascript>
				function validate(theform) {
					if(theform.name.value === ""){
						alert ("Name cannot be blank.");
						return false;
					}
					if(theform.username.value === ""){
						alert ("Username cannot be blank.");
						return false;
					}
					if(theform.password.value === ""){
						alert ("Password cannot be blank.");
						return false;
					}
					if(theform.userlevel.value === ""){
						alert ("A User level must be selected.");
						return false;
					}
					return true;
				}
			</script>
  
    </body>
</html>