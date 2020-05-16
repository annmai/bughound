<!DOCTYPE html>
<?php
	//sudo chmod -R 777 ./CECS544Proj/*
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
        
    }

	

	/*if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
     if(isset($_POST["done"]))
                {    
                    $_SESSION['user'] = $user;
                    $_SESSION['name'] = $name;
                    $_SESSION['userlevel'] = $userlevel;
                    header("location: db-menu.php");
                    ob_end_flush();
                }


		if(isset($_POST["ProgramsXML"]))
        {
        		
        }

        if(isset($_POST["ProgramsASCII"]))
        {
        		
        }


        if(isset($_POST["EmployeesXML"]))
        {
        		
        }
 		
 		if(isset($_POST["EmployeesASCII"]))
        {
        		
        }


       	 
        if(isset($_POST["AreasXML"]))
        {
        		$file = fopen("areas.xml","w");
        		fwrite($file,"<!--- Export Areas Table to XML -->\n");
        		fwrite($file,"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\n");
				fwrite($file, " <!--- Database: 'bughound' -->\n");
				fwrite($file,"<database name=\"bughound\">\n");
				fwrite($file, "\t<!-- Table areas -->\n");

				$query = "SELECT * FROM areas";
            	$result = mysqli_query($con, $query);
            	
            	while($row=mysqli_fetch_row($result))
            	{
            		fwrite($file,"\t<table name=\"areas\">\n");
            		fwrite($file,"\t\t<column name=\"area_id\">" . $row[0] . "</column>\n");
            		fwrite($file,"\t\t<column name=\"prog_id\">" . $row[1] . "</column>\n");
            		fwrite($file,"\t\t<column name=\"area\">" . $row[2] . "</column>\n");
            		fwrite($file,"\t</table>\n");
            	}


				fwrite($file,"</database>");
				fclose($file);
        }


        if(isset($_POST["AreasASCII"]))
        {
        		
        }




	}*/





?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Edit or Add Areas</title>
    </head>
    <style>
        pre {      font-family: "Times New Roman", Times, serif; }
        #programsList { font-family:  "Times New Roman", Times, serif;   border-collapse: collapse;  width: 50%; }
        #programsList td, #programsList th {  border: 1px solid #ddd; text-align: center; padding: 14px; }
        #programsList tr:nth-child(even){background-color: #f2f2f2;}
        #programsList tr:hover {background-color: #ddd; }
        #programsList th { padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white; }

    </style>

    <body style="background-color:lightyellow;">
        <form action="export_code.php" method="post" >
        <table align="center" id="programsList">
          <br><br><br>
          <tr>
            <th>Export Tables</th>
            <th>Export Format</th>
          </tr>

          <tr>
          <td>Programs</td>
          <td>
            <input type="submit" name="prog_xml" value="XML">
            <input type="submit" name="prog_ascii" value="ASCII">
          </td>
          </tr>

          <tr>
          <td>Employees</td>
          <td>
            <input type="submit" name="emp_xml" value="XML">
            <input type="submit" name="emp_ascii" value="ASCII">
          </td>
          </tr>

          <tr>
          <td>Areas</td>
          <td>
            <input type="submit" name="areas_xml" value="XML">
            <input type="submit" name="areas_ascii" value="ASCII">
          </td>
          </tr>

        </table>
        </form>
		
		<br><center><button onclick="location.href='db-menu.php';" name=done>Done</button><center>

      


    </body>
</html>