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

	<a href="hall_administration.php">Back to Halls</a><br><br>
    <div>
	<form id='updateform' action="" method="get">
		Update Hall:
		<table style='border: 1px solid #DDDDDD'>
			<thead>
				<tr>
                    <th>Hall-ID</th>
                    <th>Name</th>
                    <th>Equipment</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input id='hall_id' name='hall_id' type='text' size='20' readonly value='<?php echo $_GET['hall_id']; ?>' />
					</td>
					<td>
						<input id='name' name='name' type='text' size='20' value='<?php echo $_GET['name']; ?>' />
					</td>
					<td>
						<input id='equipment' name='equipment' type='text' size='20' value='<?php echo $_GET['equipment']; ?>' />
					</td>
				</tr>
			</tbody>
		</table>
		<input id='submit' type='submit' name="submit" value='Update!' />
	</form>
    </div>
	
<?php


	if (isset($_GET["submit"])){



        $hall_id = $_GET['hall_id'];
        $name = $_GET['name'];
        $equipment = $_GET['equipment'];

	
		// sql to update a record
		$sql = "UPDATE hall 
		SET name = \"$name\",
		equipment=\"$equipment\"
		WHERE hall_id=$hall_id";
	
	
                                                 							
		//Parse and execute statement
		if ($conn->query($sql) === TRUE) {
			echo "Record updated succesfully";
		    header("location: hall_administration.php");

			} 
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}



?>
</body>
</html>