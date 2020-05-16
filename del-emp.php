<!DOCTYPE html>

<?php 
    session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] != 3){
		header("location:main.php");
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = $_POST["myid"];
		$con = mysqli_connect("localhost","root");
		mysqli_select_db($con, "bughound");
		$query = "DELETE FROM employees WHERE emp_id=$id";
		$result = mysqli_query($con, $query);
	}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Delete Employee</title>
		
		<style>
			a:link {
			  text-decoration: none;
			  color: blue;
			}

			a:visited {
			  text-decoration: none;
			  color: purple;
			}

			a:hover {
			  text-decoration: underline;
			  color: blue;
			}

			a:active {
			  text-decoration: none;
			  color: black;
			}
		</style>
		
    </head>
    <body style="background-color:#CBFBDD;">
	<div style="border:1px solid black;">
		<h2 class="title">Delete Employee Record</h2>
		<?php
			$con = mysqli_connect("localhost","root");
			mysqli_select_db($con, "bughound");
			$query = "SELECT * FROM employees";
			$result = mysqli_query($con, $query);

            echo "<table border=1 ><th>ID</th><th>Name</th><th> Username</th><th>User Level</th>\n";
            $none = 0;
            while($row=mysqli_fetch_row($result)) {
                $none=1;
				$myid = $row[0];
				$myname = $row[1];
                printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%d</td><td><button onclick='getConfirmation($myid)'>delete</button></td></tr>\n",$row[0],$row[1],$row[2],$row[4]);
            }
   
        ?>
        </table>
        <?php
            if($none==0)
		Echo "<h3>No records found.</h3>\n";
        ?>
		
	</div>
	<br><br>
	<a href="db-menu.php" style="text-decoration:underline;">Back to Menu</a>
  
          <script language=Javascript>
            function getConfirmation(id) {
                if(confirm("Confirmation Requried.\nDelete employee with id " + id + "?")) {
					form = document.createElement('form');
					form.setAttribute('method', 'POST');
					form.setAttribute('action', 'del-emp.php');
					myvar = document.createElement('input');
					myvar.setAttribute('name', 'myid');
					myvar.setAttribute('type', 'hidden');
					myvar.setAttribute('value', id);
					form.appendChild(myvar);
					document.body.appendChild(form);
					form.submit(); 
				}
				else {
					window.location.replace("del-emp.php");
				}
            }
		</script>

    </body>
</html>