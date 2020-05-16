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



           

  
        
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound - Edit or Add Areas</title>
    </head>
    <style>
        pre {      font-family: "Times New Roman", Times, serif; }

        #programsList { font-family:  "Times New Roman", Times, serif;   border-collapse: collapse;  width: 60%; }

        #programsList td, #programsList th {  border: 1px solid #ddd; text-align: center; padding: 14px; }


        #programsList tr:nth-child(even){background-color: #f2f2f2;}

        #programsList tr:hover {background-color: #ddd; }

        #programsList th { padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white; }

    </style>

    <body style="background-color:lightyellow;">
        
        <table align="center" id="programsList">
          <tr>
            <th>Program ID</th>
            <th>Program</th>
            <th>Release</th>
            <th>Version</th>
          </tr>

           <?php
            $query = "SELECT * FROM programs";
            $result = mysqli_query($con, $query);
          

            $none = 0;
            while($row=mysqli_fetch_row($result)) 
                {
                    $none=1;
                    $myid = $row[0];
                    //$myname = $row[1];
                    printf("<tr>
                            <td><div class=btn><a href=%s%s>%s</a></td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            </tr>", "addAreas.php?sprog_id=", $row[0], $row[0], $row[1], $row[2], $row[3], $row[0]);
                  
                  
                         

                };

        ?>



        </table>
        <script>
        
           
        </script>
    </body>
</html>