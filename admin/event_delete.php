<?php 
    require_once('includes/dbconnection.php');

    if(!isset($_POST['id'])){
        echo "<script>  location.replace('./view-calendar.php') </script>";
        $con->close();
        exit;
    }

    $delete = $con->query("DELETE FROM `events` where id = '{$_POST['id']}'");

    if($delete){
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