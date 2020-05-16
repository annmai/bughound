<!DOCTYPE html>

<?php
    session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] != 3){
		header("location:main.php");
	}
    else {
        // Connect to database
        $con = mysqli_connect("localhost","root");
        mysqli_select_db($con, "bughound");

        // Display all current programs
        $result = mysqli_query($con, 'SELECT * FROM programs');
        echo "<h2>Program List</h2>";
        echo "<table border=1>\n";
        while($row=mysqli_fetch_row($result)) {
            printf("<tr><td>%s</td><td>%d</td><td>%d</td></tr>", $row[1], $row[2], $row[3]);
        }
        echo "</table>";

        $user = $_SESSION['user'];
        $name = $_SESSION['name'];
        $userlevel = $_SESSION['userlevel'];

        // form button clicked
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $prog_name = $_POST['prog_name'];
            $prog_release = $_POST['prog_release'];
            $prog_version = $_POST['prog_version'];

            // submit button clicked
            if(isset($_POST['submit'])){
                // validate
                if($prog_name == null or $prog_release == null or $prog_version == null) {
                    echo "<script>alert('Error: All blanks have to be filled!');</script>";
                } else {
                    // insert into database
                    $query = "INSERT INTO programs (program, program_release, program_version) VALUES ('".$prog_name."'," .$prog_release."," .$prog_version.")";
                    mysqli_query($con, $query);

                    // back to menu
                    $_SESSION['user'] = $user;
                    $_SESSION['name'] = $name;
                    $_SESSION['userlevel'] = $userlevel;
                    header("location: db-menu.php");
                }
            }
            else {
              // back to menu
              $_SESSION['user'] = $user;
              $_SESSION['name'] = $name;
              $_SESSION['userlevel'] = $userlevel;
              header("location: db-menu.php");
            }
        }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Add Program</title>
    </head>
    <body style="background-color:powderblue;">
        <div style="border:1px solid black; padding:10px; margin-top:20px;">
            <h2>Add Program</h2>
            <form action="" method="post"">
                <table style="margin-bottom:20px;">
                    <tr><td>Program Name</td><td><input type="text" name="prog_name"></td></tr>
                    <tr><td>Program Release</td><td><input type="number" name="prog_release"></td></tr>
                    <tr><td>Program Version</td><td><input type="number" name="prog_version"></td></tr>
                </table>
                <input type="submit" name="submit" value="Submit" style="margin-right:5px;">
                <button>Cancel</button>
            </form>
        </div>
    </body>
</html>
