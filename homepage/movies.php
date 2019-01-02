<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cinebase</title>
  <link rel="stylesheet"
        type="text/css"
        href="css/main.css"/>
  <script src="js/main.js"></script>
</head>
<body>

<?php
session_start();
error_reporting(0);

$user = 'root';
$pass = '';
$database = 'cinebase';

// establish database connection
$conn = new mysqli('localhost', $user, $pass, $database) or die("dead");

?>

<div class="wrapper">
  <div class="topLine" id="topLine">
    cinebase
    <button onclick="window.location='index.php';" style="margin-left: 20px" class="buttonBig">Home
    </button>
    <button onclick="window.location='movies.php';"
            style="border-bottom: 2px solid whitesmoke; font-weight: bold" class="buttonBig">Movies
    </button>
    <button onclick="window.location='screening.php';" class="buttonBig">Screenings</button>
    <button onclick="window.location='news.php';" class="buttonBig">News</button>
    <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
      <?php if (isset($_SESSION['loggedinAdmin']) && $_SESSION['loggedinAdmin'] == true) {
          echo "<button onclick=\"window.location='employee_administration.php';\" class=\"buttonBig\">Employees</button>";
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
    <button onclick="window.location='screening.php';" class="buttonShowScreenings">Show all current
      screenings
    </button>


    <br><br>
    <div>
      <form id='searchform' action='movies.php' method='get'>
        <a href='movies.php'>All Films</a> ---
        Search for title:
        <input class='searchTitle' id='searchTitle' name='searchTitle' type='text' size='20'
               value='<?php echo $_GET['searchTitle']; ?>'/>
        <input id='search' type='submit' value='Search!'/>
      </form>
      <br>
    </div>
      <?php
      // check if search view of list view
      if (isset($_GET['searchTitle'])) {
          $sql = "SELECT * FROM film WHERE title like '%" . $_GET['searchTitle'] . "%'";
      } else if (isset($_GET['searchFilmID'])) {
          $sql = "SELECT * FROM film WHERE film_id like '" . $_GET['searchFilmID'] . "'";
      } else {
          $sql = "SELECT * FROM film";
      }
      $result = $conn->query($sql);

      ?>


    <table style="float:none; border: 1px solid #DDDDDD">
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
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

              echo "<tr>";


              echo "<td>" . $row['film_id'] . "</td>";
              echo "<td>" . $row['title'] . "</td>";
              echo "<td>" . $row['director'] . "</td>";
              echo "<td>" . $row['country'] . "</td>";
              echo "<td>" . $row['film_language'] . "</td>";
              echo "<td>" . $row['age_rating'] . "</td>";
              if (isset($_SESSION['loggedinEmployee']) && $_SESSION['loggedinEmployee'] == true) {
                  echo "<td><a href=\"updatefilm.php?film_id=" . $row['film_id'] . "&title=" . $row['title'] . "&director=" . $row['director'] . "&country=" . $row['country'] . "&film_language=" . $row['film_language'] . "&age_rating=" . $row['age_rating'] . "\"> UPDATE </a></td>";
                  echo "<td><a href=\"deletefilm.php?id=" . $row['film_id'] . "\"> DELETE </a></td>";
              }
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

    <div id="insertMovie">
      <form id='insertform' action='movies.php' method='get'>
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
              <input class="inputFilmID" id='film_id' name='film_id' type='text' size='10'
                     value='<?php echo $_GET['film_id']; ?>'/>
            </td>
            <td>
              <input id='title' name='title' type='text' size='20'
                     value='<?php echo $_GET['title']; ?>'/>
            </td>
            <td>
              <input id='director' name='director' type='text' size='20'
                     value='<?php echo $_GET['director']; ?>'/>
            </td>
            <td>
              <input class="inputCountry" id='country' name='country' type='text' size='20'
                     value='<?php echo $_GET['country']; ?>'/>
            </td>
            <td>
              <input class="inputLanguage" id='film_language' name='film_language' type='text'
                     size='20'
                     value='<?php echo $_GET['film_language']; ?>'/>
            </td>
            <td>
              <input class="inputAge" id='age_rating' name='age_rating' type='text' size='20'
                     value='<?php echo $_GET['age_rating']; ?>'/>
            </td>
          </tr>
          </tbody>
        </table>
        <input id='insert' type='submit' value='Insert!'/>
      </form>
    </div>

      <?php
      //Handle insert
      if (isset($_GET['film_id']) && !empty($_GET['film_id'])) {

          //Prepare insert statementd
          $sql = "INSERT INTO film VALUES(" . $_GET['film_id'] . ",'" . $_GET['title'] . "','" . $_GET['director'] . "','" . $_GET['country'] . "','" . $_GET['film_language'] . "','" . $_GET['age_rating'] . "')";


          //Parse and execute statement
          if ($conn->query($sql) === TRUE) {
              echo "New record created succesfully";
              header("location: movies.php");

          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }

      }


      ?>








      <?php $conn->close(); ?>

  </div>
</div>

<?php

echo("<script type=\"text/javascript\">hideFormInsertMovie();</script>");

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


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<p style="text-align:center">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>


</body>
</html>