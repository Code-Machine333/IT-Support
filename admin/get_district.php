<?php
	require_once("includes/dbconnection.php");
	if(!empty($_POST["state_id"])) 
	{
		$query =mysqli_query($con,"SELECT ID, FullName FROM tbluser WHERE fk_discipline = '" . $_POST["state_id"] . "'order by FullName asc ");
	?>
	<option value="">Select User</option>
	<?php
		while($row=mysqli_fetch_array($query))  
		{
		?>
		<option value="<?php echo $row["ID"]; ?>"><?php echo $row["FullName"]; ?></option>
		<?php
		}
	}
?>
