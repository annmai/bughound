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

    if(isset($_POST['search'])){
      $criteria = array();
      if($_POST['program'] != 'all'){
        array_push($criteria, "prog_id", $_POST['program']);
      }
      if($_POST['report_type'] != 'all'){
        array_push($criteria, "report_type", "'".$_POST['report_type']."'");
      }
      if($_POST['severity'] != 'all'){
        array_push($criteria, "severity", "'".$_POST['severity']."'");
      }
      if($_POST['functional_area'] != 'all'){
        array_push($criteria, "functional_area", "'".$_POST['functional_area']."'");
      }
      if($_POST['assigned_to'] != 'all'){
        array_push($criteria, "assigned_to", $_POST['assigned_to']);
      }
      if($_POST['reported_by'] != 'all'){
        array_push($criteria, "reported_by", $_POST['reported_by']);
      }
      if($_POST['status'] != 'all'){
        array_push($criteria, "status", "'".$_POST['status']."'");
      }
      if($_POST['priority'] != 'all'){
        array_push($criteria, "priority", "'".$_POST['priority']."'");
      }
      if($_POST['resolution'] != 'all'){
        array_push($criteria, "resolution", "'".$_POST['resolution']."'");
      }

      $query = "SELECT * FROM bugs";
      if(count($criteria) >= 2) {
        $query = $query . " WHERE " . $criteria[0] . "=" . $criteria[1];
        for($i = 2; $i < count($criteria); $i = $i + 2){
          $query = $query . " AND " . $criteria[$i] . "=" . $criteria[$i+1];
        }
      }
      $result = mysqli_query($con, $query);
    }
    else {
      header("location:main.php");
    }
  }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Search Result</title>
    </head>
    <body style="background-color: #00ffff;">
      <h2>Your search yielded...</h2>
      <table border=1>
        <tr>
          <th>Bug ID</th>
          <th>Program</th>
          <th>Summary</th>
        </tr>
        <?php
        while($row=mysqli_fetch_row($result)) {
          $prog_result = mysqli_query($con, "SELECT * FROM programs WHERE prog_id=".$row[1]);
          $prog_row = mysqli_fetch_row($prog_result);
          printf("<tr><td><button onclick='update(this)'>%d</button></td><td>%s v%d.%d</td><td>%s</td></tr>", $row[0], $prog_row[1], $prog_row[2], $prog_row[3], $row[5]);
        }
        ?>
      </table>
      <button onclick="backToSearch()" style="margin-top: 20px;">Cancel</button>
    </body>
    <script>
      function update(element) {
        var c1 = "update_bug.php?bug_id=";
        var c2 = element.innerHTML;
        window.location.replace(c1.concat(c2));
      }

      function backToSearch() {
        window.location.replace("bugs_search.php");
      }
    </script>
</html>
