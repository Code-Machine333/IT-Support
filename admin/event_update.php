<?php 
    require_once('includes/dbconnection.php');

    if(!isset($_POST['id'])){
        echo "<script>  location.replace('./view-calendar.php') </script>";
        $con->close();
        exit;
    }

    $update = $con->query("UPDATE `events` set `start_datetime` = '{$_POST['start']}', `end_datetime` = '{$_POST['end']}' where id = '{$_POST['id']}'");

    if($update){
        //echo "<script> location.replace('./view-calendar.php') </script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$con->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
    
    $con->close();
?>