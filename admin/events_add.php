<?php  
  
$title = $_POST['title'];  
$start = $_POST['start'];  
$end = $_POST['end'];  
$description = $_POST['description'];  
  
try {  
    require "includes/dbconnection.php";  
} catch(Exception $e) {  
    exit('Unable to connect to database.');  
}  
  
$sql = "INSERT INTO events (title, start, end, description) VALUES (:title, :start, :end, :description )";  
$q = $bdd->prepare($sql);  
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':description'=>$description));  
  
?>  