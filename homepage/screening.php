<?php
error_reporting(0);
session_start();
$user = 'root';
$pass = '';
$database = 'cinebase';

// establish database connection
$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

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

<div class="topLine" id="topLine">
  cinebase
  <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
  </button>
  <button onclick="window.location='movies.php';"
          style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">Movies
  </button>
  <button onclick="window.location='news.php';" class="buttonBig">News</button>
  <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
    <button onclick="window.location='employee_administration.php';" class="buttonBig">Employees</button>
    <button onclick="window.location='hall_administration.php';" class="buttonBig">Halls</button>
    <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'"
          class="buttonLogin">
    Sign In
  </button>
  <button id="register" onclick="window.location='register.php';"
          class="buttonRegister">Register
  </button>
</div>
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
    <?php
    // check if search view of list view
    if (isset($_GET['searchTitle'])) {
        $sql = "SELECT * FROM screening NATURAL JOIN film WHERE title like '%" . $_GET['searchTitle'] . "%'";
    } else if (isset($_GET['searchFilmID'])) {
        $sql = "SELECT * FROM screening NATURAL JOIN film WHERE film_id like '" . $_GET['searchFilmID'] . "'";
    } else {
        $sql = "SELECT * FROM screening NATURAL JOIN film";
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
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<tr>";
            echo "<td>" . $row['screening_id'] . "</td>";
            echo "<td>" . $row['hall_id'] . "</td>";
            echo "<td>" . $row['film_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['starting_time'] . "</td>";
            echo "<td>" . $row['duration'] . "</td>";
            if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                echo "<td><a href=\"updatescreening.php?screening_id=" . $row['screening_id'] . "&hall_id=" . $row['hall_id'] . "&film_id=" . $row['film_id'] . "&starting_time=" . $row['starting_time'] . "&duration=" . $row['duration'] . "\"> UPDATE </a></td>";
                echo "<td><a href=\"deletescreening.php?id=" . $row['screening_id'] . "\"> DELETE </a></td>";
            }
            echo "<td><a href=\"movies.php?searchFilmID=" . $row['film_id'] . "\"> Show Film Details </a></td>";
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo "<td><a href=''> BUY TICKET </a></td>";
            }

            echo "</tr>";
        }
    }
    $row_cnt = mysqli_num_rows($result);


    ?>
    </tbody>
  </table>

  <div><?php echo $row_cnt ?> Screening/s found!</div>


  <br>

  <div id="insertScreening">
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
            <input id='screening_id' name='screening_id' type='text' size='10'
                   value='<?php echo $_GET['screening_id']; ?>'/>
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
                   value='<?php echo $_GET['starting_time']; ?>'/>
          </td>
          <td>
            <input id='duration' name='duration' type='text' size='20'
                   value='<?php echo $_GET['duration']; ?>'/>
          </td>
        </tr>
        </tbody>
      </table>
      <input id='insert' type='submit' value='Insert!'/>
    </form>
  </div>

    <?php
    //Handle insert
    if (isset($_GET['screening_id']) && !empty($_GET['screening_id'])) {

        //Prepare insert statementd
        $sql = "INSERT INTO screening VALUES(" . $_GET['screening_id'] . ",'" . $_GET['hall_id'] . "','" . $_GET['film_id'] . "','" . $_GET['starting_time'] . "','" . $_GET['duration'] . "')";


        //Parse and execute statement
        if ($conn->query($sql) === TRUE) {
            echo "New record created succesfully";
            header("location: screening.php");

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }


    ?>

</div>

<?php


echo("<script type=\"text/javascript\">hideFormInsertScreening();</script>");

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
}
?>


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


<?php $conn->close(); ?>
</body>
</html>