<?php
  error_reporting(0);

  $user = 'root';
  $pass = '';
  $database = 'cinebase';
 
  // establish database connection
  $conn = new mysqli('localhost', $user, $pass, $database) or die("dead");
    
?>

<html>
<head>
</head>
<body>
  <div>
    <form id='searchform' action='screening.php' method='get'>
      <a href='screening.php'>All Screenings</a> ---
      Search for Film Title: 
      <input id='searchTitle' name='searchTitle' type='text' size='20' value='<?php echo $_GET['searchTitle']; ?>' />
      <input id='submit' type='submit' value='Search!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['searchTitle'])) {
    $sql = "SELECT * FROM screening NATURAL JOIN film WHERE title like '%" . $_GET['searchTitle'] . "%'";
  }   
  else if (isset($_GET['searchFilmID'])) {
    $sql = "SELECT * FROM screening NATURAL JOIN film WHERE film_id like '" . $_GET['searchFilmID'] . "'";
  }
  else {
    $sql ="SELECT * FROM screening NATURAL JOIN film";
  }
  $result = $conn->query($sql);
  
?>


  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
      		<th>Screening-ID</th>
			<th>Hall-ID</th>
			<th>Film-ID</th>
			<th>Film-Title</th>
			<th>Starting Time</th>
			<th>Duration (minutes)</th>	
      </tr>
    </thead>
    <tbody>
<?php

  // fetch rows of the executed sql query
  if($result->num_rows > 0){
	while ($row = $result->fetch_assoc()) {
		  
		echo "<tr>";
		echo "<td>" . $row['screening_id'] . "</td>";
		echo "<td>" . $row['hall_id'] . "</td>";
		echo "<td>" . $row['film_id'] . "</td>"; 
		echo "<td>" . $row['title'] . "</td>"; 
		echo "<td>" . $row['starting_time'] . "</td>";
		echo "<td>" . $row['duration'] . "</td>";
		echo "<td><a href=\"updatescreening.php?screening_id=" . $row['screening_id'] . "&hall_id=" . $row['hall_id'] . "&film_id=" . $row['film_id'] . "&starting_time=" . $row['starting_time'] . "&duration=" . $row['duration'] . "\"> UPDATE </a></td>"; 
		
		echo "<td><a href=\"deletescreening.php?id=" . $row['screening_id'] . "\"> DELETE </a></td>"; 

		echo "</tr>";
	  }
  }
  $row_cnt = mysqli_num_rows($result);


?>
    </tbody>
  </table>

  <div><?php echo $row_cnt ?> Screening/s found!</div>

 
  <br>
  
    <div>
	<form id='insertform' action='screening.php' method='get'>
		Add new screening:
	    <a href="film.php"> (Go to films) </a>

		<table style='border: 1px solid #DDDDDD'>
			<thead>
				<tr>
					<th>Screening-ID</th>
					<th>Hall-ID</th>
					<th>Film-ID</th>
					<th>Starting Time</th>
					<th>Duration (minutes)</th>	
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input id='screening_id' name='screening_id' type='text' size='10' value='<?php echo $_GET['screening_id']; ?>' />
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
					<td>
						<input id='duration' name='duration' type='text' size='20' value='<?php echo $_GET['duration']; ?>' />
					</td>				
				</tr>
			</tbody>
		</table>
		<input id='submit' type='submit' value='Insert!' />
	</form>
    </div>

<?php
	//Handle insert
	if (isset($_GET['screening_id']) && !empty($_GET['screening_id'])){

		//Prepare insert statementd
		$sql = "INSERT INTO screening VALUES(" . $_GET['screening_id'] . ",'"  . $_GET['hall_id'] . "','" . $_GET['film_id'] . "','" . $_GET['starting_time'] . "','" . $_GET['duration'] .  "')";
                                                 
										
		//Parse and execute statement
		if ($conn->query($sql) === TRUE) {
			echo "New record created succesfully";
		    header("location: screening.php");

			} 
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

	}
	
	

?>
  







<?php $conn->close();?>
</body>
</html>