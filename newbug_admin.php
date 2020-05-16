<!DOCTYPE html>

<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['userlevel'] == 1){
		header("location:index.php");
		die();
	}
	
	if(isset($_POST['submit'])) {
		
		$con = mysqli_connect("localhost","root");
        mysqli_select_db($con, "bughound");
		
		$programID = mysqli_real_escape_string($con, $_POST['program']);
        $reportType = mysqli_real_escape_string($con, $_POST['report_type']);
		$severity = mysqli_real_escape_string($con, $_POST['severity']);
        $summary = mysqli_real_escape_string($con, $_POST['summary']);
        $reproducible = isset($_POST['reproducible']);
        $problem = mysqli_real_escape_string($con, $_POST['problem']);
        $suggestedFix = mysqli_real_escape_string($con, $_POST['suggested_fix']);
        $reportedByID = mysqli_real_escape_string($con, $_POST['reported_by']);
        $discoverDate = mysqli_real_escape_string($con, $_POST['date']);
		
		$functionalArea = mysqli_real_escape_string($con, $_POST['area']);
		$deferred = isset($_POST['deferred']);
		$comments = mysqli_real_escape_string($con, $_POST['comments']);
		$status = mysqli_real_escape_string($con, $_POST['status']);
		$priority = mysqli_real_escape_string($con, $_POST['priority']);
		$resolution = mysqli_real_escape_string($con, $_POST['resolution']);
		$version = mysqli_real_escape_string($con, $_POST['version']);
		$resolvedDate = mysqli_real_escape_string($con, $_POST['resolved_date']);
		$testedDate = mysqli_real_escape_string($con, $_POST['tested_date']);

		$resolvedBy = mysqli_real_escape_string($con, $_POST['resolved_by']);
		$testedBy = mysqli_real_escape_string($con, $_POST['tested_by']);
		$AssignedTo = mysqli_real_escape_string($con, $_POST['assigned_to']);
		
		$query = "INSERT INTO bugs (
                  prog_id, reported_by, report_type, severity, summary, problem, reproducible,
                  discover_date, suggested_fix, functional_area, resolution, resolved_by,
				  resolved_date, tested_by, tested_date, deferred, status, version, priority,
				  assigned_to, comments)
                  VALUES ('".$programID."','".$reportedByID."','".$reportType."','".$severity."',
				  '".$summary."','".$problem."','".$reproducible."','".$discoverDate."','".$suggestedFix."',
				  '".$functionalArea."','".$resolution."',$resolvedBy,'".$resolvedDate."',$testedBy,
				  '".$testedDate."','".$deferred."','".$status."','".$version."',
				  '".$priority."',$AssignedTo,'".$comments."')";
		
		$result = mysqli_query($con, $query);
		
        if(!$result){
			echo '<script>alert("Error: Bug Report not added." .mysqli_error($con))</script>';
        }
		else{
			echo '<script>alert("Success! New Bug Report Added.")</script>';
		}
		
		$bugID = mysqli_insert_id($con);
		
		//handle uploaded files
		if(is_uploaded_file($_FILES['files']['tmp_name'][0])){
							  		
			$numFiles = count($_FILES['files']['name']);
			
			// Loop through all files
			for($i=0; $i < $numFiles; $i++){
				
				$filename = $_FILES['files']['name'][$i];
				$filename = mysqli_real_escape_string($con,$filename);
							
				// Upload file
				move_uploaded_file($_FILES['files']['tmp_name'][$i],'uploads/'.$filename);
				$query = "INSERT INTO files (name, bug_id) VALUES ('$filename', '$bugID')";
				
				if(!mysqli_query($con, $query)){
					echo("Error: " .mysqli_error($con));
				};
			}
		}

	}
	
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound Enter a New Bug</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
		
		<style>
			body {
				background-color: gray;
			}
		</style>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
		
    </head>
    <body>
		<h1>New Bug Report Entry</h1>
		<br>

		<form action="newbug_admin.php" id="newbugform_admin" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
			<label for="program">Program: </label>
			<select id="program" name="program" onchange="getAreas(this.value)">
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT * FROM programs";
                    $result = mysqli_query($con, $query);
					$firstResult = $result->fetch_assoc();
					$prog_id = $firstResult['prog_id'];
					$result = mysqli_query($con, $query);
					
                    while($row=$result->fetch_assoc()) {
                        $id = $row['prog_id'];
                        $name = $row['program'];
						$name .= ' v';
						$name .= $row['program_release'];
						$name .= '.';
						$name .= $row['program_version'];
                        echo "<option value=".$id.">" . $name . "</option>";
					}
				?>
			</select>
			<label for="report_type">Report Type: </label>
			<select name="report_type">
				<option value="Coding Error">Coding Error</option>
				<option value="Design Issue">Design Issue</option>
				<option value="Suggestion">Suggestion</option>
				<option value="Documentation">Documentation</option>
				<option value="Hardware">Hardware</option>
				<option value="Query">Query</option>
			</select>
			<label for="severity">Severity: </label>
			<select name="severity">
				<option value="Minor">Minor</option>
				<option value="Serious">Serious</option>
				<option value="Fatal">Fatal</option>
			</select>
			<br><br>
			<label for="summary">Problem Summary: </label>
			<input type="text" name="summary" size="65">
			<label for="reproducible">Reproducible? </label>
			<input type="checkbox" name="reproducible" value="yes">
			<br><br>
			<label for="problem">Problem: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<textarea rows="2" cols="90" name="problem" form="newbugform_admin"></textarea>
			<br><br>
			<label for="suggested_fix">Suggested Fix: </label>
			<textarea rows="2" cols="90" name="suggested_fix" form="newbugform_admin"></textarea>
			<br><br>
			<label for="reported_by">Reported By: </label>
			<select id="reported_by" name="reported_by">
			<option value="NULL"></option>
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        $id = $row['emp_id'];
                        $name = $row['name'];
                        echo "<option value=".$id.">" . $name . "</option>";
					}
				?>
			</select>
			<label for="date">Date: </label>
			<input type="date" name="date">
			<p></p><hr><p></p>

			<label for="area">Functional Area: </label>
			<select id="area" name="area">
			<option value=""></option>
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT area FROM areas WHERE prog_id = $prog_id";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        $name = $row['area'];
                        echo "<option value=".$name.">" . $name . "</option>";
					}
				?>
			</select>
			<label for="assigned_to">Assigned To: </label>
			<select id="assigned_to" name="assigned_to">
			<option value="NULL"></option>
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        $id = $row['emp_id'];
                        $name = $row['name'];
                        echo "<option value=".$id.">" . $name . "</option>";
					}
				?>
			</select>
			<label for="deferred">Treat as deferred? </label>
			<input type="checkbox" name="deferred" value="yes">
			<br><br>
			<label for="comments">Comments: </label>
			<textarea rows="2" cols="92" name="comments" form="newbugform_admin"></textarea>
			<br><br>
			<label for="status">Status: </label>
			<select id="status" name="status">
			<option value="open">Open</option>
			<option value="closed">Closed</option>
			<option value="closed">Resolved</option>
			</select>
			<label for="priority">Priority: </label>
			<select id="priority" name="priority">
			<option value=""></option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			</select>
			<label for="resolution">Resolution: </label>
			<select id="resolution" name="resolution">
			<option value=""></option>
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
			<label for="version">Resolution version: </label>
			<input id="version" type="text" name="version">
			<br><br>
			<label for="resolved_by">Resolved by: </label>
			<select id="resolved_by" name="resolved_by">
			<option value="NULL"></option>
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        $id = $row['emp_id'];
                        $name = $row['name'];
                        echo "<option value=".$id.">" . $name . "</option>";
					}
				?>
			</select>
			<label for="resolved_date">Date: </label>
			<input type="date" name="resolved_date">
			<label for="tested_by">Tested by: </label>
			<select id="tested_by" name="tested_by">
			<option value="NULL"></option>
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        $id = $row['emp_id'];
                        $name = $row['name'];
                        echo "<option value=".$id.">" . $name . "</option>";
					}
				?>
			</select>
			<label for="tested_date">Date: </label>
			<input type="date" name="tested_date">
			
			
			
			<br><br>
			<label for="files">Attachment(s): </label>
			<input type="file" name="files[]" id="files" multiple="">	
			<br><br>
			<input type="submit" name="submit" value="Submit">
            <input type="reset" value="Reset">
            <input type="button" name="cancel" value="Cancel" onclick="goToMain()">
		</form>
		
		<Br><br>
		
		<script language=Javascript>

            function validate(form) {			
                if(form.summary.value.length == 0){
                    alert ("Problem Summary cannot be blank.");
                    return false;
                }
                if(form.problem.value.length == 0){
                    alert ("Problem field cannot be blank.");
                    return false;
                }
				if(!form.date.value){
                    alert ("Date cannot be blank.");
                    return false;
                }
				if(form.reported_by.value == "NULL"){
                    alert ("Reported By cannot be blank.");
                    return false;
                }
                return true;
            }
			
			function getAreas(programID) {
				
				$.ajax({
					url: 'get_areas.php',
					type: 'POST',
					data: {prog_id : programID},
					success: function(data) {
						var collection = jQuery.parseJSON(data);
						
						$("#area").empty();
						var first = true;
						
						$.each(collection, function(key,value) {
							if(!first)
								$('#area').append('<option value="'+value+'">'+value+'</option>');
							else
								$('#area').append('<option value=""></option>');
								
							first = false;
						});
					}
				});
								
			}
			
			function goToMain() {
                window.location.replace("main.php");
            }
			
            function reset() {
                window.location.reload(true);
            }
		</script>

    </body>
</html>