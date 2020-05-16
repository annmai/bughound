<!DOCTYPE html>

<?php
	session_start();
	if(!isset($_SESSION['user'])){
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
		
		$query = "INSERT INTO bugs (
                  prog_id, reported_by, report_type, severity, summary, problem, reproducible,
                  discover_date, suggested_fix, status)
                  VALUES ('".$programID."','".$reportedByID."','".$reportType."','".$severity."',
				  '".$summary."','".$problem."','".$reproducible."','".$discoverDate."','".$suggestedFix."', 'open')";
		
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
    </head>
    <body>
		<h1>New Bug Report Entry</h1>
		
		<form action="newbug.php" id="newbugform" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
			<label for="program">Program: </label>
			<select id="program" name="program">
				<?php
					$con = mysqli_connect("localhost","root");
					mysqli_select_db($con, "bughound");
					$query = "SELECT * FROM programs";
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
			<input type="text" name="summary" size="54">
			<label for="reproducible">Reproducible? </label>
			<input type="checkbox" name="reproducible" value="yes">
			<br><br>
			<label for="problem">Problem: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<textarea rows="2" cols="80" name="problem" form="newbugform"></textarea>
			<br><br>
			<label for="suggested_fix">Suggested Fix: </label>
			<textarea rows="2" cols="80" name="suggested_fix" form="newbugform"></textarea>
			<br><br>
			<label for="reported_by">Reported By: </label>
			<select id="reported_by" name="reported_by">
			<option value="default"></option>
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
			<br><br>
			<label for="files">Attachment(s): </label>
			<input type="file" name="files[]" id="files" multiple="">	
			<br><br>
			<input type="submit" name="submit" value="Submit">
            <input type="reset" value="Reset">
            <input type="button" name="cancel" value="Cancel" onclick="goToMain()">
		</form>
		
		<Br><br>
		<hr>
		
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
				if(form.reported_by.value == "default"){
                    alert ("Reported By cannot be blank.");
                    return false;
                }
                return true;
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