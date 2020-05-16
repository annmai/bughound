<!DOCTYPE html>

<?php
 ob_start();
  session_start();
    if(!isset($_SESSION['user']) || $_SESSION['userlevel'] == 1){
        header("location:main.php");

    }
	
	$user = $_SESSION['user'];
    $name = $_SESSION['name'];
    $userlevel = $_SESSION['userlevel'];

    

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound Update a Bug</title>
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
        <h1>Update Bug Report Entry</h1>

        <br>

		<?php

			if(!$_GET['bug_id'])
				header("location:main.php");
				
		?>


        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
            <label for="program">Program: </label>
            <select id="program" name="program" onchange="getAreas(this.value)">
                <?php

                    $bug_id = $_GET['bug_id'];

                    $con = mysqli_connect("localhost","root");
                    mysqli_select_db($con, "bughound");

                    $query = "SELECT * FROM bugs WHERE bug_id = $bug_id";
                    $result = mysqli_query($con, $query);
                    $all_results=$result->fetch_assoc();
					$prog_id = $all_results['prog_id'];

                    $query = "SELECT * FROM programs";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        $id = $row['prog_id'];
                        $name = $row['program'];
                        $name .= ' v';
                        $name .= $row['program_release'];
                        $name .= '.';
                        $name .= $row['program_version'];
                        if(strcasecmp($id, $all_results['prog_id']) == 0)
                            echo "<option selected=\"selected\" value=".$id.">" . $name . "</option>";
                        else
                            echo "<option value=".$id.">" . $name . "</option>";
                    }
                ?>

            </select>


            <label for="report_type">Report Type: </label>
            <select name="report_type">
                <?php
                   $types = array("Coding Error", "Design Issue", "Suggestion", 'Documentation', 'Hardware', 'Query' );
                    for($i=0, $len=count($types); $i<$len; $i++)
                    {   
                        if(strcasecmp($types[$i], $all_results['report_type']) == 0)
                            echo "<option selected = \"selected\" value=\"{$types[$i]}\">{$types[$i]}</option>";
                        else
                            echo "<option value=\"{$types[$i]}\">{$types[$i]}</option>";
                    }
                  
                ?>

            </select>


            <label for="severity">Severity: </label>
            <select name="severity">


                 <?php
                   $severity = array('Minor', 'Serious', 'Fatal' );
                    for($i=0, $len=count($severity); $i<$len; $i++)
                    {
                        if(strcasecmp($severity[$i], $all_results['severity']) == 0)
                            echo "<option selected = \"selected\" value=". $all_results['severity'] .">" . $all_results['severity']. "</option>";
                        else
                            echo "<option value=". $severity[$i] .">" . $severity[$i] . "</option>";
                    }
                  
                ?>

            </select>
            <br><br>
            <label for="summary">Problem Summary: </label>

            <?php
                    $output = $all_results['summary'];
                    echo "<textarea rows=\"1\" cols=\"70\" name=\"summary\">{$output}</textarea>"

                
            ?>
            
            <label for="reproducible">Reproducible? </label>


            <?php
                if($all_results['reproducible'] == "1")
                    echo "<input type=\"checkbox\" name=\"reproducible\" value = \"yes\" checked>";
                else
                    echo "<input type=\"checkbox\" name=\"reproducible\" value = \"yes\">";
            ?>



            <br><br>
            
            <label for="problem">Problem: </label>
            <?php
                    $output = $all_results['problem'];
                    echo "<textarea rows=\"2\" cols=\"90\" name=\"problem\">{$output}</textarea>"
                
            ?>



            <br><br>
            <label for="suggested_fix">Suggested Fix: </label>
             <?php
                    $output = $all_results['suggested_fix'];
                    echo "<textarea rows=\"2\" cols=\"90\" name=\"suggested_fix\">{$output}</textarea>"
                
            ?>



            <br><br>
           
            <label for="reported_by">Reported By: </label>
            <select id="reported_by" name="reported_by">

                <?php

                    $query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        if($row['emp_id'] == $all_results['reported_by'])
                            echo "<option selected=\"selected\" value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                        else
                            echo "<option value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                    }
                ?>
            </select>
            
            <label for="discover_date">Date: </label>
            <?php
                $rep_date = $all_results['discover_date'];
                echo "<input type=\"date\" name=\"discover_date\" value = {$rep_date}>"
            ?>
            
            <p></p><hr><p></p>



            <label for="functional_area">Functional Area: </label>
            <select id="functional_area" name="functional_area">
            <option value=""></option>
                <?php
                    $query = "SELECT * FROM areas WHERE prog_id = $prog_id";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
						
                        if($row['area'] == $all_results['functional_area']) {
                            echo "<option selected=\"selected\" value=\"{$row['area']}\">" . $row['area'] . "</option>";
						}
                        else
                            echo "<option value=\"{$row['area']}\">" . $row['area'] . "</option>";
                    }
                ?>
            </select>

            <label for="assigned_to">Assigned To: </label>
            <select id="assigned_to" name="assigned_to">
            <option value="NULL"></option>
                <?php

                    $query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        if($row['emp_id'] == $all_results['assigned_to'])
                            echo "<option selected=\"selected\" value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                        else
                            echo "<option value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                    }
                ?>
            </select>
           
            <label for="deferred">Treat as deferred? </label>

            <?php
                if($all_results['deferred'] == "1")
                    echo "<input type=\"checkbox\" name=\"deferred\" value = \"yes\" checked>";
                else
                    echo "<input type=\"checkbox\" name=\"deferred\" value = \"yes\">";
            ?>



            <br><br>
            

            <label for="comments">Comments: </label>

            <?php
                    $output = $all_results['comments'];
                    echo "<textarea rows=\"2\" cols=\"92\" name=\"comments\">{$output}</textarea>"
                
            ?>
            <br><br>

            <label for="status">Status: </label>
            <select id="status" name="status">
                   <?php
                   $status = array('Open', 'Closed', 'Resolved' );
                    for($i=0, $len=count($status); $i<$len; $i++)
                    {


                        if(strcasecmp($status[$i], $all_results['status']) == 0)
                            echo "<option selected = \"selected\" value=\"{$status[$i]}\">" . $status[$i] . "</option>";
                        else
                            echo "<option value=\"{$status[$i]}\">" . $status[$i] . "</option>";
                    }
                  
                ?>

            </select>
            <label for="priority">Priority: </label>
            <select id="priority" name="priority">
            <option value="NULL"></option>

                <?php
                   $priority = array('1','2','3','4','5','6');
                    for($i=0, $len=count($priority); $i<$len; $i++)
                    {
                        if(strcasecmp($priority[$i], $all_results['priority']) == 0)
                            echo "<option selected = \"selected\" value=\"{$priority[$i]}\">" . $priority[$i] . "</option>";
                        else
                            echo "<option value=\"{$priority[$i]}\">" . $priority[$i] . "</option>";
                    }
                  
                ?>




            </select>
            <label for="resolution">Resolution: </label>
            <select id="resolution" name="resolution">
            <option value=""></option>

                <?php
                   $resolution = array("Pending", "Fixed", "Irreproducible", "Deferred", "As designed", "Withdrawn by reporter", "Need more info" , "Disagree with suggestion", "Duplicate"  );
                    for($i=0, $len=count($resolution); $i<$len; $i++)
                    {
                        if($resolution[$i] == $all_results['resolution'] )
                            echo "<option selected = \"selected\" value=\"{$resolution[$i]}\">" . $resolution[$i] . "</option>";
                        else
                            echo "<option value=\"{$resolution[$i]}\">" . $resolution[$i] . "</option>";
                    }
                  
                ?>
            </select>


            <label for="version">Resolution version: </label>
            <?php
                $resol_version = $all_results['version'];
                echo "<input id=\"version\" type=\"text\" name=\"version\" value = {$resol_version}>"
            ?>
            <br><br>



            <label for="resolved_by">Resolved by: </label>
            <select id="resolved_by" name="resolved_by">
            <option value="NULL"></option>

                 <?php

                    $query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        if($row['emp_id'] == $all_results['resolved_by'])
                            echo "<option selected=\"selected\" value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                        else
                            echo "<option value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                    }
                ?>
            </select>
           

            <label for="resolved_date">Date: </label>
            <?php
                $r_date = $all_results['resolved_date'];
                echo "<input type=\"date\" name=\"resolved_date\" value = {$r_date}>"
            ?>

        
            <label for="tested_by">Tested by: </label>
            <select id="tested_by" name="tested_by">
            <option value="NULL"></option>
                <?php

                    $query = "SELECT * FROM employees";
                    $result = mysqli_query($con, $query);
                    while($row=$result->fetch_assoc()) {
                        if($row['emp_id'] == $all_results['tested_by'])
                            echo "<option selected=\"selected\" value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                        else
                            echo "<option value=\"{$row['emp_id']}\">" . $row['name'] . "</option>";
                    }
                ?>
            </select>
           

            <label for="tested_date">Date: </label>
             <?php
                $t_date = $all_results['tested_date'];
                echo "<input type=\"date\" name=\"tested_date\" value = {$t_date}>"
            ?>

			<br><br>
		  
            <input type="submit" name="submit" value="Update">
            <input type="button" name="cancel" value="Cancel" onclick="goToMain()">
			<p></p><hr><p></p>


            <label for="Attachments">Attachments </label>
            <select id="Attachments" name="Attachments">
            <?php
                $found = 0;
                echo "Attachments";
                $query = "SELECT * FROM files WHERE bug_id = $bug_id";
                $result = mysqli_query($con, $query);
                while($row=$result->fetch_assoc()) {
                    if($row['bug_id'] == $bug_id){
                        $found = 1;
                        echo "<option selected=\"selected\" value=\"{$row['name']}\">" . $row['name'] . "</option>";
                    }
                }

                if($found == 0)
                {
                    echo "<option selected=\"selected\" value=\"None\">None</option>";
                }

            ?>

            <input type="button" name="open" value="Open" onclick="openFiles()">

          <pre><input type="file" name="files[]" id="files" multiple=""><input type="submit" name="add_attachment" value="Add Attachment"></pre> 

        </form>
		<Br><br>
        

        <?php
		
		if(isset($_POST['add_attachment'])){
			
			//handle uploaded files
			if(is_uploaded_file($_FILES['files']['tmp_name'][0])){
										
				$numFiles = count($_FILES['files']['name']);
				
				// Loop through all files
				for($i=0; $i < $numFiles; $i++){
					
					$filename = $_FILES['files']['name'][$i];
					$filename = mysqli_real_escape_string($con,$filename);
								
					// Upload file
					move_uploaded_file($_FILES['files']['tmp_name'][$i],'uploads/'.$filename);
					$query = "INSERT INTO files (name, bug_id) VALUES ('$filename', '$bug_id')";
					
					if(!mysqli_query($con, $query)){
						echo("Error: " .mysqli_error($con));
					}
					else {
						echo '<script>alert("Success! File(s) have been uploaded.")</script>';
						header("Refresh:0");
					}
				}
			}
		}

         if(isset($_POST['submit'])) {

                $programID = mysqli_real_escape_string($con, $_POST['program']);
                $reportType = mysqli_real_escape_string($con, $_POST['report_type']);
                $severity = mysqli_real_escape_string($con, $_POST['severity']);
                $summary = mysqli_real_escape_string($con, $_POST['summary']);
                $reproducible = isset($_POST['reproducible']);
                $problem = mysqli_real_escape_string($con, $_POST['problem']);
                $suggestedFix = mysqli_real_escape_string($con, $_POST['suggested_fix']);
                $reportedByID = mysqli_real_escape_string($con, $_POST['reported_by']);
                $discoverDate = mysqli_real_escape_string($con, $_POST['discover_date']);

                $functionalArea = mysqli_real_escape_string($con, $_POST['functional_area']);
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
                


                $query = "UPDATE bugs 
                          SET prog_id=$programID, 
                              report_type=\"{$reportType}\",
                              severity=\"{$severity}\",
                              summary=\"{$summary}\",
                              reproducible=\"{$reproducible}\",
                              problem=\"{$problem}\",
                              suggested_fix=\"{$suggestedFix}\",
                              reported_by=\"{$reportedByID}\",
                              discover_date=\"{$discoverDate}\", 
                              functional_area=\"{$functionalArea}\",
                              assigned_to=\"{$AssignedTo}\",
                              deferred=\"{$deferred}\",
                              comments=\"{$comments}\", 
                              status=\"{$status}\",
                              priority=\"{$priority}\",
                              resolution=\"{$resolution}\", 
                              version=\"{$version}\",
                              resolved_by=\"{$resolvedBy}\",
                              resolved_date=\"{$resolvedDate}\", 
                              tested_by=\"{$testedBy}\", 
                              tested_date=\"{$testedDate}\"                                                 
                          WHERE bug_id=$bug_id";


                $result = mysqli_query($con, $query);
				
				//handle uploaded files
				if(is_uploaded_file($_FILES['files']['tmp_name'][0])){
											
					$numFiles = count($_FILES['files']['name']);
					
					// Loop through all files
					for($i=0; $i < $numFiles; $i++){
						
						$filename = $_FILES['files']['name'][$i];
						$filename = mysqli_real_escape_string($con,$filename);
									
						// Upload file
						move_uploaded_file($_FILES['files']['tmp_name'][$i],'uploads/'.$filename);
						$query = "INSERT INTO files (name, bug_id) VALUES ('$filename', '$bug_id')";
						
						if(!mysqli_query($con, $query)){
							echo("Error: " .mysqli_error($con));
						}
		
					}
					

				}
        
                if(!$result){
                    echo '<script>alert("Error: Bug Report not updated." .mysqli_error($con))</script>';
                }
                else{
                    
					echo '<script>alert("Success! Bug Report Updated.")</script>';
					header("Refresh:0");
					
                }     
                   
         }

        
        ?>


            
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
            
            function goToMain() {
                window.location.replace("main.php");
            }
            
            function reset() {
                window.location.reload(true);
            }
			
			function openFiles() {
				
				var fileName = $("#Attachments").val();
				var fileExt = fileName.split('.').pop();
				
				if(fileExt == "docx" || fileExt == "doc")
					window.location.href = "ms-word:ofe|u|http://localhost/CECS544Proj/uploads/"+fileName;	
				else
					window.location.href = "http://localhost/CECS544Proj/uploads/"+fileName;
			}
			
			function getAreas(programID) {
				
				$.ajax({
					url: 'get_areas.php',
					type: 'POST',
					data: {prog_id : programID},
					success: function(data) {
						
						var collection = jQuery.parseJSON(data);
						
						$("#functional_area").empty();
						var first = true;
						
						$.each(collection, function(key,value) {
							if(!first)
								$('#functional_area').append('<option value="'+value+'">'+value+'</option>');
							else
								$('#functional_area').append('<option value=""></option>');
								
							first = false;
						});
					}
				});
								
			}
        </script>

    </body>
</html>