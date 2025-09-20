<?php 
    require_once('includes/dbconnection.php');

    if($_SERVER['REQUEST_METHOD'] !='POST'){
        //echo "<script> alert('Error: No data to save.'); location.replace('./view-calendar.php') </script>";
        $con->close();
        exit;
    }

    extract($_POST);
    $allday = isset($allday);

    if(empty($id)){
        $sql = "INSERT INTO `events` (`title`,`description`,`start_datetime`,`end_datetime`) VALUES ('$title','$description','$start_datetime','$end_datetime')";
    }else{
        $sql = "UPDATE `events` set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
    }

    $save = $con->query($sql);

    if($save){
        //echo "<script> location.replace('./view-calendar.php')</script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$con->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
    
    $con->close();
?>