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
    <form id='searchform' action='film.php' method='get'>
      <a href='film.php'>All Films</a> ---
      Search for title: 
      <input id='search' name='search' type='text' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Search!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM film WHERE title like '%" . $_GET['search'] . "%'";
  } else {
    $sql ="SELECT * FROM film";
  }
  $result = $conn->query($sql);
  
?>


  


  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
        <th>Film-ID</th>
	    <th>Title</th>
	    <th>Director</th>	  
		<th>Country</th>
	    <th>Language</th>	
		<th>Age rating</th>
      </tr>
    </thead>
    <tbody>
<?php

  // fetch rows of the executed sql query
  if($result->num_rows > 0){
	while ($row = $result->fetch_assoc()) {
		  
		echo "<tr>";
		
		
		echo "<td>" . $row['film_id'] . "</td>";
		echo "<td>" . $row['title'] . "</td>";
		echo "<td>" . $row['director'] . "</td>"; 
		echo "<td>" . $row['country'] . "</td>";
		echo "<td>" . $row['film_language'] . "</td>";
		echo "<td>" . $row['age_rating'] . "</td>"; 
		echo "<td><a href=\"updatefilm.php?film_id=" . $row['film_id'] . "&title=" . $row['title'] . "&director=" . $row['director'] . "&country=" . $row['country'] . "&film_language=" . $row['film_language'] . "&age_rating=" . $row['age_rating']."\"> UPDATE </a></td>"; 
		echo "<td><a href=\"deletefilm.php?id=" . $row['film_id'] . "\"> DELETE </a></td>"; 
		echo "<td><a href=\"screening.php?searchFilmID=" . $row['film_id'] . "\"> Show Screenings </a></td>"; 

		
		echo "</tr>";
	  }
  }
  $row_cnt = mysqli_num_rows($result);


?>
    </tbody>
  </table>

  <div><?php echo $row_cnt ?> Film/s found!</div>

 
  <br>
  
    <div>
	<form id='insertform' action='film.php' method='get'>
		Add new film:
		<table style='border: 1px solid #DDDDDD'>
			<thead>
				<tr>
				  <th>Film-ID</th>
				  <th>Title</th>
				  <th>Director</th>	  
				  <th>Country</th>
				  <th>Language</th>	
				  <th>Age rating</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input id='film_id' name='film_id' type='text' size='10' value='<?php echo $_GET['film_id']; ?>' />
					</td>
					<td>
						<input id='title' name='title' type='text' size='20' value='<?php echo $_GET['title']; ?>' />
					</td>
					<td>
						<input id='director' name='director' type='text' size='20' value='<?php echo $_GET['director']; ?>' />
					</td>
					<td>
						<input id='country' name='country' type='text' size='20' value='<?php echo $_GET['country']; ?>' />
					</td>
					<td>
						<input id='film_language' name='film_language' type='text' size='20' value='<?php echo $_GET['film_language']; ?>' />
					</td>
					<td>
						<input id='age_rating' name='age_rating' type='text' size='20' value='<?php echo $_GET['age_rating']; ?>' />
					</td>
				</tr>
			</tbody>
		</table>
		<input id='submit' type='submit' value='Insert!' />
	</form>
    </div>

<?php
	//Handle insert
	if (isset($_GET['film_id']) && !empty($_GET['film_id'])){

		//Prepare insert statementd
		$sql = "INSERT INTO film VALUES(" . $_GET['film_id'] . ",'"  . $_GET['title'] . "','" . $_GET['director'] . "','" . $_GET['country'] . "','" . $_GET['film_language'] . "','" . $_GET['age_rating'] .  "')";

                                                 
										
		//Parse and execute statement
		if ($conn->query($sql) === TRUE) {
			echo "New record created succesfully";
		    header("location: film.php");

			} 
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

	}
	
	

?>
  







<?php $conn->close();?>
</body>
</html>