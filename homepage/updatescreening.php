<?php


	$user = 'root';
	$pass = '';
	$database = 'cinebase';
 
	$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");
	

?>
<html>
<head>
</head>
<body>

	<a href="screening.php">Back to Screenings</a><br><br>
    <div>
	<form id='updateform' action="" method="get">
		Update screening:
		<table style='border: 1px solid #DDDDDD'>
			<thead>
				<tr>
					<th>Screening-ID</th>
					<th>Hall-ID</th>
					<th>Film-ID</th>
					<th>Starting Time</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input id='screening_id' name='screening_id' type='text' size='20' readonly value='<?php echo $_GET['screening_id']; ?>' />
					</td>
					<td>
						<input id='hall_id' name='hall_id' type='text' size='20' value='<?php echo $_GET['hall_id']; ?>' />
					</td>
					<td>
						<input id='film_id' name='film_id' type='text' size='20' value='<?php echo $_GET['film_id']; ?>' />
					</td>
					<td>
						<input id='starting_time' name='starting_time' type='text' size='20' value='<?php echo $_GET['starting_time']; ?>' />
					</td>

				</tr>
			</tbody>
		</table>
		<input id='submit' type='submit' name="submit" value='Update!' />
	</form>
    </div>
	
<?php


	if (isset($_GET["submit"])){

  
		
		$screening_id = $_GET['screening_id'];
		$hall_id = $_GET['hall_id'];
		$film_id = $_GET['film_id'];
		$starting_time = $_GET['starting_time'];

	
		// sql to update a record
		$sql = "UPDATE screening 
		SET hall_id = \"$hall_id\",
		film_id=\"$film_id\",
		starting_time=\"$starting_time\"
		WHERE screening_id=$screening_id";
	
	
                                                 							
		//Parse and execute statement
		if ($conn->query($sql) === TRUE) {
			echo "Record updated succesfully";
		    header("location: screening.php");

			} 
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}



?>
</body>
</html>