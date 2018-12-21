<?php

	$id = $_GET['id'];

	$user = 'root';
	$pass = '';
	$database = 'cinebase';
 
	$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");
	
	// sql to delete a record
	$sql = "DELETE FROM screening WHERE screening_id = $id"; 

	if (mysqli_query($conn, $sql)) {
		mysqli_close($conn);
		header('Location: screening.php'); 
		exit;
	} else {
		echo "Error deleting record";
	}
?>