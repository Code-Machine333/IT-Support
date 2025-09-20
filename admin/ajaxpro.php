<?php

	require('includes/dbconnection.php');
			
			$sql = "SELECT * FROM tbluser WHERE fk_discipline LIKE '%".$_GET['id']."%'"; 

   $result = $mysqli->query($sql);


   $json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['FullName'];
   }


   echo json_encode($json);
?>