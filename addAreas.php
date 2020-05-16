<!DOCTYPE html>



<?php
    ob_start();
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

        #programsList { font-family:  "Times New Roman", Times, serif;   border-collapse: collapse;  width: 50%; }

        #programsList td, #programsList th {  border: 1px solid #ddd; text-align: center; padding: 14px; }


        #programsList tr:nth-child(even){background-color: #f2f2f2;}

        #programsList tr:hover {background-color: #ddd; }

        #programsList th { padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white; }

    </style>

    <body style="background-color:lightyellow;">
        <form action="" method="post" >
        <table align="center" id="programsList">
          <tr>
            <th>Area ID</th>
            <th>Program ID</th>
            <th>Area</th>
            <th></th>
          </tr>

           <?php

            $prog_id = $_GET['sprog_id'];

            $query = "SELECT * FROM areas WHERE prog_id = $prog_id";
            $result = mysqli_query($con, $query);
            
            $programquery = "SELECT * FROM programs WHERE prog_id = $prog_id";
            $programresult = mysqli_query($con, $programquery);
            $program=mysqli_fetch_row($programresult);
            

           
            printf("<br><br><center>Add area to %s - %s - %s</center><br>", $program[1], $program[2], $program[3]);

            $areaID = null;
            $area = null;
            $counter = 0;

            $none = 0;
            while($row=mysqli_fetch_row($result)) 
                {
                    $counter++;
                    $none=1;
                    printf("<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td><input type=text name=updatearea%s size=40 value=\"%s\"></input></td>
                            <td><button type=makeupdate name=makeupdate%s>Update</button> </td>
                            </tr>
                            <input type=hidden name=areaID%s value=%s>", $row[0], $row[1], $counter ,$row[2], $counter, $counter, $row[0]);

                    $areaID = $row[0];
                   

                };

                    printf("<tr>
                            <td>Add</td>
                            <td>%s</td>
                            <td><input type=text name=addarea size=40></input></td>
                            <td><button type=add name=add>Add Area</button> </td>
                            </tr>",  $prog_id);




        ?>


        </table>
              <br><center><button type=submit name=done>Done</button><center>
        </form>

        <?php


            
            if($_SERVER["REQUEST_METHOD"] == "POST") {

                if(isset($_POST["done"]))
                {    
                    $_SESSION['user'] = $user;
                    $_SESSION['name'] = $name;
                    $_SESSION['userlevel'] = $userlevel;
                    header("location: db-menu.php");
                    ob_end_flush();


                }


                $check = 0;
                while($check < $counter)
                {
                $check++; 
            
                if(isset($_POST["makeupdate{$check}"])) 
                {
                    $area = $_POST["updatearea{$check}"];
                    $areaID = $_POST["areaID{$check}"];
                    if($area == "" || $area == null) 
                    {
                        echo "<script>alert('Error: Area must be filled');</script>";
                    }
                    else
                    {
                        $query3 = "UPDATE `areas` SET `area`="."'$area'"." WHERE area_id='".$areaID."' AND prog_id='".$prog_id."'";
                        $result = mysqli_query($con, $query3);
                        printf("Area ID: %s was updated to Area: %s",$areaID, $area );
                    
               
                     $_SESSION['user'] = $user;
                     $_SESSION['name'] = $name;
                     $_SESSION['userlevel'] = $userlevel;
                     header("location: addAreas.php?sprog_id={$prog_id}");
                     ob_end_flush();
                     }

                }
                }

                if(isset($_POST["add"])) 
                {
                    $area = $_POST["addarea"];

                    if($area == "" || $area == null) 
                    {
                        echo "<script>alert('Error: Area must be filled');</script>";
                        }
                    else
                    {
                        $query3 = "INSERT INTO `areas`(`prog_id`, `area`) VALUES ('".$prog_id."','".$area."')";
                        $result = mysqli_query($con, $query3);
                        printf("Area: %s was added to the database", $area );

                                           $_SESSION['user'] = $user;
                   $_SESSION['name'] = $name;
                   $_SESSION['userlevel'] = $userlevel;
                   header("location: addAreas.php?sprog_id={$prog_id}");
                    ob_end_flush();


                    }



                }


                     


            }

        ?>


    </body>
</html>