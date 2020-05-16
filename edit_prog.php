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

        $user = $_SESSION['user'];
        $name = $_SESSION['name'];
        $userlevel = $_SESSION['userlevel'];

        // form button clicked
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $prog_id = $_POST['prog_id'];
            $prog_name = $_POST['prog_name'];
            $prog_release = $_POST['prog_release'];
            $prog_version = $_POST['prog_version'];

            // submit button clicked
            if(isset($_POST['submit'])) {
                // validate
                if($prog_name == null or $prog_release == null or $prog_version == null) {
                    echo "<script>alert('Error: All blanks have to be filled!');</script>";
                } else {
                    // update database
                    $query = "UPDATE programs SET program="."'$prog_name'".", program_release=$prog_release, program_version=$prog_version WHERE prog_id=$prog_id";
                    mysqli_query($con, $query);

                    // back to program list page
                    $_SESSION['user'] = $user;
                    $_SESSION['name'] = $name;
                    $_SESSION['userlevel'] = $userlevel;
                    header("location: prog_list.php");
                }
            }
            else {
              // back to program list page
              $_SESSION['user'] = $user;
              $_SESSION['name'] = $name;
              $_SESSION['userlevel'] = $userlevel;
              header("location: prog_list.php");
            }
        }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Edit Program</title>
    </head>
    <body style="background-color:lightyellow;">
        <div style="border:1px solid black;">
            <h2>Edit Program Record</h2>
            <form action="" method="POST" onsubmit="return validate(this)">
                <table style="margin-bottom:20px;">
                <tr><td>Program Name</td><td><input id="name_input" type="text" name="prog_name"></td></tr>
                <tr><td>Program Release</td><td><input id="release_input" type="number" name="prog_release"></td></tr>
                <tr><td>Program Version</td><td><input id="version_input" type="number" name="prog_version"></td></tr>
                </table>
                <input type="submit" name="submit" value="Submit" style="margin-right:5px;">
                <button>Cancel</button>
                <input id="id_input" type="hidden" name="prog_id" value="9999">
            </form>
        </div>
        <script>
            document.getElementById("id_input").value = localStorage["prog_id"];
            document.getElementById("name_input").value = localStorage["prog_name"];
            document.getElementById("release_input").value = localStorage["prog_release"];
            document.getElementById("version_input").value = localStorage["prog_version"];
        </script>
    </body>
</html>
