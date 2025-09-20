<?php  
  
$id = $_POST['id'];  
  
try {  
    require "includes/dbconnection.php";  
} catch(Exception $e) {  
    exit('Unable to connect to database.');  
}  
  
$sql = "DELETE from events WHERE id=".$id;  
$q = $bdd->prepare($sql);  
$q->execute();  
  
?>