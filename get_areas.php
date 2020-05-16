<?php

	if($_REQUEST['prog_id']) {
		$prog_id = $_REQUEST['prog_id'];
		
		$con = mysqli_connect("localhost","root");
        mysqli_select_db($con, "bughound");

        $query = "SELECT * FROM areas WHERE prog_id = $prog_id";
        $result = mysqli_query($con, $query);
		
		$areas = [];
        
		while($row=$result->fetch_assoc()) {
			$area_id = $row['area_id'];
			$area_name = $row['area'];
			array_push($areas,$area_id);
			$areas[$area_id] = $area_name;
		}
		
		print json_encode($areas);
	}


?>