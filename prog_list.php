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
        echo "<h2>Select a Prgram to Edit/Delete</h2>";
        echo "<table border=1>\n";
        echo "<tr><th>ID</th><th>Program</th><th>Release</th><th>Version</th></tr>";
        while($row=mysqli_fetch_row($result)) {
            printf("<tr><td>%d</td><td>%s</td><td>%d</td><td>%d</td><td><button onclick='edit(this)'>Edit</button></td><td><form onsubmit='return confirm_delete()' method='post'><input type='submit' value='Delete'><input type='hidden' name='prog_id' value='%d'><input type='hidden' name='prog_name' value='%s'></form></td></tr>", $row[0], $row[1], $row[2], $row[3], $row[0], $row[1]);
        }
        echo "</table>";

        // delete button clicked
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $prog_id = $_POST['prog_id'];
            $prog_name = $_POST['prog_name'];

            // delete corresponding areas
            $result = mysqli_query($con, "SELECT area_id FROM areas WHERE prog_id=$prog_id");
            while($area_id = mysqli_fetch_row($result)) {
                mysqli_query($con, "DELETE FROM areas WHERE area_id=".$area_id[0]);
            }

            // delete the program
            mysqli_query($con, "DELETE FROM programs WHERE prog_id=$prog_id");

            header("Refresh:0");
        }
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Program List</title>
    </head>
    <body style="background-color:#CBFBDD;">
    <a href="db-menu.php">Back to Menu</a>
    <script>
        function go_home() {
            window.location.replace("db-menu.php");
        }

        function confirm_delete() {
            return confirm("Do you want to delete this program?");
        }

        function edit(element) {
            localStorage["prog_id"] = element.closest("tr").cells[0].innerHTML;
            localStorage["prog_name"] = element.closest("tr").cells[1].innerHTML;
            localStorage["prog_release"] = element.closest("tr").cells[2].innerHTML;
            localStorage["prog_version"] = element.closest("tr").cells[3].innerHTML;
            window.location.replace("edit_prog.php");
        }
    </script>
    </body>
</html>