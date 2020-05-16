<?php
    $con = mysqli_connect("localhost","root");
    mysqli_select_db($con, "bughound");

    if(isset($_POST['prog_xml'])) {
        header('Content-Type: text/xml; charset=utf-8');
        header('Content-Disposition: attachment; filename=programs.xml');
        $output = fopen("php://output", "w");
        $query = "SELECT * FROM programs";
        $result = mysqli_query($con, $query);
        fwrite($output, "<xml version=\"1.0\" encoding=\"utf-8\"?>\n\n");
        fwrite($output, "<database name=\"bughound\">\n");
        while($row = mysqli_fetch_row($result)) {
            fwrite($output, "\t<table name=\"programs\">\n");
            fwrite($output, "\t\t<column name=\"prog_id\">" . $row[0]. "</column>\n");
            fwrite($output, "\t\t<column name=\"program\">" . $row[1]. "</column>\n");
            fwrite($output, "\t\t<column name=\"program_release\">" . $row[2]. "</column>\n");
            fwrite($output, "\t\t<column name=\"program_version\">" . $row[3]. "</column>\n");
            fwrite($output, "\t</table>\n");
        }
        fwrite($output, "</database>");
        fclose($output);
    }
    if(isset($_POST['prog_ascii'])) {
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename=programs.txt');
        $output = fopen("php://output", "w");
        $query = "SELECT * FROM programs";
        $result = mysqli_query($con, $query);
        fwrite($output, "===Database bughound\n\n");
        fwrite($output, "== Table structure for table programs\n\n");
        fwrite($output, "|------\n|Column|Type|Null|Default\n|------\n");
        fwrite($output, "|//**prog_id**//|int(11)|No|\n");
        fwrite($output, "|program|varchar(32)|No|\n");
        fwrite($output, "|program_release|varchar(32)|No|\n");
        fwrite($output, "|program_version|varchar(32)|No|\n");
        fwrite($output, "== Dumping data for table programs\n\n");
        while($row = mysqli_fetch_row($result)) {
            fwrite($output, "|".$row[0]."|".$row[1]."|".$row[2]."|".$row[3]."\n");
        }
        fclose($output);
    }
    if(isset($_POST['emp_xml'])) {
        header('Content-Type: text/xml; charset=utf-8');
        header('Content-Disposition: attachment; filename=employees.xml');
        $output = fopen("php://output", "w");
        $query = "SELECT * FROM employees";
        $result = mysqli_query($con, $query);
        fwrite($output, "<xml version=\"1.0\" encoding=\"utf-8\"?>\n\n");
        fwrite($output, "<database name=\"bughound\">\n");
        while($row = mysqli_fetch_row($result)) {
            fwrite($output, "\t<table name=\"employees\">\n");
            fwrite($output, "\t\t<column name=\"emp_id\">" . $row[0]. "</column>\n");
            fwrite($output, "\t\t<column name=\"name\">" . $row[1]. "</column>\n");
            fwrite($output, "\t\t<column name=\"username\">" . $row[2]. "</column>\n");
            fwrite($output, "\t\t<column name=\"password\">" . $row[3]. "</column>\n");
            fwrite($output, "\t\t<column name=\"userlevel\">" . $row[4]. "</column>\n");
            fwrite($output, "\t</table>\n");
        }
        fwrite($output, "</database>");
        fclose($output);
    }
    if(isset($_POST['emp_ascii'])) {
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename=employees.txt');
        $output = fopen("php://output", "w");
        $query = "SELECT * FROM employees";
        $result = mysqli_query($con, $query);
        fwrite($output, "===Database bughound\n\n");
        fwrite($output, "== Table structure for table employees\n\n");
        fwrite($output, "|------\n|Column|Type|Null|Default\n|------\n");
        fwrite($output, "|//**emp_id**//|int(11)|No|\n");
        fwrite($output, "|name|varchar(32)|No|\n");
        fwrite($output, "|username|varchar(32)|No|\n");
        fwrite($output, "|password|varchar(32)|No|\n");
        fwrite($output, "|userlevel|int(11)|No|\n");
        fwrite($output, "== Dumping data for table employees\n\n");
        while($row = mysqli_fetch_row($result)) {
            fwrite($output, "|".$row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."\n");
        }
        fclose($output);
    }

    if(isset($_POST['areas_ascii'])) {
    header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename=areas.txt');
        $output = fopen("php://output", "w");
        $query = "SELECT * FROM areas";
        $result = mysqli_query($con, $query);
        fwrite($output, "===Database bughound\n\n");
        fwrite($output, "== Table structure for table areas\n\n");
        fwrite($output, "|------\n|Column|Type|Null|Default\n|------\n");
        fwrite($output, "|//**area_id**//|int(11)|No|\n");
        fwrite($output, "|prog_id|int(11)|No|\n");
        fwrite($output, "|area|varchar(32)|No|\n");
        fwrite($output, "== Dumping data for table areas\n\n");
        while($row = mysqli_fetch_row($result)) {
            fwrite($output, "|".$row[0]."|".$row[1]."|".$row[2]."\n");
        }
        fclose($output);
    }

    if(isset($_POST['areas_xml'])) {
        header('Content-Type: text/xml; charset=utf-8');
        header('Content-Disposition: attachment; filename=areas.xml');
        $output = fopen("php://output", "w");
        fwrite($output,"<!--- Export Areas Table to XML -->\n");
        fwrite($output,"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\n");
        fwrite($output, " <!--- Database: 'bughound' -->\n");
        fwrite($output,"<database name=\"bughound\">\n");
        fwrite($output, "\t<!-- Table areas -->\n");

        $query = "SELECT * FROM areas";
        $result = mysqli_query($con, $query);
                
        while($row=mysqli_fetch_row($result))
        {
            fwrite($output,"\t<table name=\"areas\">\n");
            fwrite($output,"\t\t<column name=\"area_id\">" . $row[0] . "</column>\n");
            fwrite($output,"\t\t<column name=\"prog_id\">" . $row[1] . "</column>\n");
            fwrite($output,"\t\t<column name=\"area\">" . $row[2] . "</column>\n");
            fwrite($output,"\t</table>\n");
        }

        fwrite($output,"</database>");
        fclose($output);
    }

?>