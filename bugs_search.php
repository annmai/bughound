<!DOCTYPE html>

<?php
  session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] == 1){
		header("location:main.php");
	}
  else {
    // Connect to database
    $con = mysqli_connect("localhost","root");
    mysqli_select_db($con, "bughound");
  }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Search Bugs</title>
    </head>
    <body style="background-color: rgb(252,207,74);">
      <h2>Bug Search Page</h2>
      <form action="search_result.php" method="post">
        <table>
          <tr>
            <td>Program</td>
            <td>
              <select name="program" onchange="selectArea(this)" id="select_prog">
                <option value="all">All</option>
                <?php
                  $result = mysqli_query($con, 'SELECT * FROM programs');
                  while($row=mysqli_fetch_row($result)) {
                      printf("<option value='%d'>%s v%d.%d</option>", $row[0], $row[1], $row[2], $row[3]);
                  }
                ?>
              </select>
              <?php 
                $prog_id = 0;
                if(isset($_GET['selected_prog'])){
                  if($_GET["selected_prog"] != "all"){
                    $prog_id = $_GET["selected_prog"];
                    echo "<script>document.getElementById('select_prog').selectedIndex=".$_GET["prog_index"].";</script>";
                  }
                }
              ?>
            </td>
          </tr>
          <tr>
            <td>Report Type</td>
            <td>
              <select name="report_type">
                <option value="all">All</option>
        				<option value="Coding Error">Coding Error</option>
        				<option value="Design Issue">Design Issue</option>
        				<option value="Suggestion">Suggestion</option>
        				<option value="Documentation">Documentation</option>
        				<option value="Hardware">Hardware</option>
        				<option value="Query">Query</option>
        			</select>
            </td>
          </tr>
          <tr>
            <td>Severity</td>
            <td>
              <select name="severity">
                <option value="all">All</option>
        				<option value="Minor">Minor</option>
        				<option value="Serious">Serious</option>
        				<option value="Fatal">Fatal</option>
        			</select>
            </td>
          </tr>
          <tr>
            <td>Functional Area</td>
            <td>
              <select class="" name="functional_area">
                <option value="all">All</option>
                <?php
                  $result = mysqli_query($con, 'SELECT DISTINCT area FROM areas');
                  if($prog_id != 0){
                    $result = mysqli_query($con, 'SELECT area FROM areas WHERE prog_id='.$prog_id);
                  }
                  while($row=mysqli_fetch_row($result)) {
                      printf("<option value='%s'>%s</option>", $row[0], $row[0]);
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Assigned To</td>
            <td>
              <select class="" name="assigned_to">
                <option value="all">All</option>
                <?php
                  $result = mysqli_query($con, 'SELECT * FROM employees');
                  while($row=mysqli_fetch_row($result)) {
                      printf("<option value='%d'>%s</option>", $row[0], $row[1]);
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Reported By</td>
            <td>
              <select class="" name="reported_by">
                <option value="all">All</option>
                <?php
                  $result = mysqli_query($con, 'SELECT * FROM employees');
                  while($row=mysqli_fetch_row($result)) {
                      printf("<option value='%d'>%s</option>", $row[0], $row[1]);
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <select name="status">
          			<option value="open">Open</option>
          			<option value="closed">Closed</option>
          			<option value="closed">Resolved</option>
        			</select>
            </td>
          </tr>
          <tr>
            <td>Priority</td>
            <td>
              <select id="priority" name="priority">
          			<option value="all">All</option>
          			<option value="1">1</option>
          			<option value="2">2</option>
          			<option value="3">3</option>
          			<option value="4">4</option>
          			<option value="5">5</option>
          			<option value="6">6</option>
        			</select>
            </td>
          </tr>
          <tr>
            <td>Resolution</td>
            <td>
              <select name="resolution">
          			<option value="all">All</option>
          			<option value="Pending">Pending</option>
          			<option value="Fixed">Fixed</option>
          			<option value="Irreproducible">Irreproducible</option>
          			<option value="Deferred">Deferred</option>
          			<option value="As designed">As designed</option>
          			<option value="Withdrawn by reporter">Withdrawn by reporter</option>
          			<option value="Need more info">Need more info</option>
          			<option value="Disagree with suggestion">Disagree with suggestion</option>
          			<option value="Duplicate">Duplicate</option>
        			</select>
            </td>
          </tr>
        </table>
        <input type="submit" name="search" value="Search">
        <input type="reset" name="reset" value="Reset">
        <input type="submit" name="cancel" value="Cancel">
      </form>
      <form action="" method="get" id="hiddenForm">
        <input type="hidden" name="selected_prog" id="selected_prog">
        <input type="hidden" name="prog_index" id="prog_index">
      </form>
    </body>
    <script>
      function selectArea(prog) {
        document.getElementById("selected_prog").value = prog.value;
        document.getElementById("prog_index").value = prog.selectedIndex;
        document.getElementById("hiddenForm").submit();
      }
    </script>
</html>
