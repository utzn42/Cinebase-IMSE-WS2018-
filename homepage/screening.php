<?php
error_reporting(0);
session_start();
$user = 'root';
$pass = '';
$database = 'cinebase';

// establish database connection
$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");
date_default_timezone_set('Europe/Berlin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet"
        type="text/css"
        href="css/main.css"/>
  <script src="js/main.js"></script>
</head>
<body>

<div class="wrapper">
  <div class="topLine" id="topLine">
    cinebase
    <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
    </button>
    <button onclick="window.location='movies.php';"
            class="buttonBig">Movies
    </button>
    <button onclick="window.location='screening.php';"
            style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">
      Screenings
    </button>
      <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
          echo "<button onclick=\"window.location='employee_administration.php';\" class=\"buttonBig\">Employees</button>";
      } ?>
      <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
          echo "<button onclick=\"window.location='hall_administration.php';\" class=\"buttonBig\">Halls</button>";
      } ?>
    <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'"
            class="buttonLogin">
      Sign In
    </button>
    <button id="register" onclick="window.location='register.php';"
            class="buttonRegister">Register
    </button>
  </div>
</div>

<div class="wrapperMainBody">
  <div class="mainBody" id="mainBody">
    <div>
      <form id='searchform' action='screening.php' method='get'>
        <a href='screening.php'>All Screenings</a> ---
        Search for Film Title:
        <input id='searchTitle' name='searchTitle' type='text' size='20'
               value='<?php echo $_GET['searchTitle']; ?>'/>
        <input id='search' type='submit' value='Search!'/>
      </form>
      <br>
    </div>
	<div>
		
        <a href="screening.php?today=true">Show todays screenings</a><br>
		<a href="screening.php?tomorrow=true">Show tomorrows screenings</a><br>
		<a href="screening.php?nextweek=true">Show this weeks screenings</a><br>
		
    </div>
    <?php
    $sql = "SELECT MAX(screening_id) AS max FROM screening";
    $result = $conn->query($sql);
    $max_row = mysqli_fetch_array($result);


	if (isset($_GET['searchTitle'])) {
		$sql = "SELECT * FROM screening NATURAL JOIN film NATURAL JOIN hall WHERE title like '%" . $_GET['searchTitle'] . "%'";
	} else if (isset($_GET['searchFilmID'])) {
		$sql = "SELECT * FROM screening NATURAL JOIN film NATURAL JOIN hall WHERE film_id like '" . $_GET['searchFilmID'] . "'";
	} else if (isset($_GET['today'])) {
		$sql = "SELECT * FROM screening NATURAL JOIN film NATURAL JOIN hall WHERE DATEDIFF(starting_time, CURDATE()) = 0 ORDER BY starting_time ASC";
	} else if (isset($_GET['tomorrow'])) {
		$sql = "SELECT * FROM screening NATURAL JOIN film NATURAL JOIN hall WHERE DATEDIFF(starting_time, CURDATE()) = 1 ORDER BY starting_time ASC";      
	} else if (isset($_GET['nextweek'])) {
		$sql = "SELECT * FROM screening NATURAL JOIN film NATURAL JOIN hall WHERE DATEDIFF(starting_time, CURDATE()) >= 0 AND DATEDIFF(starting_time, CURDATE()) <= 7 ORDER BY starting_time ASC"; 
	}
	else {
		$sql = "SELECT * FROM screening NATURAL JOIN film NATURAL JOIN hall ORDER BY starting_time ASC";
	}
	$result = $conn->query($sql);

	?>

    <br>

    <div id="insertScreening">
      <form id='insertform' action='screening.php' method='get'>
        Add new screening:

        <table style='border: 1px solid #DDDDDD'>
          <thead>
          <tr>
            <th>Screening-ID</th>
            <th style="padding: 0px 10px 0px 10px;">Hall-ID</th>
            <th style="padding: 0px 10px 0px 10px;">Film-ID</th>
            <th style="padding: 0px 10px 0px 10px;">Starting Time</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>
              <input id='screening_id' name='screening_id' type='text' size='10'
                     value='<?php echo $max_row["max"] + 1; ?>'/>
            </td>
            <td>
              <input id='hall_id' name='hall_id' type='text' size='20'
                     value='<?php echo $_GET['hall_id']; ?>'/>
            </td>
            <td>
              <input id='film_id' name='film_id' type='text' size='20'
                     value='<?php echo $_GET['film_id']; ?>'/>
            </td>
            <td>
              <input id='starting_time' name='starting_time' type='text' size='20'
                     value='yyyy-mm-dd hh:mm'/>
            </td>
          </tr>
          </tbody>
        </table>
        <input id='insert' type='submit' value='Insert!'/>
      </form>
    </div>

      <?php
      //Handle insert
      if (isset($_GET['screening_id']) && !empty($_GET['screening_id']) && isset($_GET['film_id']) && !empty($_GET['film_id']) && isset($_GET['hall_id']) && !empty($_GET['hall_id'])) {

          //Prepare insert statementd
          $sql = "INSERT INTO screening VALUES(" . $_GET['screening_id'] . ",'" . $_GET['hall_id'] . "','" . $_GET['film_id'] . "','" . $_GET['starting_time'] . "')";


          //Parse and execute statement
          if ($conn->query($sql) === TRUE) {
              echo "New record created succesfully";
              #header("location: screening.php");

          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }

      }


		echo("<script type=\"text/javascript\">hideFormInsertScreening();</script>");

		?>
    <br>


    <table style='border: 1px solid #DDDDDD'>
      <thead>
      <tr id="tableRow">
        <th id="hallName" style="padding: 0px 10px 0px 10px;">Hall Name</th>
        <th id="filmTitle" style="padding: 0px 10px 0px 10px;">Film-Title</th>
        <th style="padding: 0px 10px 0px 10px;">Starting Time</th>
        <th style="padding: 0px 10px 0px 10px;">Duration (minutes)</th>

      </tr>
      </thead>
      <tbody>
      <?php

      // fetch rows of the executed sql query
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

              $date = $row['starting_time'];
              $simpleDate = new DateTime($date);

              echo "<tr>";
              if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                  echo "<td>" . $row['screening_id'] . "</td>";
                  echo "<td>" . $row['hall_id'] . "</td>";
              }


              echo "<td>" . $row['name'] . "</td>";

              if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                  echo "<td>" . $row['film_id'] . "</td>";
              }

              echo "<td style=\"padding: 0px 10px 0px 10px;\">" . $row['title'] . "</td>";
              echo "<td style=\"padding: 0px 10px 0px 10px;\">" . $simpleDate->format('d/m/Y H:i') . "</td>";
              echo "<td style=\"padding: 0px 10px 0px 10px;\">" . $row['duration'] . "</td>";

              if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                  echo "<td><a href=\"updatescreening.php?screening_id=" . $row['screening_id'] . "&hall_id=" . $row['hall_id'] . "&film_id=" . $row['film_id'] . "&starting_time=" . $row['starting_time'] . "\"> UPDATE </a></td>";
                  echo "<td><a href=\"deletescreening.php?id=" . $row['screening_id'] . "\"> DELETE </a></td>";
              }
              echo "<td style=\"padding: 5px 10px 5px 10px;\"><a href=\"movies.php?searchFilmID=" . $row['film_id'] . "\"> Show Film Details </a></td>";
              if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                  echo "<td style=\"padding: 5px 10px 5px 10px;\"><a href=\"reserveticket.php?screening_id=" . $row['screening_id'] . "\"> RESERVE </a></td>";
              }
              echo "</tr>";
          }
      }
      $row_cnt = mysqli_num_rows($result);


      ?>
      </tbody>
    </table>

    <div><?php echo $row_cnt ?> Screening/s found!</div>
	
	<?php
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			$username = $_SESSION['username'];
			echo("<script type=\"text/javascript\">setLoggedIn(\"$username\");</script>");
		}
		if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
			echo("<script type=\"text/javascript\">setAdminMode();</script>");
		}
		if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
			$username = $_SESSION['username'];
			echo("<script type=\"text/javascript\">setEmployeeMode(\"$username\");</script>");
			echo("<script type=\"text/javascript\">displayScreeningIDs();</script>");
		}
	?>

  </div>
</div>




<!-- Start of the part taken from: https://www.w3schools.com/howto/howto_css_login_form.asp -->
<div id="popUpLogin" class="modal">
    <span onclick="document.getElementById('popUpLogin').style.display='none'"
          class="close" title="Close Modal">&times;</span>

  <form class="modal-content animate" action="index.php" method="post">

    <div class="container">
      <label for="username"><b>Username</b></label>
      <input class="signInInputs" type="text" placeholder="Enter Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input class="signInInputs" type="password" placeholder="Enter Password" name="password"
             required>

      <button class="buttonLoginModal" type="submit">Login</button>
      <label>
        <input type="checkbox" name="remember"> Employee
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('popUpLogin').style.display='none'"
              class="cancelbtn">Cancel
      </button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>
<!-- End of the part taken from: https://www.w3schools.com/howto/howto_css_login_form.asp -->


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<p style="text-align:center">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>

<?php $conn->close(); ?>
</body>
</html>