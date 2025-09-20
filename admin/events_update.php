<?php  
  
$id = $_POST['id'];  
$title = $_POST['title'];  
$start = $_POST['start'];  
$end = $_POST['end'];  
$description = $_POST['description'];  
  
try {  
    require "includes/dbconnection.php";  
} catch(Exception $e) {  
    exit('Unable to connect to database.');  
}  
  
$sql = "UPDATE events SET title=?, start=?, end=?, description=? WHERE id=?";  
$q = $bdd->prepare($sql);  
$q->execute(array($title,$start,$end,$description,$id));  
  
?>  